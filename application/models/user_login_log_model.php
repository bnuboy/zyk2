<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class User_Login_Log_Model extends DAO
{

    function __construct()
    {
        parent::__construct();
        parent::initTable( 'gz_user_login_log', 'id' );
        $this->load->database();
    }
    
    function getTimeCount($where){
        $row = array();
        $this->db->select_sum("timer", "timecount");
        $this->db->where($where, NULL, FALSE);
        $query = $this->db->get('gz_user_login_log');
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
    
    
    
}
?>
