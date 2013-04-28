<?php
include_once '_ucenterController.php';

class Ucenter_Msg extends UcenterController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Msg_Model');
        $this->load->model('Msg_Rel_Model');
        $this->load->model('User_Contact_Model');
        $this->load->model('User_Contact_Group_Model');
        $this->load->model('User_Model');
    }

    /*
    * 收件箱
    */
    function recevlist() {
        $get = $_GET;
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        //构造条件
        $where = array();
        if(!empty($get['keyword'])) $where[] = "(msg.`title` like '%".$get['keyword']."%' OR msg.`content` like '%".$get['keyword']."%')";
        $where[] = "recevuser.id = '".$this->user['id']."'";
        $where[] = "msgrel.recevestatus = 0";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->Msg_Model->getAll($condition, 'msg.`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->Msg_Model->getCount( $condition );
        //发件箱数量
        $sendcount = $this->Msg_Model->getCount("senduser.id = '".$this->user['id']."' AND msgrel.sendstatus = 0", "senduser.id,msg.id");
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
            'sendcount'  => $sendcount
        );
        $this->setComponent('recevlist', $result);
        $this->showTemplate('ucenter_base');
    }

    /*
    * 发件箱
    */
    function sendlist() {
        $get = $_GET;
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        //构造条件
        $where = array();
        if(!empty($get['keyword'])) $where[] = "(msg.`title` like '%".$get['keyword']."%' OR msg.`content` like '%".$get['keyword']."%')";
        $where[] = "senduser.id = '".$this->user['id']."'";
        $where[] = "msgrel.sendstatus = 0";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->Msg_Model->getSendAll($condition, 'msg.`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        foreach($list as $k => $v){
            $list[$k]['recevlist'] = $this->Msg_Model->getAll("senduser.id = '".$v['senduserid']."' AND msg.id = '".$v['msgid']."'");
        }
        $count = $this->Msg_Model->getCount($condition, "senduser.id,msg.id");
        //收件箱总数量
        $recevcount = $this->Msg_Model->getCount("recevuser.id = '".$this->user['id']."' AND msgrel.recevestatus = 0");
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
            'recevcount' => $recevcount
        );
        $this->setComponent('sendlist', $result);
        $this->showTemplate('ucenter_base');
    }
    
    /*
    * 写信
    */
    function msgadd() {
        if($_POST){
            //写入信息表
            $data = $_POST['data'];
            $this->user['id'];
            $data['created'] = date('Y-m-d H:i:s', time());
            $msgid = $this->Msg_Model->insert($data);
            //写入关系表
            $receverids = $_POST['receverids'];
            foreach(explode(',', $receverids) as $v){
                $data = array(
                    'senderid'     => $this->user['id'],
                    'receverid'    => $v,
                    'msgid'        => $msgid,
                    'sendstatus'   => 0,
                    'recevestatus' => 0,
                    'readstatus'   => 0
                );
                $this->Msg_Rel_Model->insert($data);
            }
              Util::redirect('/ucenter_msg/recevlist');
        }
        //我的联系人
        $contacts = $this->User_Contact_Model->getAll("user_id = '".$this->user['id']."'");
        foreach($contacts as $k => $v){
            $contacts[$k]['user']  = $this->User_Model->getOne("`id` = '".$v['add_user_id']."'");
        }
        $groups = $this->User_Contact_Group_Model->getAll("user_id = '".$this->user['id']."'");
        $result = array(
            'contacts' => $contacts,
            'groups'   => $groups
        );
        $this->setComponent( 'msgadd', $result );
        $this->showTemplate( 'ucenter_base' );
    }

    /*
    * 详情
    */
    function msgdetail() {
        $issend = !empty($_GET['issend']) ? $_GET['issend'] : '';
        $msgid = $_GET['msgid'];
        $data = $this->Msg_Model->getOne("msg.id = '".$msgid."'");
        //如果不是从发件箱跳转过来，则更改阅读状态
        if(empty($issend)){
            $this->Msg_Rel_Model->update(array('readstatus' => 1), "msgid = '".$msgid."' AND receverid = '".$this->user['id']."'");
        }
        //收件人
        $recevlist = $this->Msg_Model->getAll("senduser.id = '".$data['senduserid']."' AND msg.id = '".$data['msgid']."'");
        $result = array(
            'data'       => $data,
            'recevlist'  => $recevlist
        );
        $this->setComponent( 'msgdetail', $result );
        $this->showTemplate( 'ucenter_base' );
    }
    
    /*
    * 删除信息
    */
    function msgdel() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::jumpback('请选择要删除的数据');
            }else{
                $where = "`msgid` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::jumpback('请选择要删除的数据');
            }else{
                $where = "`msgid` = '".$_GET['id']."'";
            }
        }
        $optype = $_GET['optype'];
        if($optype == 'recev'){
            $data = array('recevestatus' => 1);
            $where .= " AND receverid = '".$this->user['id']."'";
            $url = "/ucenter_msg/recevlist";
        }else if($optype == 'send'){
            $data = array('sendstatus' => 1);
            $where .= " AND senderid = '".$this->user['id']."'";
            $url = "/ucenter_msg/sendlist";
        }
        $this->Msg_Rel_Model->update($data, $where);
        Util::redirect($url);
    }    
    
    
}