<?php

class Common extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('imgcode');
    }

    /*
    * 显示验证码
    */
    function getVerificationCode() {
        $this->imgcode->image('0', '5');
    }

    /*
    * 资源库分类下拉带复选框选择
    */
    function resource_cat_select_checkbox(){
        $this->load->model('Resource_Cat_Model');
        $this->load->model('School_Organization_Model');
        $library_id = !empty($_POST['library_id']) ? $_POST['library_id'] : '';    // 所属资源库
        $inputid    = !empty($_POST['inputid']) ? $_POST['inputid'] : '';          // 控件ID 
        $inputname  = !empty($_POST['inputname']) ? $_POST['inputname'] : '';      // 控件NAME 
        $defaultval = !empty($_POST['defaultval']) ? $_POST['defaultval'] : '';    // 默认值
        if(empty($library_id)) die('<span style=>请选择所属资源库</span>');
        if(empty($inputid)) die('请传入控件ID');
        if(empty($inputname)) die('请传入控件NAME');
        $cats = $this->Resource_Cat_Model->getAll("`library_id` = '".$library_id."'");
        $result = array(
            'inputid'    => $inputid,
            'inputname'  => $inputname,
            'defaultval' => $defaultval,
            'cats'       => $cats
        );
        $this->load->view( "components/common/resource_cat_select_checkbox", $result );
    }
    
    /*
    * 用户下拉带复选框选择
    */
    function user_select_checkbox(){
        $this->load->model('User_Model');
        $where = !empty($_POST['where']) ? $_POST['where'] : '';                   // 条件
        $inputid    = !empty($_POST['inputid']) ? $_POST['inputid'] : '';          // 控件ID 
        $inputname  = !empty($_POST['inputname']) ? $_POST['inputname'] : '';      // 控件NAME 
        $defaultval = !empty($_POST['defaultval']) ? $_POST['defaultval'] : '';    // 默认值
        if(empty($inputid)) die('请传入控件ID');
        if(empty($inputname)) die('请传入控件NAME');
        $users = $this->User_Model->getAll($where);
        $result = array(
            'inputid'    => $inputid,
            'inputname'  => $inputname,
            'defaultval' => $defaultval,
            'users'       => $users
        );
        $this->load->view( "components/common/user_select_checkbox", $result );
    }

    /*
     * 院系下cms菜单
    */
    function getCmsMenus(){
        $this->load->model('Cms_Menu_Model');
        $id  = empty($_POST['id'])?0:$_POST['id'];
        $defaultid  = empty($_POST['defaultid'])?0:$_POST['defaultid'];
        $whr  = empty($_POST['whr'])?0:$_POST['whr'];
        $options = "<option value=''>==请选择==</option>";
        if(!empty($id)){
            $where = "`school_org_id` = '".$id."'";
            if(!empty($whr)) $where .= " AND " . $whr;
            $citys = $this->Cms_Menu_Model->getAll($where, "*", "`id` DESC");
            foreach($citys as $item){
                $selected = '';
                if($item['id'] == $defaultid) $selected = 'selected';
                $options .= "<option value='".$item['id']."' ".$selected." >" . $item['name'] . "</option>";
            }
        }
        echo $options;
    }


}