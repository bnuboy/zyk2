<?php
include_once '_ucenterController.php';

class Ucenter_Post extends UcenterController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Post_Model');
        $this->load->model('User_Model');
    }

    /*
    *  我发的帖子
    */
    function mypost() {
        $get = $_GET;
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        //构造条件
        $where = array();
        $where[] = "user_id = '".$this->user['id']."'";
        $where[] = "parent_id = 0";
        if(!empty($get['keyword'])) $where[] = "(`title` like '%".$get['keyword']."%' OR `content` like '%".$get['keyword']."%')";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->Post_Model->getAll($condition,  "*", 'created DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->Post_Model->getCount( $condition );
        //我的回复数量
        $myreply = $this->Post_Model->getCount("user_id = '".$this->user['id']."' AND parent_id > 0");
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showWeb_1();
        //构造返回
        $result = array(
            'list'       => $list, 
            'count'      => $count,
            'pagination' => $pagination,
            'pagesize'   => $pagesize,
            'PB_page'    => $PB_page,
            'get'        => $get,
            'myreply'    => $myreply
        );
        $this->setComponent('mypost', $result);
        $this->showTemplate('ucenter_base');
    }

    /*
    * 我的回复
    */
    function myreply() {
        $get = $_GET;
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        //构造条件
        $where = array();
        $where[] = "user_id = '".$this->user['id']."'";
        $where[] = "parent_id > 0";
        if(!empty($get['keyword'])) $where[] = "(`title` like '%".$get['keyword']."%' OR `content` like '%".$get['keyword']."%')";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->Post_Model->getAll($condition,  "*", 'created DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->Post_Model->getCount( $condition );
        //我的回复数量
        $mypost = $this->Post_Model->getCount("user_id = '".$this->user['id']."' AND parent_id = 0");
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showWeb_1();
        //构造返回
        $result = array(
            'list'       => $list, 
            'count'      => $count,
            'pagination' => $pagination,
            'pagesize'   => $pagesize,
            'PB_page'    => $PB_page,
            'get'        => $get,
            'mypost'     => $mypost
        );
        $this->setComponent('myreply', $result);
        $this->showTemplate('ucenter_base');
    }
    
}