<?php
include_once "_adminController.php";

class Admin_Resource_Info extends AdminController {

    function __construct() {
        parent::__construct();
        $this->load->model('Resource_Info_Model');
        $this->load->model('Resource_Cat_Model');
        $this->load->model('Resource_Library_Model');
        $this->load->library('adminpagination');
        $this->load->model("User_Model");
    }

    /*
    * 资源列表
    */
    function infolist( $start = 0 ) {
        $get = $this->input->get();
        $limit =10;
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $where = array();
        $resource_id_arr=array();
        //院系管理员
        if($this->type=='organization'){
            $resource=$this->Resource_Library_Model->getAll('`organization_id`= ' .$this->admin['organization_id']);
            foreach($resource as $v){
            $resource_id_arr[]=$v['id'];
        }
        $resource_id=implode(',', $resource_id_arr);
        $where[] = "`library_id` in (".$resource_id.")";
        }
        $where[] = 'id > 0';
        if(!empty($get['name'])) $where[] = "`name` like '%".$get['name']."%'";
        if(!empty($get['library_id'])) $where[] = "`library_id` = '".$get['library_id']."'";
        $condition = implode(' AND ', $where);
        $list = $this->Resource_Info_Model->getAll($condition, '*', '`id` DESC', $limit, $start );
//        $lists = $this->Resource_Info_Model->getAll("`id`>0 and `created` between '2012-10-26' and '2012-11-25'", '*', '`id` DESC', 10000, $start );
//        
//        $str = Array();
//        $houzhui = Array(
//            '.doc','.docx','.xls','.pdf','.xlsx','.txt','.jpg','.jpeg','.png','.gif','.bmp','.PDF','.ppt'
//        );
//        $shipin = array(
//            '.wmv','.mp4','.rmvb','.avi','.dvd','.mkv'
//        );
//        foreach($lists as $key=>$val)
//        {
//            $a = explode('.', $val['file_path']);
//            $b = strrchr($val['file_path'],'.');
//            if(in_array(strtolower($b), $houzhui))
//            {
//              $str[$val['id']] ['file_path'] = $val['file_path'].'.swf';  
//            }elseif (in_array(strtolower($b), $shipin)) {
//                 $str[$val['id']] ['file_path'] = $val['file_path'].'.flv';  
//            }
//            $str[$val['id']] ['file_type'] = isset($a[1]) ? $a[1] : '无格式';         
//            $str[$val['id']] ['file_size'] = $val['file_size']*1024;
//             
//            
//        }
//        $this->Resource_Info_Model->piliangzhuanhuan( $str );
      
        
        $count = $this->Resource_Info_Model->getCount( $condition );
        //取得上传人和所属资源库
        foreach($list as $key => $value){
            if(isset($value['user_id']))$list[$key]['up_user']=$this->User_Model->getOne("`id` = " .$value['user_id']);
            $list[$key]['resource']=$this->Resource_Library_Model->getOne("`id` = " .$value['library_id']);
        }
        //资源库
        $librarys = $this->Resource_Library_Model->getAll("`id` > 0", "*", "`order` ASC, `id` DESC");
        //构造分页
        //$page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        //$pagination  =  $page->showAdmin_1();
         $config[ 'total_rows' ] = $count;
         $config[ 'per_page' ] = $limit;
         $config[ 'base_url' ] = base_url() . 'admin_resource_info/infolist';
         $this->adminpagination->initialize( $config );
         $pagination = $this->adminpagination->create_links();
        $result = array(
            'list'       => $list, 
            "pagination" => $pagination, 
            'count'      => $count,
            'librarys'   => $librarys, 
            'get'        => $get
        );
        $this->setComponent( 'infolist', $result );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 添加/编辑资源
    */
    function infoedit() {
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
                $data['user_id'] = $this->admin['id'];
                $this->Resource_Info_Model->insert($data);
            }
            Util::redirect('/admin_resource_info/infolist');
        }
        $data = '';
        if(!empty($_GET['id'])){
            $data = $this->Resource_Info_Model->getOne("`id` = '".$_GET['id']."'");
        }
        //资源库
        $librarys = $this->Resource_Library_Model->getAll("`id` > 0", "*", "`order` ASC, `id` DESC");
        $this->setComponent( 'infoedit', array('data' => $data, 'librarys' => $librarys) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 资源详细
    */
    function infodetail($infoid) {
        //资源详细
        $resource = $this->Resource_Info_Model->getOne("`id` = '".$infoid."'");
        //构造返回
        $result = array(
            'resource'   => $resource
        );
        $this->setComponent('infodetail', $result);
        $this->showTemplate('admin_base');
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
            'status' => $status
        );
        $this->Resource_Info_Model->update($data, $where);
        Util::redirect($url);
    }
    
    /*
    * 删除资源
    */
    function infodel() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect('/admin_resource_info/infolist', '请选择要删除的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect('/admin_resource_info/infolist', '请选择要删除的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->Resource_Info_Model->delete($where);
        Util::redirect('/admin_resource_info/infolist');
    }
    
    /**
     * 批量审核
     */
    function piliang()
    {
        try{
             $data = $this->input->post('item_id');
             $this->Resource_Info_Model->piliang($data);
             $this->AJAXSuccess();
        }
        catch (Exception $ex)
        {
            $this->AJAXFail();
        }
    }

}