<?php
class ruanjian  extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('sheet1Model');
		$this->load->model('sheet2Model');
	}
	function index(){
		$list = $this->sheet2Model->getAll("`uid` > 0","*","`uid` asc");
		foreach ($list as $l){
			//echo $l['name'];
			if($l['name'] == ""){
				echo '$$$$$$$'."\n";
			}else{
				$arr = $this->sheet1Model->getAll("`url` like '".$l['name']."'");
				if(count($arr) == 0){
					echo '$$$$$$$'."\n";
				}else{
					//print_r($list);
					echo "<li><a href='kecheng.jsp?moduleIds=".$arr[0]['id']."'>".$l['name']."</a></li>";
					echo "\n";
				}
			}
		}
	}
}