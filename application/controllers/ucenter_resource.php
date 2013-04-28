<?php
include_once '_ucenterController.php';

class Ucenter_Resource extends UcenterController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Resource_Library_Model');
        $this->load->model('Resource_Info_Model');
        $this->load->model('Resource_Cat_Model');
        $this->load->library('adminpagination');
    }

    /*
    * 首页
    */
    function myresourcelist($start=0) {
        $get = $_GET;
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $limit=10;
        //构造条件
        $where = array();
        $where[] = "`user_id` = '".$this->user['id']."'";
        if(!empty($get['name'])) $where[] = "`name` like '%".$get['name']."%'";
        $condition = implode(' AND ', $where);
        //构造数据
        //$list = $this->Resource_Info_Model->getAll($condition, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $list = $this->Resource_Info_Model->getAll($condition, '*', '`id` DESC', $limit, $start);
        $count = $this->Resource_Info_Model->getCount( $condition );
        //构造分页
        //$page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        //$pagination  =  $page->showWeb_1();
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $config[ 'base_url' ] = base_url() . 'ucenter_resource/myresourcelist';
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        //构造返回
        $result = array(
            'list'       => $list, 
            'count'      => $count,
            'pagination' => $pagination,
            'pagesize'   => $pagesize,
            'PB_page'    => $start,
            'get'        => $get
        );
        $this->setComponent('myresourcelist', $result);
        $this->showTemplate('ucenter_base');
    }

    /*
    * 添加/编辑资源
    */
    function myresourceedit() {
        if($_POST){         
            $data = $_POST['data'];
            $id = $data['id'];
            if(!empty($_POST['filepathinfo'])){
                $fileinfo = unserialize($_POST['filepathinfo']);
                if(isset($fileinfo['swfpath']))  $data['swf_path'] = $fileinfo['swfpath'];
                if(isset($fileinfo['flvpath'])) {
                    $data['file_path'] = $fileinfo['flvpath'];
                    $data['swf_path']  = '';
                }
                if(isset($fileinfo['file_type']))  $data['file_type'] = $fileinfo['file_type'];
                if(isset($fileinfo['file_size']))  $data['file_size'] = $fileinfo['file_size'];
            }else{
                $data['swf_path']  = '';
            }
            if(!empty($id)){
                $this->Resource_Info_Model->update($data, "id = " . $id);
            }else{
                $data['created'] = date('Y-m-d H:i:s', time());
                $data['user_id'] = $this->user['id'];
                $this->Resource_Info_Model->insert($data);
            }
            Util::redirect('/ucenter_resource/myresourcelist');
        }
        $data = '';
        if(!empty($_GET['id'])){
            $data = $this->Resource_Info_Model->getOne("`id` = '".$_GET['id']."'");
        }
        //资源库
        $librarys = $this->Resource_Library_Model->getAll();
        $this->setComponent( 'myresourceedit', array('data' => $data, 'librarys' => $librarys) );
        $this->showTemplate( 'ucenter_base' );
    }

    /*
    * 资源详细
    */
    function myresourcedetail($infoid) {
        //资源详细
        $resource = $this->Resource_Info_Model->getOne("`id` = '".$infoid."'");
        
        //构造返回
        $result = array(
            'resource'   => $resource
        );
        $this->setComponent('myresourcedetail', $result);
        $this->showTemplate('ucenter_base');
    }
    
    /*
    * 删除资源
    */
    function myresourcedel() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect('/ucenter_resource/myresourcelist', '请选择要删除的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect('/ucenter_resource/myresourcelist', '请选择要删除的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->Resource_Info_Model->delete($where);
        Util::redirect('/ucenter_resource/myresourcelist');
    }

}