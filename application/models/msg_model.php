<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Msg_Model extends DAO {

    function __construct() {
        parent::__construct();
        parent::initTable( 'gz_msg', 'id' );
    }
    
    /*
    * 收件箱
    */
    public function getAll($where = '', $orderby = 'msg.id DESC', $limit = '', $offset = ''){
        $rows = array();
        $select = "msg.id as msgid, 
                   msg.title as msgtitle, 
                   msg.content as msgcontent, 
                   msg.created as msgcreated, 
                   senduser.id as senduserid,
                   senduser.login_name as senduserloginname,
                   senduser.name as sendusername,
                   senduser.type as sendusertype,
                   recevuser.id as recevuserid,
                   recevuser.login_name as recevuserloginname,
                   recevuser.name as recevusername,
                   recevuser.type as recevusertype,
                   msgrel.sendstatus,
                   msgrel.recevestatus,
                   msgrel.readstatus
                   ";
        $this->db->select($select, FALSE);
        $this->db->order_by($orderby);
        $this->db->where($where, NULL, FALSE);
        $this->db->from('gz_msg_rel as msgrel');
        $this->db->join('gz_msg as msg', 'msg.id = msgrel.msgid', 'left');
        $this->db->join('gz_users as senduser', 'senduser.id = msgrel.senderid', 'left');
        $this->db->join('gz_users as recevuser', 'recevuser.id = msgrel.receverid', 'left');
        if(!empty($limit)){
            $query = $this->db->get('', $limit, $offset);
        }else{
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $row) {
            $rows[] = $row;
        }
        return $rows;
    }    
    
    public function getOne( $where = '', $orderby = 'msg.id DESC' ) {
        $row = array();
        $select = "msg.id as msgid, 
                   msg.title as msgtitle, 
                   msg.content as msgcontent, 
                   msg.created as msgcreated, 
                   senduser.id as senduserid,
                   senduser.login_name as senduserloginname,
                   senduser.name as sendusername,
                   senduser.type as sendusertype,
                   recevuser.id as recevuserid,
                   recevuser.login_name as recevuserloginname,
                   recevuser.name as recevusername,
                   recevuser.type as recevusertype,
                   msgrel.sendstatus,
                   msgrel.recevestatus,
                   msgrel.readstatus
                   ";
        $this->db->select($select, FALSE);
        $this->db->order_by($orderby);
        $this->db->where($where, NULL, FALSE);
        $this->db->from('gz_msg_rel as msgrel');
        $this->db->join('gz_msg as msg', 'msg.id = msgrel.msgid', 'left');
        $this->db->join('gz_users as senduser', 'senduser.id = msgrel.senderid', 'left');
        $this->db->join('gz_users as recevuser', 'recevuser.id = msgrel.receverid', 'left');
        $query = $this->db->get( );
        $row = $query->result_array();
        if ( count( $row ) > 0 )
        {
            return $row[ 0 ];
        }
        else
        {
            return null;
        }
    }
    
    /*
    * 发件箱
    */
    public function getSendAll($where = '', $orderby = 'msg.id DESC', $limit = '', $offset = ''){
        $rows = array();
        $select = "msg.id as msgid, 
                   msg.title as msgtitle, 
                   msg.content as msgcontent, 
                   msg.created as msgcreated, 
                   senduser.id as senduserid,
                   senduser.login_name as senduserloginname,
                   senduser.name as sendusername,
                   senduser.type as sendusertype,
                   msgrel.sendstatus,
                   msgrel.recevestatus
                   ";
        $this->db->select($select, FALSE);
        $this->db->order_by($orderby);
        $this->db->group_by(array('msgid', 'msgtitle', 'msgcontent', 'msgcreated', 'senduserid', 'senduserloginname', 'sendusername', 'sendusertype', 'sendstatus', 'recevestatus')); 
        $this->db->where($where, NULL, FALSE);
        $this->db->from('gz_msg_rel as msgrel');
        $this->db->join('gz_msg as msg', 'msg.id = msgrel.msgid', 'left');
        $this->db->join('gz_users as senduser', 'senduser.id = msgrel.senderid', 'left');
        $this->db->join('gz_users as recevuser', 'recevuser.id = msgrel.receverid', 'left');
        if(!empty($limit)){
            $query = $this->db->get('', $limit, $offset);
        }else{
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $row) {
            $rows[] = $row;
        }
        return $rows;	
    }
    
    /*
    * 查询数量
    */
    public function getCount( $where = '', $fieldNameArr = '' ) {
        if(!empty($where)) $this->db->where($where, NULL, FALSE);
        if(!empty($fieldNameArr))  $this->db->group_by($fieldNameArr); 
        $this->db->from('gz_msg_rel as msgrel');
        $this->db->join('gz_msg as msg', 'msg.id = msgrel.msgid', 'left');
        $this->db->join('gz_users as senduser', 'senduser.id = msgrel.senderid', 'left');
        $this->db->join('gz_users as recevuser', 'recevuser.id = msgrel.receverid', 'left');
        $query = $this->db->get();
        $count = $query->num_rows();
        return $count;
    }
    
    
    
    
}
