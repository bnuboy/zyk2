<?php
include_once "_adminController.php";

class Admin_Front_Power extends AdminController {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Front_Power_Group_Model');
        $this->load->model('Front_Power_Menu_Model');
        $this->load->model('Front_Power_Groupmenu_Model');
        $this->load->library('adminpagination');
    }

    /*
    * 群组列表
    */
    function grouplist() {
        $list = $this->Front_Power_Group_Model->getAll();
        $count = $this->Front_Power_Group_Model->getCount();
        $this->setComponent( 'grouplist', array('list' => $list) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 添加群组
    */
    function groupadd() {
        if($_POST){
            $post = $this->input->post();
            $this->Front_Power_Group_Model->insert( $post );
            Util::redirect('/admin_front_power/grouplist');
        }
        $this->setComponent('groupadd');
        $this->showTemplate('admin_base');
    }

    /*
    * 修改群组
    */
    function groupedit( $id ) {
        if($_POST){
            $this->Front_Power_Group_Model->update( $this->input->post(), "id = " . $id );
            Util::redirect('/admin_front_power/grouplist');
        }
        $data = $this->Front_Power_Group_Model->getOne( array("id" => $id) );
        $this->setComponent( 'groupedit', array('data' => $data) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 删除群组
    */
    function groupdel( $id ) {
        //删除群组
        $this->Front_Power_Group_Model->delete("`id` = '".$id."'");
        //删除群组对应权限菜单
        $this->Front_Power_Groupmenu_Model->delete("`group_id` = '".$id."'");
        Util::redirect('/admin_front_power/grouplist');
    }

    /*
    * 前台菜单列表
    */
    function menulist() {
        $menus = $this->Front_Power_Menu_Model->getTrees();
        $this->setComponent( 'menulist', array('menus' => $menus) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 添加菜单
    */
    function menuadd($default_f_id = 0) {
        if($_POST){
            $post = $this->input->post();
            $this->Front_Power_Menu_Model->insert( $post );
            Util::redirect('/admin_front_power/menulist');
        }
        $menus = $this->Front_Power_Menu_Model->getTrees();
        $this->setComponent('menuadd', array('menus' => $menus, 'default_f_id' => $default_f_id ));
        $this->showTemplate('admin_base');
    }

    /*
    * 修改菜单
    */
    function menuedit( $id ) {
        if($_POST){
            $this->Front_Power_Menu_Model->update( $this->input->post(), "id = " . $id );
            Util::redirect('/admin_front_power/menulist');
        }
        $menus = $this->Front_Power_Menu_Model->getTrees();
        $data = $this->Front_Power_Menu_Model->getOne( array("id" => $id) );
        $this->setComponent( 'menuedit', array('data' => $data, 'menus' => $menus) );
        $this->showTemplate( 'admin_base' );
    }
    
    /*
    * 删除菜单
    */
    function menudel( $id ) {
        //判断是否有下级菜单
        if($this->Front_Power_Menu_Model->isHaveChild($id)){
            Util::redirect('/admin_front_power/menulist', '此菜单下含有子菜单，请先删除子菜单！');
        }
        //删除菜单
        $this->Front_Power_Menu_Model->delete("`id` = '".$id."'");
        Util::redirect('/admin_front_power/menulist');
    }

    /*
    * 分配节点
    */
    function setmenu( $groupid ) {
        if($_POST){
            $menus    =  $_POST["menus"];
            $roleId   =  $_POST["roleId"];
            //清除已有节点
            $this->Front_Power_Groupmenu_Model->delete("`group_id` = '".$groupid."'");
            //分配新节点
            if(is_array($menus)){
                foreach($menus as $item){
                    $data = array('group_id' => $groupid, 'menu_id' => $item['id']);
                    $this->Front_Power_Groupmenu_Model->insert($data);
                }
            }
            die();
        }
        //所有节点
        $nodes = $this->Front_Power_Menu_Model->getAll();
        //已有节点
        $roleNodeIds = $this->Front_Power_Group_Model->getGroupMenuIds($groupid);
        $this->setComponent( 'setmenu', array('nodes' => $nodes, 'roleNodeIds' => $roleNodeIds, 'groupid' => $groupid ) );
        $this->showTemplate( 'none' );
    }


}