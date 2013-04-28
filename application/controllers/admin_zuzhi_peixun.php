<?php
include_once "_adminController.php";

class Admin_zuzhi_peixun extends AdminController {

    function __construct(){
        parent::__construct();
        $this->load->model('Sys_Notice_Model');
        $this->load->model('admin_zuzhi_peixun_model');
    }

    /*
    * 首页
    */
    function index() {
        //公告
        $notices = $this->Sys_Notice_Model->getAll('id > 0', '*', '`id` DESC');
        $result = array(
            'notices' => $notices
        );
        $this->setComponent('addpeixun', $result );
        $this->showTemplate('admin_base');
    }
    function add(){
	    if($_POST){
	    		$p = $_POST;
	    		$n = count($p['content']);
	    		echo "$n";
	    		for($i = 0; $i < $n; $i ++){
	    			$data = array(
	    				'content' => $p['content'][$i],
	    				'danwei' => $p['danwei'][$i],
	    				'jiaoshi' => $p['jiaoshi'][$i],
	    				'renyuan' => $p['renyuan'][$i],
	    				'shijian' => $p['shijian'][$i],
	    				'didian' => $p['didian'][$i]
	    			);
	    			$this->admin_zuzhi_peixun_model->insert($data);
	    		}
	    		
    	}
    	
    }

}