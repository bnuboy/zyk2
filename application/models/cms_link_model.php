<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Cms_Link_Model extends DAO
{

    function __construct() {
        parent::initTable( 'gz_cms_link', 'id' );
    }

}
?>
