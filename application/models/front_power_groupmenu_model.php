<?php
if ( !defined( 'BASEPATH' ) )
  exit( 'No direct script access allowed' );

class Front_Power_Groupmenu_Model extends DAO
{
    public function __construct()
    {
        parent::initTable('gz_front_power_groupmenu', 'id');
    }
    
    
}
?>
