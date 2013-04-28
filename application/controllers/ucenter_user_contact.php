<?php
include_once '_ucenterController.php';

class Ucenter_User_Contact extends UcenterController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('User_Contact_Model');
        $this->load->model('User_Contact_Group_Model');
        $this->load->model('User_Model');
    }

    /*
    * 首页
    */
    function contact_list() {
        $get       = $_GET;
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        //构造条件
        $where = array();
        $where[] = "`user_id` = '".$this->user['id']."'";
        if(isset($get['contact_group_id'])) $where[] = "`contact_group_id` = '".$get['contact_group_id']."'";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->User_Contact_Model->getAll($condition, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->User_Contact_Model->getCount( $condition );
        //关联数据
        foreach($list as $k => $v){
            $list[$k]['user']  = $this->User_Model->getOne("`id` = '".$v['add_user_id']."'");
            $list[$k]['group'] = $this->User_Contact_Group_Model->getOne("`id` = '".$v['contact_group_id']."'");
        }
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showWeb_1();
        //通讯录分组
        $groups = $this->User_Contact_Group_Model->getAll("`user_id` = '".$this->user['id']."'");
        //构造返回
        $result = array(
            'list'       => $list, 
            'groups'     => $groups,
            'count'      => $count,
            'pagination' => $pagination,
            'pagesize'   => $pagesize,
            'PB_page'    => $PB_page,
            'get'        => $get
        );
        $this->setComponent('contact_list', $result);
        $this->showTemplate('ucenter_base');
    }


    /*
    * 添加/编辑通讯录
    */
    function contact_edit() {
        if($_POST){
            $data = $_POST['data'];
            $data['user_id'] = $this->user['id'];
            $id = $data['id'];
            if(!empty($id)){
                $this->User_Contact_Model->update($data, "id = " . $id);
            }else{
                $this->User_Contact_Model->insert($data);
            }
            Util::redirect('/ucenter_user_contact/contact_list');
        }
        $data = '';
        if(!empty($_GET['id'])){
            $data = $this->User_Contact_Model->getOne("`id` = '".$_GET['id']."'");
        }
        //通讯录分组
        $groups = $this->User_Contact_Group_Model->getAll("`user_id` = '".$this->user['id']."'");
        //所有用户
        $users = $this->User_Model->getAll("`id` > 0", "id,name,type", "`type` ASC");
        $result = array(
            'data'   => $data, 
            'groups' => $groups,
            'users'  => $users
        );
        $this->setComponent( 'contact_edit', $result );
        $this->showTemplate( 'ucenter_base' );
    }

    /*
    * 添加分组
    */
    function group_add() {
        if($_POST){
            $data = $_POST['data'];
            $data['user_id'] = $this->user['id'];
            $this->User_Contact_Group_Model->insert($data);
            echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
        }
        $this->setComponent( 'group_add');
        $this->showTemplate( 'none' );
    }
    
    /*
    * 编辑分组
    */
    function group_edit() {
        $id   = $_POST['id'];
        $name = $_POST['name'];
        $this->User_Contact_Group_Model->update(array('name' => $name), "`id` = '".$id."'");
        die();
    }

    /*
    * 编辑分组
    */
    function group_del() {
        $id   = $_POST['id'];
        //判断分组下是否有联系人
        $contacts = $this->User_Contact_Model->getAll("`contact_group_id` = '".$id."'");
        if($contacts){
            echo 'false';
        }else{
            $this->User_Contact_Group_Model->delete("`id` = '".$id."'");
            echo 'true';
        }
        die();
    }
        
    /*
    * 验证用户
    */
    function checkuser(){
        $data = Util::getPar('data');
        $add_user_id = $data['add_user_id'];
        $default_add_user_id = Util::getPar('default_add_user_id');
        $where = " `add_user_id` = '".$add_user_id."' AND `user_id` = '".$this->user['id']."'";
        if(!empty($default_add_user_id)) $where .= " AND `add_user_id` <> '".$default_add_user_id."' ";
        $count = $this->User_Contact_Model->getCount($where);
        if($count > 0){
            echo 'false';
        }else{
            echo 'true';
        }
   }
    
    /*
    * 删除通讯录
    */
    function contact_del() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect('/ucenter_user_contact/contact_list', '请选择要删除的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect('/ucenter_user_contact/contact_list', '请选择要删除的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->User_Contact_Model->delete($where);
        Util::redirect('/ucenter_user_contact/contact_list');
    }    
    
    
}