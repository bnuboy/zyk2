<?php
include_once '_ucenterController.php';

class Ucenter_User extends UcenterController
{
        
    function __construct() {
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->model('School_Organization_Model');
        $this->load->model('User_Login_Log_Model');
    }

    /*
    * 编辑个人信息
    */
    function myinfoedit() {
        if($_POST){
            $data = $_POST['data'];
            $this->User_Model->update($data, "id = " . $this->user['id']);
            $_SESSION['user'] = $this->User_Model->getOne("id = " . $this->user['id']);
            Util::redirect('/ucenter_user/myinfoedit', '修改成功！');
        }
        $user = $this->User_Model->getOne("`id` = '".$this->user['id']."'");
        $org = $this->School_Organization_Model->getOne("`id` = '".$this->user['organization_id']."'");
        $this->setComponent( 'myinfoedit', array('user' => $user, 'org' => $org) );
        $this->showTemplate( 'ucenter_base' );
    }

    /*
    * 修改我的密码
    */
    function repassword() {
        if($_POST){
            $oldpassword =  $_POST['oldpassword']; 
            $newpassword =  $_POST['newpassword']; 
            $user = $this->User_Model->getOne("`id` = '".$this->user['id']."'");
            if($user['password'] != md5($oldpassword)) Util::redirect('/ucenter_user/repassword', '原始密码不正确！');
            $data = array(
                'password' => md5($newpassword)
            );
            $this->User_Model->update($data, "id = " . $this->user['id']);
            Util::redirect('/ucenter_user/myinfoedit', '修改成功！');
        }
        $this->setComponent( 'repassword' );
        $this->showTemplate( 'ucenter_base' );
    }
    
    /*
    * 登陆日志
    */
    function myloginlog(){
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        //构造条件
        $where = array();
        $where[] = "`user_id` = '".$this->user['id']."'";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->User_Login_Log_Model->getAll($condition, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->User_Login_Log_Model->getCount( $condition );
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showWeb_1();
        //构造返回
        $result = array(
            'list'       => $list, 
            'count'      => $count,
            'pagination' => $pagination,
            'pagesize'   => $pagesize,
            'PB_page'    => $PB_page
        );
        $this->setComponent( 'myloginlog' , $result );
        $this->showTemplate( 'ucenter_base' );
    }
    
    
}