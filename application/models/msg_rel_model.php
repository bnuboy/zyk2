<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Msg_Rel_Model extends DAO {

    function __construct() {
        parent::__construct();
        parent::initTable( 'gz_msg_rel', 'id' );
    }
    
    
    
    
    
}