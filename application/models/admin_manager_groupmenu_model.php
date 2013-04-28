<?php
if ( !defined( 'BASEPATH' ) )
  exit( 'No direct script access allowed' );

class Admin_Manager_Groupmenu_Model extends DAO
{
    public function __construct()
    {
        parent::initTable('gz_admin_manager_groupmenu', 'id');
    }
    
    
}
?>
