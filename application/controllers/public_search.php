<?php
include_once '_publicController.php';

class Public_Search extends PublicController
{
    
    public $resourcecount;
    public $coursecount;
    public $usercount;

    function __construct()
    {
        parent::__construct();
        $this->load->model( 'Study_Course_Model' );
        $this->load->model('User_Model');
        $this->load->model('School_Organization_Model');
        $this->load->model('Resource_Info_Model');
        $this->load->model('Resource_Cat_Model');
        //资源数
        $this->resourcecount = $this->Resource_Info_Model->getCount();
        //课程数
        $this->coursecount = $this->Study_Course_Model->getCount();
        //用户数
        $this->usercount = $this->User_Model->getCount();

    }

    function search_user(){
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $keyword   = trim(empty($_GET['keyword'])? '' :$_GET['keyword']);
        //构造条件
        $where = array();
        if(!empty($keyword)) $where[] = "`login_name` LIKE '%".$keyword."%' OR `name` LIKE '%".$keyword."%'";
        $where[] = "`id` > 0";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->User_Model->getAll($condition, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->User_Model->getCount( $condition );
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showStyle_web1();
        //构造返回
        $result = array(
            'list'       => $list, 
            'count'      => $count,
            'pagination' => $pagination,
            'pagesize'   => $pagesize,
            'PB_page'    => $PB_page,
            'keyword'    => $keyword
        );
        $this->setComponent('search_user', $result);
        $this->showTemplate('public_base');    
    }
    function search_resource(){
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $keyword   = trim(empty($_GET['keyword'])? '' :$_GET['keyword']);
        //构造条件
        $where = array();
        if(!empty($keyword)) $where[] = "`name` LIKE '%".$keyword."%' OR `description` LIKE '%".$keyword."%'";
        $where[] = "`id` > 0";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->Resource_Info_Model->getAll($condition, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->Resource_Info_Model->getCount( $condition );
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showStyle_web1();
        //构造返回
        $result = array(
            'list'       => $list, 
            'count'      => $count,
            'pagination' => $pagination,
            'pagesize'   => $pagesize,
            'PB_page'    => $PB_page,
            'keyword'    => $keyword
        );
        $this->setComponent('search_resource', $result);
        $this->showTemplate('public_base');    
    }
    function search_course(){
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $keyword   = trim(empty($_GET['keyword'])? '' :$_GET['keyword']);
        //构造条件
        $where = array();
        if(!empty($keyword)) $where[] = "`name` LIKE '%".$keyword."%' OR `description` LIKE '%".$keyword."%'";
        $where[] = "`id` > 0";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->Study_Course_Model->getAll($condition, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->Study_Course_Model->getCount( $condition );
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showStyle_web1();
        //构造返回
        $result = array(
            'list'       => $list, 
            'count'      => $count,
            'pagination' => $pagination,
            'pagesize'   => $pagesize,
            'PB_page'    => $PB_page,
            'keyword'    => $keyword
        );
        $this->setComponent('search_course', $result);
        $this->showTemplate('public_base');    
    }
    function search_org(){
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $keyword   = trim(empty($_GET['keyword'])? '' :$_GET['keyword']);
        //构造条件
        $where = array();
        if(!empty($keyword)) $where[] = "`name` LIKE '%".$keyword."%' OR `description` LIKE '%".$keyword."%' OR `code` LIKE '%".$keyword."%'";
        $where[] = "`id` > 0";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->School_Organization_Model->getAll($condition, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->School_Organization_Model->getCount( $condition );
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showStyle_web1();
        //构造返回
        $result = array(
            'list'       => $list, 
            'count'      => $count,
            'pagination' => $pagination,
            'pagesize'   => $pagesize,
            'PB_page'    => $PB_page,
            'keyword'    => $keyword
        );
        $this->setComponent('search_org', $result);
        $this->showTemplate('public_base');    
    }
     /*
     * 公告列表
     */
     function notice_list($id=0){
        $this->load->model('Sys_Notice_Model');
        //系统公告

        $notice = $this->Sys_Notice_Model->getAll("`target` = 'all'", '*', '`top` DESC, `level` ASC, `id` DESC', 10,0);
        if($id!=0){
            $notice_id=$id;
        }else{
            $notice_id=$notice[0]['id'];
        }
        $info = $this->Sys_Notice_Model->getOne("`id` = ".$notice_id, '*');
        $result=array(
            'notice'    => $notice,
            'info'      => $info,
            'notice_id' => $notice_id
        );
        $this->setComponent('news_list', $result);
        $this->showTemplate('public_base');
     }

}
