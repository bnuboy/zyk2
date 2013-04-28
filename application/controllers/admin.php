<?php

class Admin extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("User_Model");
        $this->load->model("User_Login_Log_Model");
        $this->load->model("User_Login_Log_Model");
        $this->load->model("Admin_Manager_Model");
        $this->load->model("Admin_Manager_Group_Model");
        $this->load->helper('Util');
        $this->load->library('imgcode');
    }

    /*
    *  首页
    */
    function index() {
        //判断用户是否登陆
        if (isset($_SESSION['admin']) && !empty($_SESSION['admin'])) {
        	if($_SESSION['admin_type'] == "指导教师"){
        		Util::redirect('/admin_resource_library/librarylist');
        	}else{
            	Util::redirect( '/admin_home/index' );
        	}
        }
        $this->load->view( 'admin_login' );
    }

    /*
    * 登陆
    */
    function login() {
        //参数
        $login_name = isset($_POST['login_name']) ? $_POST['login_name'] : '';
        $password   = isset($_POST['password']) ? $_POST['password'] : '';
        $code       = isset($_POST['code']) ? $_POST['code'] : '';
        //验证
        if(!empty($login_name) && !empty($password)){
            if ( !$this->imgcode->check(trim($code))){
                echo '1'; //验证码错误
            }else{
                $user = $this->User_Model->getOne("`login_name` = '".$login_name."'");
                if(empty($user)) {
                    echo '4'; //用户名错误 
                }else if($user['password'] != md5($password)){
                    echo '2'; //密码错误
                }else{
                    $admin = $this->Admin_Manager_Model->getOne("`user_id` = '".$user['id']."' AND `enabled` = 'y'");
                    
                    if(empty($admin)) {
                        echo '5'; //你没有管理权限
                    }else{
                        //修改登录信息
                        $type = $this->Admin_Manager_Group_Model->getOne("`id`='".$admin['manager_group_id']."'");
                        $data = array(
                            'last_login_time' =>  date('Y-m-d H:i:s', time()),
                            'last_login_ip'   => $_SERVER['REMOTE_ADDR']
                        );
                        $this->Admin_Manager_Model->update($data, "`user_id` = '".$user['id']."'");
                        //登陆成功记录登陆日志
                        $data = array(
                            'user_id'    => $user['id'],
                            'login_time' => date('Y-m-d H:i:s', time()),
                            'login_ip'   => $_SERVER['REMOTE_ADDR']
                        );
                        $log_id = $this->User_Login_Log_Model->insert($data);
                        $user['log_id']=$log_id;
                        $_SESSION['admin'] = $user;
                        $_SESSION['admin_type'] = $type['name'];
                        //$_SESSION['user'] = $user;
                    if($_SESSION['admin_type'] == "指导教师"){
		        		echo 'okt';
		        	}else{
		            	echo 'ok';
		        	}
                        //echo 'ok';
                    }
                }
            }
        }else{
            echo '请使用正确的用户名和密码登录'; //请输入用户名或密码
        }
        die();
    }


    /*
    * 退出登陆
    */
    function logout() {
        $_SESSION['admin'] = "";
        Util::redirect("/admin/index");
    }


}