<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class User_Agenda_Model extends DAO
{

    function __construct() {
        parent::initTable( 'gz_user_agenda', 'id' );
    }

}
?>
