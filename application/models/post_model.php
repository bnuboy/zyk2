<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Post_Model extends DAO {

    function __construct() {
        parent::__construct();
        parent::initTable( 'gz_posts', 'id' );
    }
    

    
    
    
    
}
