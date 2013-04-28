<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class User_Contact_Model extends DAO
{

    function __construct() {
        parent::initTable( 'gz_user_contact', 'id' );
    }

    public function getDeeps($where = '', $orderby = 'cuser.id DESC', $limit = '', $offset = ''){
        $rows = array();
        $select = "user.id as userid, 
                   user.name as username, 
                   user.type as usertype, 
                   cuser.id as cuserid, 
                   cuser.name as cusername, 
                   cuser.type as cusertype,
                   groups.id as groupid,
                   groups.name as groupname
                   ";
        $this->db->select($select, FALSE);
        $this->db->order_by($orderby);
        $this->db->where($where, NULL, FALSE);
        $this->db->from('gz_user_contact as contact');
        $this->db->join('gz_user_contact_group as groups', 'groups.id = contact.contact_group_id', 'left');
        $this->db->join('gz_users as user', 'user.id = contact.add_user_id', 'left');
        $this->db->join('gz_users as cuser', 'cuser.id = contact.add_user_id', 'left');
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
    



}
