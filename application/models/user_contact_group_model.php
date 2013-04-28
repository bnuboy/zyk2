<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class User_Contact_Group_Model extends DAO
{

    function __construct() {
        parent::initTable( 'gz_user_contact_group', 'id' );
    }

}
?>
