<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Study_Coursenotice_Model extends DAO
{

    function __construct()
    {
        parent::__construct();
        parent::initTable( 'gz_study_coursenotice', 'id' );
        $this->load->database();
    }


}
?>
