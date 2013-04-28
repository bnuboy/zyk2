<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Sys_Notice_Model extends DAO
{

    function __construct() {
        parent::initTable( 'gz_sys_notice', 'id' );
    }

}
?>
