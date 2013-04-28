<?php
include_once '_ucenterController.php';

class Ucenter_User_Agenda extends UcenterController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('User_Agenda_Model');
    }

    /*
    * 首页
    */
    function agendalist() {
        $get = $_GET;
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        //构造条件
        $where = array();
        $where[] = "`user_id` = '".$this->user['id']."'";
        if(!empty($get['keyword'])) $where[] = "`name` like '%".$get['keyword']."%'";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->User_Agenda_Model->getAll($condition, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->User_Agenda_Model->getCount( $condition );
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
        $this->setComponent('agendalist', $result);
        $this->showTemplate('ucenter_base');
    }


    /*
    * 添加/编辑日程
    */
    function agendaedit() {
        if($_POST){
            $data = $_POST['data'];
            $data['user_id'] = $this->user['id'];
            $id = $data['id'];
            if(!empty($id)){
                $this->User_Agenda_Model->update($data, "id = " . $id);
            }else{
                $data['created'] = date('Y-m-d H:i:s', time());
                $this->User_Agenda_Model->insert($data);
            }
            Util::redirect('/ucenter_user_agenda/agendalist');
        }
        $data = '';
        if(!empty($_GET['id'])){
            $data = $this->User_Agenda_Model->getOne("`id` = '".$_GET['id']."'");
        }
        $this->setComponent( 'agendaedit', array('data' => $data) );
        $this->showTemplate( 'ucenter_base' );
    }

    /*
    * 查看详情
    */
    function agendadetail($id) {
        //当前公告
        $info = $this->User_Agenda_Model->getOne("`id` = '".$id."'");
        //上一条
        $prev = array();
        $prev[] = "`id` < '".$id."'";
        $prev[] = "`user_id` = '".$this->user['id']."'";
        $prev = implode(' AND ', $prev);
        //下一条
        $next = array();
        $next[] = "`id` > '".$id."'";
        $next[] = "`user_id` = '".$this->user['id']."'";
        $next = implode(' AND ', $next);
        
        $prev = $this->User_Agenda_Model->getOne($prev, 'id', 'id DESC');
        $next = $this->User_Agenda_Model->getOne($next, 'id', 'id ASC');
        $result = array(
            'info'  => $info,
            'prev'  => $prev,
            'next'  => $next
        );
        $this->setComponent('agendadetail', $result);
        $this->showTemplate('ucenter_base');
    }
    
    /*
    * 更改状态
    */
    function changestatus() {
        $data = $_POST['data'];
        $id = $data['id'];
        $this->User_Agenda_Model->update($data, "id = " . $id);
        Util::redirect('/ucenter_user_agenda/agendadetail/'.$id);
    }
    
    /*
    * 删除日程
    */
    function agendadel() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect('/ucenter_user_agenda/agendalist', '请选择要删除的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect('/ucenter_user_agenda/agendalist', '请选择要删除的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->User_Agenda_Model->delete($where);
        Util::redirect('/ucenter_user_agenda/agendalist');
    }    
    
    
}