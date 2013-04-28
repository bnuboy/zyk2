<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Study_Note_Model extends DAO
{

    public function __construct()
    {   
         parent::initTable('gz_study_note', 'id');
    }


}
?>
