<?php
class sheet2Model extends DAO {
	function __construct(){
		parent::__construct();
		parent::initTable("sheet2", "uid");
	}
}