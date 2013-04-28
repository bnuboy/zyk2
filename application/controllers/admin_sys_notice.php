<?php
include_once "_adminController.php";

class Admin_Sys_Notice extends AdminController {
    
    function __construct() {
        parent::__construct();
        $this->load->model('Sys_Notice_Model');
        $this->load->library('adminpagination');
    }

    /*
    * 公告列表
    */
    function noticelist($start=0) {
        $get = $this->input->get();
        $limit=10;
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        //构造条件
        $where = array();
        $where[] = 'id > 0';
        if(!empty($get['title'])) $where[] = "`title` like '%".$get['title']."%'";
        if(!empty($get['type'])) $where[] = "`type` = '".$get['type']."'";
        $condition = implode(' AND ', $where);
        $list = $this->Sys_Notice_Model->getAll($condition, '*', '`id` DESC', $limit, $start);
        $count = $this->Sys_Notice_Model->getCount( $condition );
        //构造分页
        //$page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        //$pagination  =  $page->showAdmin_1();
         $config[ 'total_rows' ] = $count;
         $config[ 'per_page' ] = $limit;
         $config[ 'base_url' ] = base_url() . 'admin_sys_notice/noticelist';
         $this->adminpagination->initialize( $config );
         $pagination = $this->adminpagination->create_links();
        //构造返回数据
        $result = array(
            'list'       => $list, 
            "pagination" => $pagination, 
            'count'      => $count, 
            'get'        => $get
        );
        $this->setComponent( 'noticelist', $result );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 添加/编辑公告
    */
    function noticeedit() {
        if($_POST){
            $data = $_POST['data'];
            $id = $data['id'];
            //$data['type'] = ($data['type'] == "存草稿") ? 'draft' : $data['type'];
            if(!empty($id)){
                $this->Sys_Notice_Model->update($data, "id = " . $id);
            }else{
                $data['created'] = date('Y-m-d H:i:s', time());
                $this->Sys_Notice_Model->insert($data);
            }
            Util::redirect('/admin_sys_notice/noticelist');
        }
        $data = '';
        if(!empty($_GET['id'])){
            $data = $this->Sys_Notice_Model->getOne("`id` = '".$_GET['id']."'");
        }
        $this->setComponent( 'noticeedit', array('data' => $data) );
        $this->showTemplate( 'admin_base' );
    }
    
    /*
    * 改变状态 
    */
    function changestatus() {
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
            'type' => $status
        );
        $this->Sys_Notice_Model->update($data, $where);
        Util::redirect($url);
    }
    
    /*
    * 删除公告
    */
    function noticedel() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect('/admin_sys_notice/noticelist', '请选择要删除的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect('/admin_sys_notice/noticelist', '请选择要删除的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->Sys_Notice_Model->delete($where);
        Util::redirect('/admin_sys_notice/noticelist');
    }

}