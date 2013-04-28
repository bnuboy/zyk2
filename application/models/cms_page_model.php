<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Cms_Page_Model extends DAO
{

    function __construct() {
        parent::initTable( 'gz_cms_page', 'id' );
    }

}
?>
