<?php
include_once '_ucenterController.php';

class Ucenter_Sys_Notice extends UcenterController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Sys_Notice_Model');
    }

    /*
    * 首页
    */
    function noticelist() {
        $get = $_GET;
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        //构造条件
        $where = array();
        $where[] = "(`target` = '".$this->user['type']."' || `target` = 'all')";
        $where[] = "`type` = 'publicnotice'";
        if(!empty($get['keyword'])) $where[] = "`title` like '%".$get['keyword']."%'";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->Sys_Notice_Model->getAll($condition, '*', '`top` DESC, `level` ASC, `id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->Sys_Notice_Model->getCount( $condition );
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
            'get'        => $get
        );
        $this->setComponent('noticelist', $result);
        $this->showTemplate('ucenter_base');
    }

    /*
    * 查看详情
    */
    function noticedetail($id) {
        //当前公告
        $info = $this->Sys_Notice_Model->getOne("`id` = '".$id."'");
        //更新浏览量
        $data = array(
            'view' => $info['view'] + 1
        );
        $this->Sys_Notice_Model->update($data, "`id` = '".$id."'");
        //上一条
        $prev = array();
        $prev[] = "`id` < '".$id."'";
        $prev[] = "`type` = 'publicnotice'";
        $prev[] = "(`target` = '".$this->user['type']."' || `target` = 'all')";
        $prev = implode(' AND ', $prev);
        //下一条
        $next = array();
        $next[] = "`id` > '".$id."'";
        $next[] = "`type` = 'publicnotice'";
        $next[] = "(`target` = '".$this->user['type']."' || `target` = 'all')";
        $next = implode(' AND ', $next);
        
        $prev = $this->Sys_Notice_Model->getOne($prev, 'id', 'id DESC');
        $next = $this->Sys_Notice_Model->getOne($next, 'id', 'id ASC');
        $result = array(
            'info'  => $info,
            'prev'  => $prev,
            'next'  => $next
        );
        $this->setComponent('noticedetail', $result);
        $this->showTemplate('ucenter_base');
    }

}