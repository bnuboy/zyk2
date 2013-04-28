<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Admin_Cms_Logo_Model extends DAO
{

    function __construct() {
        parent::initTable( 'gz_admin_cmslogo', 'id' );
    }

}
?>
