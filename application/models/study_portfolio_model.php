<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Study_Portfolio_Model extends DAO
{

    function __construct()
    {
        parent::__construct();
        parent::initTable( 'gz_study_select_course', 'id' );
    }
}
?>
