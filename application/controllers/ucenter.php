<?php
include_once '_ucenterController.php';

class Ucenter extends UcenterController
{

    function __construct()
    {
        parent::__construct();
    }

    /*
    * 首页
    */
    function index() {
        $this->setComponent('index');
        $this->showTemplate('ucenter_base');
    }


}