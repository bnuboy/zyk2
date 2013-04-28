<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Resource_Info_Model extends DAO
{

    function __construct() {
        parent::__construct();
        parent::initTable( 'gz_resource_info', 'id' );
        $this->load->database();
    }

    /**
     * 批量审核
     */
    function piliang($data)
    {
        $this->db->trans_start();
        foreach($data as $key=>$val)
        {
            $this->db->update('gz_resource_info',array('status'=>'succeed'),array('id'=>$val));
        }
         $this->db->trans_complete();
        if ( $this->db->trans_status() == FALSE )
        {
            throw Exception( "错误" );
        }
    }
    
    /**
     *批量转换 
     */
//    function piliangzhuanhuan($attr)
//    {
//        foreach ($attr as $key => $val)
//        {    
//                 $this->db->update('gz_resource_info',$val,array('id'=>$key));         
//        }
//       
//    }
}
?>
