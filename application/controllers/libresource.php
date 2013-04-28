<?php
include_once '_libresourceController.php';

class Libresource extends LibresourceController {

    function __construct() {
        parent::__construct();
        $this->load->model('Resource_Library_Model');
        $this->load->model('Resource_Info_Model');
        $this->load->model('Resource_Cat_Model');
        $this->load->model('Resource_Comment_Model');
        $this->load->model('User_Model');
        $this->load->library('adminpagination');
    }

    /*
    * 首页
    */
    function index() {
        $where = "`id` > 0";
        $list = $this->Resource_Library_Model->getAll($where, '*', '`order` ASC, `id` DESC' );
        $this->setComponent('index', array('list' => $list));
        $this->showTemplate('libresource_base');
    }

    /*
    * 资源列表
    */
    function infolist($library_id = 0, $cat_id = 0,$start=0) {
        $get = $_GET;
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $catnav = array();
        $limit=10;
        //构造条件
        $where = array();
        $where[] = "`status` = 'succeed'";
        if($library_id!=0){$where[] = "`library_id` = " .$library_id;}
        if(!empty($cat_id)) $where[] = "(`cat_id` = '".$cat_id."' OR `cat_id` like '".$cat_id.",%' OR `cat_id` like '%,".$cat_id."' OR `cat_id` like '%,".$cat_id.",%')";
        if(!empty($get['keyword'])) $where[] = "`name` like '%".$get['keyword']."%'";
        $condition = implode(' AND ', $where);
        //构造数据
        //$list = $this->Resource_Info_Model->getAll($condition, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $list = $this->Resource_Info_Model->getAll($condition, '*', '`id` DESC', $limit, $start);
        $count = $this->Resource_Info_Model->getCount( $condition );
        //分类导航
        if(!empty($cat_id)) $catnav = $this->Resource_Cat_Model->getParents($cat_id, 'id, f_id, name');
        //所有分类
        $cats = $this->Resource_Cat_Model->getAll("`library_id` = '".$library_id."'");
        //资源库信息
        $library = $this->Resource_Library_Model->getOne("`id` = '".$library_id."'");
        //构造分页
        //$page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
       // $pagination  =  $page->showWeb_1();
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $config[ 'base_url' ] = base_url() . 'libresource/infolist/'.$library_id.'/'.$cat_id;
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links(5);
        //构造返回
        $result = array(
            'list'       => $list, 
            'library'    => $library,
            'library_id' => $library_id,
            'cat_id'     => $cat_id,
            'catnav'     => $catnav,
            'cats'       => $cats,
            'count'      => $count,
            'pagination' => $pagination,
            'pagesize'   => $pagesize,
            'limit'      => $start,
            'PB_page'    => $PB_page,
            'get'        => $get
        );
        $this->setComponent('infolist', $result);
        $this->showTemplate('libresource_info');
    }


    /*
    * 资源详细
    */
    function infodetail($library_id, $cat_id = 0, $infoid) {
        //$infoid   资源ID
        //$cat_id   分类ID
        //$library_id 资源分类ID
        $catnav = array();
        //资源详细
        $resource = $this->Resource_Info_Model->getOne("`id` = '".$infoid."'");
        $this->Resource_Info_Model->update(array('view' => $resource['view']+1), "`id` = '".$infoid."'");
        
        //分类导航
        if(!empty($cat_id)) $catnav = $this->Resource_Cat_Model->getParents($cat_id, 'id, f_id, name');
        //所有分类
        $cats = $this->Resource_Cat_Model->getAll("`library_id` = '".$library_id."'");
        //资源库信息
        $library = $this->Resource_Library_Model->getOne("`id` = '".$library_id."'");
        //构造返回
        $result = array(
            'resource'   => $resource, 
            'library'    => $library,
            'catnav'     => $catnav,
            'cat_id'     => $cat_id,
            'cats'       => $cats
        );
        $this->setComponent('infodetail', $result);
        $this->showTemplate('libresource_info');
    }
   
    /*
    * 顶
    */
    function upordown() {
        $id = $_POST['id'];
        $type = $_POST['type'];
        $resource = $this->Resource_Info_Model->getOne("`id` = '".$id."'");
        if($type == 'up'){
            $data = array( 'up' => $resource['up']+1 );
            $this->Resource_Info_Model->update($data, "`id` = '".$id."'");
            die('ok');
        }else if($type == 'down'){
            $data = array( 'down' => $resource['down']+1 );
            $this->Resource_Info_Model->update($data, "`id` = '".$id."'");
            die('ok');
        }else{
            die(0);
        }
    }   
    
    /*
    * 更新下载次数
    */
    function down() {
        $id = $_POST['id'];
        $resource = $this->Resource_Info_Model->getOne("`id` = '".$id."'");
        $this->Resource_Info_Model->update(array( 'download' => $resource['download']+1 ), "`id` = '".$id."'");
    }   
    
    
    
    /*
    * 资源评论列表
    */
    function commentlist() {
        //初始化
        $PB_page      = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize     = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $search       =  empty($_POST['search']) ? '' : $_POST['search'];
        $resource_id  =  empty($_POST['resource_id']) ? 0 : $_POST['resource_id'];
        
      		//查询结果
      		$where = "`source_id` = '".$resource_id."'";
      		$infos = $this->Resource_Comment_Model->getAll($where, '*', 'id DESC', $pagesize, ($PB_page-1)*$pagesize);
      		$rowcount = $this->Resource_Comment_Model->getCount($where);
      		foreach($infos as $k => $v){
      		    $infos[$k]['user'] = $this->User_Model->getOne("`id` = '".$v['user_id']."'");
      		}
      		//构造分页(AJAX)
        $ajaxpage = new page(array('total'=> $rowcount, 'perpage'=> $pagesize, 'ajax'=>'commentlist', 'page_name'=>'PB_page'));
        $pagenav  =  $ajaxpage->show(7);
        //构造返回参数
        $result = array(
            'pagesize'  =>  $pagesize,
            'PB_page'   =>  $PB_page,
            'pagenav'   =>  $pagenav,
            'infos'     =>  $infos
        );
        $this->setComponent( 'commentlist', $result );
        $this->showTemplate( 'none' );     
    }   
   
    /*
    * 添加评论
    */
    function commentadd() {
        //初始化
        $data = array();
        $data['score']     = $_POST['score'];
        $data['source_id'] = $_POST['source_id'];
        $data['user_id']   = $_POST['user_id'];
        $data['comment']   = $_POST['comment'];
        $data['created']   = date('Y-m-d H:i:s');
      		$this->Resource_Comment_Model->insert($data);
    }   
    /**
    *下载 
    */
    function xz()
    {
        $this->load->helper('download');//print_r($_GET['data']) ;
        $this->load->helper('file');
        $datas = file_get_contents('./'.$_GET['data']);
        $name = substr(strrchr($_GET['data'],'/'),1,  strlen(strrchr($_GET['data'],'/')));    
        force_download($name, $datas); 

    }
}