<?php
class StudyController extends CI_Controller {
 
    private $_views;     //保存视图数据
    private $_component; //组件
    public  $user;       //用户
    public  $course;     //当前课程
    
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('Util');
        $this->load->library( 'adminpagination' );
        $this->load->model('Study_Course_Menu_Model');
        $this->load->model("Study_Select_Course_Model");
        $this->load->model("Study_Course_Join_Teacher_Model");
        //判断用户是否登陆
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            Util::redirect( '/', '请先登录' );
        }
        $this->user = $_SESSION['user'];

        //判断是否选择课程
        if(!empty($_GET['course_id'])){
            $this->load->model( 'Study_Course_Model' );
            $course = $this->Study_Course_Model->getOne("`id` = '".$_GET['course_id']."'");
            $_SESSION['course'] = $course;
            $this->course = $course;
        }else if(isset($_SESSION['course']) && !empty($_SESSION['course'])){
            $this->course = $_SESSION['course'];
        }else{
            Util::redirect( '/', '请选择课程' );
        }
       //权限  
       if ( $this->user[ 'type' ] == "teacher" )
            {
                $mycourse = $this->Study_Course_Join_Teacher_Model->getOne( "`course_id` = " . $this->course[ 'id' ] . " AND `teacher_id` = " . $this->user[ 'id' ] );
                if ( $mycourse )
                {
                    $this->Jurisdiction( '10003' );
                }
                else
                {
                    $teacher_part = $this->Study_Select_Course_Model->getOne( '`user_id` = ' . $this->user[ 'id' ] . " AND `course_id` = " . $this->course[ 'id' ], 'course_part_id' );
                    if ( !empty( $teacher_part[ 'course_part_id' ] ) )
                    {
                        $this->Jurisdiction( $teacher_part[ 'course_part_id' ] );
                    }
                    else
                    {
                        Util::redirect( '/ucenter_course/mycourseselect', '请先申请该课程' );
                    }
                }
            }
            else
            {
                $user_part = $this->Study_Select_Course_Model->getOne( '`user_id` = ' . $this->user[ 'id' ] . " AND `course_id` = " . $this->course[ 'id' ], 'course_part_id' );
                if ( !empty( $user_part[ 'course_part_id' ] ) )
                {
                    $this->Jurisdiction( $user_part[ 'course_part_id' ] );
                }
                else
                {
                    Util::redirect( '/ucenter_course/mycourseselect', '请先申请该课程' );
                }
            }
    }

  /*
   * 学习中心权限
   * @param $power 角色可使用的菜单
   * @param $menu_url 当前用户访问的类名class 和 方法名 action
   */

  function Jurisdiction($user_type){
    $this->load->model("Study_Course_Groupmenu_Model");
    $this->load->model("Study_Course_Menu_Model");
    $power=array();
    $power_id=array();
    $menu_id= $this->Study_Course_Groupmenu_Model->getAll("`user_type` = " .$user_type." AND `course_id`= ".$this->course['id'],'menu_id');
    foreach($menu_id as $menu){
        $menu_info = $this->Study_Course_Menu_Model->getOne( array('id' => $menu[ "menu_id" ]) );
        if($menu_info["f_id"]=='0')$power_id[]=$menu_info['id'];
        $Classname=$menu_info['controller'];
        $ActionName =$menu_info['action'] ;
        $power[ $Classname ][ ] = $ActionName;
    }
    $_SESSION['power_id'] = implode(',', $power_id);
    $menu_url = explode( "/", $this->uri->uri_string() );
    if ( !isset( $power[ $menu_url[ '0' ] ] ) ){
      //echo "无权限1";
      self::errorPowerMsg();
	  die();
    }
    if ( isset( $menu_url[ '1' ] ) && !in_array( $menu_url[ '1' ], $power[ $menu_url[ '0' ] ] ) ){
      self::errorPowerMsg();
	  //echo "无权限2";
      die();
    }
  }

    
    /*
    * URL分段名
    */
    function getUrlSectionName($num){
        return $this->uri->segment($num);
    }
    
    /*
    *  返回视图数据赋值到变量,不输出
    */
    function setModule( $view, $data = false ) {
        $this->_views[ $view ] = $this->load->view( "modules/" . $view, $data, true );
    }

    /*
    *  显示视图
    */
    function setComponent( $view, $data = false ) {//print_r( $this );
        $class_name = strtolower( get_class( $this ) );
        $data['user'] = $this->user;
        $this->_component = $this->load->view( "components/study/" . $class_name . "/" . $view, $data, true );
    }

    /*
    * 选择视图框架
    */
    function showTemplate( $templates, $title = false, $keywords = false, $description = false ) {
        //变量定义
        $topMenu           = '';  //当前顶级菜单
        $currentTopMenuId  = '';  //当前顶级菜单ID
        $currentLeftMenuId = '';  //当前左侧菜单ID
        //当前链接菜单
        $currentMenu = $this->Study_Course_Menu_Model->getOne("`controller` = '".self::getUrlSectionName(1)."' AND `action` = '".self::getUrlSectionName(2)."'");
        if($currentMenu['level'] == 3){
            $currentLeftMenuId = $currentMenu['f_id'];
        }else if($currentMenu['level'] == 2){
            $currentLeftMenuId = $currentMenu['id'];
        }
        //当前顶级菜单
        $topMenu = $this->Study_Course_Menu_Model->getTopMenu($currentMenu['id']);
        $currentTopMenuId = $topMenu['id'];
        //所有顶级菜单
        $topMenus = $this->Study_Course_Menu_Model->getAll("`f_id` = 0 AND `id` in(".$_SESSION['power_id'].")", "*", "`order` ASC");
        //$topMenus = $this->Study_Course_Menu_Model->getAll("`f_id` = 0", "*", "`order` ASC");
        $this->setModule( 'study_menus', array("topMenus" => $topMenus, "currentTopMenuId" => $currentTopMenuId, 'user' => $this->user) );
        //左侧导航视图
        $left_menus = $this->Study_Course_Menu_Model->getAll("`f_id` = '".$currentTopMenuId."'", "*", "`order` ASC");//print_r($topMenus);
        $this->setModule( 'study_left', array("left_menus" => $left_menus, "currentLeftMenuId" => $currentLeftMenuId, 'user' => $this->user) );
        //print_r($this->_views);
        //构造视图框架返回数据
        $result = array(
            'component'   =>  $this->_component,
            'modules'     =>  $this->_views,
            'title'       => $title,
            'keywords'    => $keywords,
            'description' => $description,
            'user'        => $this->user,
            'course'      => $this->course
        );
        $this->load->view( "templates/" . $templates, $result );
    }



  function AJAXSuccess( $data = '' )
  {
    $ajax_data = new stdClass();
    $ajax_data->status = "ok";
    $ajax_data->data = $data;
    echo json_encode( $ajax_data );
  }

  function AJAXFail( $msg = '' )
  {
    $ajax_data = new stdClass();
    $ajax_data->status = "error";
    $ajax_data->data = $msg;
    echo json_encode( $ajax_data );
  }



	function errorPowerMsg(){
        $beforeurl = $_SERVER['HTTP_REFERER'];
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
        echo '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
        echo '<head>'."\n";
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n";
        echo '<title>权限信息提示</title>'."\n";
        echo '</head>'."\n";
        echo '<body>'."\n";
        echo '<div style="margin:0 auto;width:500px;text-align:center; font-size:12px;">'."\n";
        echo '<p><p><p><br><p><p><p>'."\n";
        echo '<h2 style="font-size:14px; color:#e00000;">您没有此操作权限</h2>'."\n";
        echo '系统将 <input type="text" style="width:10px;" readonly="true" value="3" id="time">秒钟后自动返回！' ."\n";
        echo '</div>'."\n";
        echo '</body>'."\n";
        echo '<html>'."\n";
        echo '<script language="javascript">                      '."\n";
        echo '  var t = 3;                                        '."\n";
        echo '  var time = document.getElementById("time");       '."\n";
        echo '  function fun(){                                   '."\n";
        echo '      t--;                                          '."\n";
        echo '      time.value = t;                               '."\n";
        echo '      if(t<=0){                                     '."\n";
        echo '          location.href = "'.$beforeurl.'";         '."\n";
        echo '          clearInterval(inter);                     '."\n";
        echo '      }                                             '."\n";
        echo '  }                                                 '."\n";
        echo '  var inter = setInterval("fun()",1000);            '."\n";
        echo '</script>                                           '."\n";       
        die();		
    }


}
