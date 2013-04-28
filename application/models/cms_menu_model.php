<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Cms_Menu_Model extends DAO
{

    function __construct() {
        parent::initTable( 'gz_cms_menu', 'id' );
    }

}
?>
