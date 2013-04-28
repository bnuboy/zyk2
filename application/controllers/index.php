<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Index extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("User_Model");
        $this->load->model('Resource_Info_Model');
        $this->load->model( "Study_Course_Model" );
        $this->load->model("User_Login_Log_Model");
        $this->load->helper('Util');
        $this->load->model('School_Organization_Model');
        $this->load->model('Sys_Notice_Model');
        $this->load->library('imgcode');
    }
    
    /*
    *  首页
    */
    function index() {
        //所有院系
        $organizations = $this->School_Organization_Model->getAll("`f_id` = 0 AND `enabled` = 'y'", "*", "`order` ASC, id DESC");
        //资源数
        $resourcecount = $this->Resource_Info_Model->getCount();
        //课程数
        $coursecount = $this->Study_Course_Model->getCount();
        //用户数
        $usercount = $this->User_Model->getCount();
        //系统公告
        $notice = $this->Sys_Notice_Model->getAll("`target` = 'all'", '*', '`top` DESC, `level` ASC, `id` DESC', 10,0);
        $result = array(
            'organizations' => $organizations,
            'resourcecount' => $resourcecount,
            'coursecount'   => $coursecount,
            'usercount'     => $usercount,
            'notice'        => $notice
        );    
        $this->load->view( 'index', $result );
    }


    /*
    * 登陆
    */
    function login() {
        //参数
        $login_name = $_POST['login_name'];
        $password   = $_POST['password'];
        $code       = $_POST['code'];
        //验证
        if(!empty($login_name) && !empty($password)){
            if ( !$this->imgcode->check(trim($code))){
                echo '1'; //验证码错误
            }else{
                $user = $this->User_Model->getOne("`login_name` = '".$login_name."' AND `enabled` = 'y'");
                if(empty($user)) {
                    echo '4'; //用户名错误 
                }else if($user['password'] != md5($password)){
                    echo '2'; //密码错误
                }else{
                    //登陆成功记录登陆日志
                    $data = array(
                        'user_id'    => $user['id'],
                        'login_time' => date('Y-m-d H:i:s', time()),
                        'login_ip'   => $_SERVER['REMOTE_ADDR']
                    );
                    $log_id=$this->User_Login_Log_Model->insert($data);
                    $user['log_id']=$log_id;
                    $_SESSION['user'] = $user;
                    echo 'ok';
                }
            }
        }else{
            echo '3'; //请输入用户名或密码
        }
        die();
    }
    
    /*
    * 显示登陆后用户信息
    */
    function getloginfo(){
        echo '<div class="inputbox ">欢迎'.$_SESSION['user']['name'].'登陆</div>';
        echo '<div class="inputbox "><a href="/ucenter_course/mycourseselect">进入个人中心</a></div>';
        echo '<div class="inputbox ">';
        echo '<div class="loginyz"><a href="/index/logout">退出</a></div>';
        echo '</div>';
        die();
    }
    
    /*
    * 用户注册
    */
    function register(){
        if($_POST){
            $data = $_POST['data'];
            $data['password'] = md5($data['password']);
            $data['created']  = date('Y-m-d H:i:s', time());
            $data['enabled']  = 'n';
            $userid = $this->User_Model->insert($data);
            //$_SESSION['user'] = $this->User_Model->getOne("id = " . $userid);
            Util::redirect('/', "注册成功请等待管理员审核");
        }
        //所有院系
        $organizations = $this->School_Organization_Model->getAll("`f_id` = 0 AND `enabled` = 'y'");
        $result = array(
            'organizations' => $organizations
        );
        $this->load->view( 'register', $result );
    }
    /**
     * 学生注册
     */
    function register_stu(){
    	if($_POST){
            $data = $_POST['data'];
            $data['password'] = md5($data['password']);
            $data['created']  = date('Y-m-d H:i:s', time());
            $data['enabled']  = 'n';
            $userid = $this->User_Model->insert($data);
            //$_SESSION['user'] = $this->User_Model->getOne("id = " . $userid);
            Util::redirect('/', "注册成功请等待管理员审核");
        }
        //所有院系
        $organizations = $this->School_Organization_Model->getAll("`f_id` = 0 AND `enabled` = 'y'");
        $result = array(
            'organizations' => $organizations
        );
        $this->load->view( 'register_stu', $result );
    }
	/**
     * 老师注册
     */
    function register_tea(){
    	if($_POST){
            $data = $_POST['data'];
            $data['password'] = md5($data['password']);
            $data['created']  = date('Y-m-d H:i:s', time());
            $data['enabled']  = 'n';
            $userid = $this->User_Model->insert($data);
            //$_SESSION['user'] = $this->User_Model->getOne("id = " . $userid);
            Util::redirect('/', "注册成功请等待管理员审核");
        }
        //所有院系
        $organizations = $this->School_Organization_Model->getAll("`f_id` = 0 AND `enabled` = 'y'");
        $result = array(
            'organizations' => $organizations
        );
        $this->load->view( 'register_tea', $result );
    }
    
    /*
    * 验证是否存在
    */
    function checkreg(){
        $data = Util::getPar('data');
        $type = Util::getPar('type');
        if($type == 'student_id')  $where = "`student_id` = '".$data['student_id']."'";
        if($type == 'login_name')  $where = "`login_name` = '".$data['login_name']."'";
        if($type == 'email')  $where = "`email` = '".$data['email']."'";
        $user = $this->User_Model->getOne($where);
        if($user){
            echo 'false';
        }else{
            echo 'true';
        }
        die();
    }
    
    
    
    /*
    * 忘记密码
    */
    function forgetpass(){
        $this->load->view( 'forgetpass' );
    }
    
    function getCode()
  {
    $this->load->library( 'imgcode' ); //调用验证码
    $this->imgcode->image( '1', '5' );
  }
    /*
    * 退出登陆
    */
    function logout() {
        /*
        $this->load->model( "User_Login_Log_Model" );
        $log = $this->User_Login_Log_Model->getOne( array('id' => $_SESSION[ 'user' ]["log_id"]) );
        $time=abs( time() - strtotime( $log["login_time"] ) );
        $data = array(
            'out_time' => date( "Y-m-d H:i:s", time() ),
            'timer' => str_pad( floor( $time%3600/60),2,0,STR_PAD_LEFT)
        );
        $this->User_Login_Log_Model->update( $data, 'id =' . $_SESSION[ 'user' ]["log_id"] );
        */
        $_SESSION['user'] = "";
        Util::redirect("/index/index");
    }
   function reg_key()
  {
    if ( $this->input->post() )
    {
      // 获取邮件配置信息
      $this->config->load( 'email' );
      $setemail = $this->config->item( 'setemail' ); // 配置参数
      $smtpemailto = $this->input->post( 'email' ); //收件人邮箱
      $newpwd = substr( time(), 4 ) . rand( 1000, 10000 );
      //echo $smtpemailto;
      //die ;
      $mailcontent = "<p>尊敬的[" . $smtpemailto . "],您好：</br>
				您的密码将被重置为：" . $newpwd . "，</br>
				<a href='http://zyk.hncc.edu.cn/index/reg_keysucc?email=" . base64_encode( $smtpemailto ) . "&pwd=" . $newpwd . "&newpwd=" . base64_encode( $newpwd ) . "&key=" . urlencode( time() ) . "' target='_blank' title='点击密码重置'>点击重置密码，</a>此操作在24小时以内有效。</br>
			如果您不需要密码，或者您从未点击过“忘记密码”按钮，请忽略本邮件。
			" . $setemail[ 'hotel' ] . "。</br>
			</p>";

      //发送邮件
      $this->load->library( 'email' );
      $this->email->initialize( $setemail );
      $this->email->from( $setemail[ 'smtp_user' ], '资源平台' );
      $this->email->to( $smtpemailto ); //收件人
      $this->email->subject( '忘记密码提示（zyk.hncc.edu.cn）' );
      $this->email->message( $mailcontent );
      $this->email->send();
      $this->reg_keymail( $this->input->post( 'email' ) );
      $this->load->view( 'forgetpasssuccess' );
    }
    else
    {
      $this->load->view( 'forgetpass' );
    }
  }

  /**
   * 找回密码重置
   */
  function reg_keysucc()
  {
    //是否在有效时间内
    $time = $this->input->get( 'key' );
    $pwd = $this->input->get( 'pwd' );
    $newpwd = base64_decode( $this->input->get( 'newpwd' ) );
    $email = base64_decode( $this->input->get( 'email' ) );

    if ( $time > strtotime( "-24 hours" ) )
    {
      //加密密码与未加密密码是否相同
      if ( $newpwd == $pwd )
      {
        //数据库是否存在此email
        $this->load->model( array('usermodel') );
        $where = array('email' => $email);
        $res = $this->usermodel->getInfo( $where );
        if ( $res )
        {
          $this->usermodel->update( array('password' => md5( $newpwd )), array('id' => $res->id) );
         // $msg = '密码已重置，操作成功！';
          echo "<script>alert('密码已重置，操作成功!');location.href='http://zyk.hncc.edu.cn';</script>";
          //Util::redirect('zyk.hncc.edu.cn');
        }
        else
        {
         // $msg = '此账号不存在，重置失败！';
          echo "<script>alert('此邮箱不存在，重置失败！');location.href='http://zyk.hncc.edu.cn';</script>";
        }
        //更改数据库
      }
      else
      {
       // $msg = '密码链接被修改，重置失败！';
        echo "<script>alert('密码链接被修改，重置失败！');location.href='http://zyk.hncc.edu.cn';</script>";
      }
    }
    else
    {
     // $msg = '此操作超出有效时间，重置失败！';
      echo "<script>alert('此操作超出有效时间，重置失败！');location.href='http://zyk.hncc.edu.cn';</script>";
    }
    //echo $msg;
  }

  function reg_keymail( $email )
  {
    $emarr = array(
        'qq.com', '163.com', '126.com', '189.com', 'yeah.net', '263.com', 'sina.com', 'gmail.com'
    );
    $emhttp = array(
        'https://mail.qq.com/',
        'http://mail.163.com/',
        'http://mail.126.com/',
        'http://webmail30.189.cn/webmail/',
        'http://mail.yeah.net/',
        'http://www.263.net/',
        'http://mail.sina.com.cn/',
        'http://www.gmail.com'
    );
    $e = explode( "@", $email );
    $urlemail = '';
    foreach ( $emarr as $key => $val )
    {
      if ( $e[ '1' ] == $val )
        $urlemail = $emhttp[ $key ];
    }
    //$this->_view(__FUNCTION__,array('email'=>$email,'urlemail'=>$urlemail));
  }

    
}