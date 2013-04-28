<?php
include_once "_adminController.php";

class Admin_zuzhi_saiwu extends AdminController {

    function __construct(){
        parent::__construct();
        $this->load->model('Sys_Notice_Model');
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
        $this->setComponent('home', $result );
        $this->showTemplate('admin_base');
    }

}