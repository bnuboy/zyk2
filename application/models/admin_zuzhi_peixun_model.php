<?php
if(!defined('BASEPATH'))
	exit( 'No direct script access allowed' );
class admin_zuzhi_peixun_model extends DAO{
	function __construct(){
		parent::__construct();
		parent::initTable('gz_admin_zuzhi_peixun', 'id');
	}
}