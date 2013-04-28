<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Resource_Comment_Model extends DAO
{

    function __construct() {
        parent::__construct();
        parent::initTable( 'gz_resource_comment', 'id' );
        $this->load->database();
    }
    
    
}
