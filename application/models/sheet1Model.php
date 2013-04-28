<?php
class sheet1Model extends DAO {
	function __construct(){
		parent::__construct();
		parent::initTable("sheet1", "id");
	}
}