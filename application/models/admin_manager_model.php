<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Admin_Manager_Model extends DAO
{

    function __construct()
    {
        parent::__construct();
        parent::initTable( 'gz_admin_manager', 'id' );
        $this->load->database();
    }
    
}
?>
