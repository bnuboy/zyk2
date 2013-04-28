<?php
include_once "_adminController.php";

class Admin_manager extends AdminController {

    function __construct() {
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->model('Admin_Manager_Model');
        $this->load->model('Admin_Manager_Group_Model');
        $this->load->model('Admin_Manager_Menu_Model');
        $this->load->model('Admin_Manager_Groupmenu_Model');
        //$this->load->model('Study_Ico_Model');
    }

    /*
    * 管理员列表
    */
    function managerlist() {
        $get = $this->input->get();
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $where = 'id > 0';
        $list = $this->Admin_Manager_Model->getAll($where, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize );
        $count = $this->Admin_Manager_Model->getCount( $where );
        foreach($list as $k => $v){
            $list[$k]['user']  = $this->User_Model->getOne("`id` = '".$v['user_id']."'");
            $list[$k]['group'] = $this->Admin_Manager_Group_Model->getOne("`id` = '".$v['manager_group_id']."'");
        }
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showAdmin_1();
        $this->setComponent( 'managerlist', array('list' => $list, "pagination" => $pagination, 'count' => $count, 'get' => $get) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 新增管理员
    */
    function manageradd(){
        if($_POST){
            $post = $this->input->post();
            $data = $this->Admin_Manager_Model->getOne("user_id = '".$post['user_id']."'");
            if($data) Util::jumpback('管理员已存在！');
            $this->Admin_Manager_Model->insert( $post );
            Util::redirect('/admin_manager/managerlist');
        }
        $groups = $this->Admin_Manager_Group_Model->getAll();
        $users = $this->User_Model->getAll();
        $this->setComponent( 'manageradd', array('groups' => $groups,'users'=>$users) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 编辑管理员
    */
    function manageredit( $id ) {
        if($_POST){
            $post=array();
            if($_POST['user_id'] != $id) Util::jumpback('您修改的不是此用户，请重新选择');
            $post['manager_group_id']=$_POST['manager_group_id'];
            $this->Admin_Manager_Model->update( $post, "user_id = " . $_POST['user_id'] );
            Util::redirect('/admin_manager/managerlist');
        }
        $data = $this->Admin_Manager_Model->getOne("`id` = '".$id."'");
        $groups = $this->Admin_Manager_Group_Model->getAll();
        $users = $this->User_Model->getAll();
        $this->setComponent( 'manageredit', array('data' => $data, 'groups' => $groups, 'users' => $users ) );
        $this->showTemplate( 'admin_base' );
    }
    
    /*
    * 改变状态 
    */
    function managerchangestatus() {
        $status = Util::getPar('status');
        $url = $_SERVER['HTTP_REFERER'];
        if($_POST){
            $ids = $this->input->post('ids');
            if(empty($ids)){
                Util::redirect($url, '请选择要改变状态的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect($url, '请选择要改变状态的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $data = array(
            'enabled' => $status
        );
        $this->Admin_Manager_Model->update($data, $where);
        Util::redirect($url);
    }

    /*
    * 删除管理员
    */
    function managerdel() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect('/admin_manager/managerlist', '请选择要删除的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect('/admin_manager/managerlist', '请选择要删除的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->Admin_Manager_Model->delete($where);
        Util::redirect('/admin_manager/managerlist');
    }

    /*
    * 群组列表
    */
    function grouplist() {
        $list = $this->Admin_Manager_Group_Model->getAll();
        $count = $this->Admin_Manager_Group_Model->getCount();
        $this->setComponent( 'grouplist', array('list' => $list) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 新增群组
    */
    function groupadd(){
        if($_POST){
            $post = $this->input->post();
            $this->Admin_Manager_Group_Model->insert($post);
            Util::redirect('/admin_manager/grouplist');
        }
        $this->setComponent('groupadd');
        $this->showTemplate('admin_base');
    }

    /*
    * 编辑群组
    */
    function groupedit( $id ) {
        if($_POST){
            $post = $this->input->post();
            $this->Admin_Manager_Group_Model->update( $post, "id = " . $id );
            Util::redirect('/admin_manager/grouplist');
        }
        $data = $this->Admin_Manager_Group_Model->getOne("`id` = '".$id."'");
        $this->setComponent( 'groupedit', array('data' => $data) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 删除群组
    */
    function groupdel( $id ) {
        //删除群组
        $this->Admin_Manager_Group_Model->delete("id = " . $id );
        //删除群组对应权限菜单
        $this->Admin_Manager_Groupmenu_Model->delete("`group_id` = '".$id."'");
        Util::redirect('/admin_manager/grouplist');
    }

    /*
    * 菜单列表
    */
    function menulist() {
        $menus = $this->Admin_Manager_Menu_Model->getTrees();
        $this->setComponent( 'menulist', array('menus' => $menus) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 添加菜单
    */
    function menuadd($default_f_id = 0) {
        if($_POST){
            $post = $this->input->post();
            $this->Admin_Manager_Menu_Model->insert( $post );
            Util::redirect('/admin_manager/menulist');
        }
        $menus = $this->Admin_Manager_Menu_Model->getTrees();
        $this->setComponent('menuadd', array('menus' => $menus, 'default_f_id' => $default_f_id ));
        $this->showTemplate('admin_base');
    }

    /*
    * 修改菜单
    */
    function menuedit( $id ) {
        if($_POST){
            $this->Admin_Manager_Menu_Model->update( $this->input->post(), "id = " . $id );
            Util::redirect('/admin_manager/menulist');
        }
        $menus = $this->Admin_Manager_Menu_Model->getTrees();
        $data = $this->Admin_Manager_Menu_Model->getOne( array("id" => $id) );
        $this->setComponent( 'menuedit', array('data' => $data, 'menus' => $menus) );
        $this->showTemplate( 'admin_base' );
    }
    
    /*
    * 删除菜单
    */
    function menudel( $id ) {
        //判断是否有下级菜单
        if($this->Admin_Manager_Menu_Model->isHaveChild($id)){
            Util::redirect('/admin_manager/menulist', '此菜单下含有子菜单，请先删除子菜单！');
        }
        //删除菜单
        $this->Admin_Manager_Menu_Model->delete("`id` = '".$id."'");
        Util::redirect('/admin_manager/menulist');
    }

    /*
    * 分配节点
    */
    function setmenu( $groupid ) {
        if($_POST){
            $menus    =  $_POST["menus"];
            $roleId   =  $_POST["roleId"];
            //清除已有节点
            $this->Admin_Manager_Groupmenu_Model->delete("`group_id` = '".$groupid."'");
            //分配新节点
            if(is_array($menus)){
                foreach($menus as $item){
                    $data = array('group_id' => $groupid, 'menu_id' => $item['id']);
                    $this->Admin_Manager_Groupmenu_Model->insert($data);
                }
            }
            die();
        }
        //所有节点
       if($groupid=='5'){
                $power_view='organization';
            }else {
                $power_view='system';
        }
        $where= "(`view` = '".$power_view."' OR `view` like '".$power_view.",%' OR `view` like '%,".$power_view."' OR `view` like '%,".$power_view.",%')";
        $nodes = $this->Admin_Manager_Menu_Model->getAll($where,'*','order asc');
        //已有节点
        $roleNodeIds = $this->Admin_Manager_Group_Model->getGroupMenuIds($groupid);
        $this->setComponent( 'setmenu', array('nodes' => $nodes, 'roleNodeIds' => $roleNodeIds, 'groupid' => $groupid ) );
        $this->showTemplate( 'none' );
    }

//    /*
//     * 设置ico图标和title
//     */
//    function editico(){
//        if($_POST){
//            $_POST['created']=date("Y-m-d H:i:s",time());
//            $this->Study_Ico_Model->insert($_POST);
//            Util::redirect('/admin_manager/editico');
//        }
//        $this->setComponent( 'setico' );
//        $this->showTemplate( 'admin_base' );
//    }


}