<?php
include_once "_adminController.php";

class Admin_user extends AdminController {

    function __construct() {
        parent::__construct();
        $this->load->helper('pagestyleclass');
        $this->load->model('User_Model');
        $this->load->model( 'School_Organization_Model');
    }

    /*
    * 用户列表
    */
    function index($start=0) {
        //参数初始化
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $get       = $_GET;
        $limit=10;
        //构造查询
        //构造条件
        $where = array();
        $where[] = "`id` > 0";
        if(!empty($get['type'])) $where[] = "`type` = '".$get['type']."'";
        if(!empty($get['enabled'])) $where[] = "`enabled` = '".$get['enabled']."'";
        if(!empty($get['keyword'])) $where[] = "`login_name` LIKE '%".$get['keyword']."%' OR `name` LIKE '%".$get['keyword']."%'";
        $condition = implode(' AND ', $where);
        //查询数据
        $list = $this->User_Model->getAll($condition, '*', '`id` DESC', $limit, $start);
        $count = $this->User_Model->getCount( $condition );
        //构造分页
        //$page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        //$pagenav  =  $page->showAdmin_1();
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $config[ 'base_url' ] = base_url() . 'admin_user/index';
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        //构造返回参数
        $result = array(
            'pagenav'   =>  $pagination,
            'list'      =>  $list,
            'count'     =>  $count,
            'get'       =>  $get
        );
        $this->setComponent('index', $result);
        $this->showTemplate('admin_base');
    }

    /*
    * 添加/编辑
    */
    function edit() {
        if($_POST){
            $data = $_POST['data'];
               
            $id = $data['id'];
            if(!empty($id)){               
                $data['password'] = md5($data['password']);
                $this->User_Model->update($data, "id = " . $id);
            }else{
                $data['password'] = md5($data['password']);        
                $this->User_Model->insert($data);
            }
            Util::redirect('/admin_user/index');
        }
        $get       = $_GET;
        $data = '';
        if(!empty($_GET['id'])){
            $data = $this->User_Model->getOne("`id` = '".$_GET['id']."'");
        }
        //所有院系/分类
        $organizations = $this->School_Organization_Model->getAll("`f_id` = 0 AND `enabled` = 'y'");
        $result = array(
            'data'          => $data,
            'organizations' => $organizations,
            'get'           => $get
        );
        $this->setComponent( 'edit', $result );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 验证是否存在
    */
    function checkreg(){
        $data      = Util::getPar('data');
        $type      = Util::getPar('type');
        $defaulval = Util::getPar('defaulval');
        
        if($type == 'student_id') {
            $where = "`student_id` = '".$data['student_id']."'";
            if(!empty($defaulval)) $where .= " AND `student_id` <> '".$defaulval."'";
        }
        if($type == 'login_name') {
            $where = "`login_name` = '".$data['login_name']."'";
            if(!empty($defaulval)) $where .= " AND `login_name` <> '".$defaulval."'";
        }
        if($type == 'email') {
            $where = "`email` = '".$data['email']."'";
            if(!empty($defaulval)) $where .= " AND `email` <> '".$defaulval."'";
        }
        $user = $this->User_Model->getOne($where);
        if($user){
            echo 'false';
        }else{
            echo 'true';
        }
        die();
    }

    /*
    * 改变状态 
    */
    function changestatus() {
        $status = Util::getPar('status');
        $url = $_SERVER['HTTP_REFERER'];
        if($_POST){
            $ids = $this->input->post('ids');
            if(empty($ids)){
                Util::redirect($url, '请选择要改变状态的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect($url, '请选择要改变状态的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $data = array(
            'enabled' => $status
        );
        $this->User_Model->update($data, $where);
        Util::redirect($url);
    }


    /*
    * 删除
    */
    function del() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect($url, '请选择要删除的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect($url, '请选择要删除的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->User_Model->delete($where);
        Util::redirect('/admin_user/index/');
    }

    /*
    * 用户导入
    */
    function import(){
        if($_POST){
            $templateRow = array(0 => '登录名(login_name)', 1 => '姓名(name)', 2 => '密码(password)', 3 => '学号(student_id)', 4 => '所属院系(organization_id)', 5 => '邮件地址(email)',  6 => '性别(gender)', 7 => '用户角色(type)');
            $error = FALSE;
            $errormsg = array();
            $usererror = array();
            $errordatamsg = array();
            $i = 0;  //已导入用户
            $j = 0;  //导入失败用户
            if ($_FILES["file"]["error"] > 0) {
                $error = TRUE;
                $errormsg[] = "上传的excel文件错误!";
            }
            //判断扩展名
            $fileext = Util::get_extension($_FILES['file']['name']);
            $fileext = strtolower($fileext);
            if(!in_array($fileext, array('xls'))){
                $error = TRUE;
                $errormsg[] = "文件扩展名错误,只能导入EXCEL文件!!";
            }
            //判断大小
            if (Util::byteChange($_FILES['file']['size'], 'MB') > 5){
                $error = TRUE;
                $errormsg[] = "文件大小不能超过5MB！";
            }
            if(!$error){
                //处理数据
                $excelFile = $_FILES["file"]["tmp_name"];
                $this->load->helper('Excel');
                $datas = Excel::getValues($excelFile, 'Excel5', 0, 2);
                if(!empty($datas)){
                    foreach($datas as $k => $v){
                        //判断登录名是否存在
                        if(empty($v[0])){
                            $usererror[$k][] = "第".($k+1)."行登录名为空";
                        }else{
                            $count = $this->User_Model->getCount("`login_name` = '".$v[0]."'");
                            if($count > 0){
                                $usererror[$k][] = "第".($k+1)."行<span style='color:red;font-weight:bold;'>$v[0]</span>登录名已被占用";
                            }
                        }
                        //判断姓名
                        if(empty($v[1]))  $usererror[$k][] = "第".($k+1)."行姓名为空";
                        //判断密码
                        if(empty($v[2]))  $usererror[$k][] = "第".($k+1)."行密码为空";
                        //判断学号是否存在
                        if(empty($v[3])){
                            $usererror[$k][] = "第".($k+1)."行学号为空";
                        }else{
                            $count = $this->User_Model->getCount("`student_id` = '".$v[3]."'");
                            if($count > 0){
                                $usererror[$k][] = "第".($k+1)."行<span style='color:red;font-weight:bold;'>$v[3]</span>学号已被占用";
                            }
                        }
                        //判断院系是否存在
                        if(empty($v[4])){
                            $usererror[$k][] = "第".($k+1)."行院线为空";
                        }else{
                            $org = $this->School_Organization_Model->getOne("`name` = '".$v[4]."' AND `f_id` = 0");
                            if(empty($org)){
                                $usererror[$k][] = "第".($k+1)."行<span style='color:red;font-weight:bold;'>$v[4]</span>院线不存在";
                            }
                        }
                        //判断邮件地址是否存在
                        if(empty($v[5])){
                            $usererror[$k][] = "第".($k+1)."行电子邮件为空";
                        }else{
                            $count = $this->User_Model->getCount("`email` = '".$v[5]."'");
                            if($count > 0){
                                $usererror[$k][] = "第".($k+1)."行<span style='color:red;font-weight:bold;'>$v[5]</span>电子邮件已被占用";
                            }
                        }
                        //判断性别是否合法
                        $sex = '';
                        if(empty($v[6])){
                            $usererror[$k][] = "第".($k+1)."行性别为空";
                        }else{
                            if($v[6] == '男'){
                                $sex = 'm';
                            }else if($v[6] == '女'){
                                $sex = 'f';
                            }else{
                                $usererror[$k][] = "第".($k+1)."行<span style='color:red;font-weight:bold;'>$v[6]</span>性别不正确";
                            }
                        }
                        //判断身份是否存在
                        if(empty($v[7])) {
                            $usererror[$k][] = "第".($k+1)."行用户身份为空";
                        }else{
                            $type = "";
                            $USER_TYPE = array('teacher' => '教师', 'student' => '学生', 'worker' => '工作人员', 'manager' => '前台管理员', 'assistant' => '助教', 'enterprise' => '企业', 'outsideteacher' => '校外教师', 'patriarch' => '家长', 'headmaster' => '校长');
                            foreach($USER_TYPE as $uk => $uv){
                                if($uv == $v[7]) $type = $uk;
                            }
                            if(empty($type)) $usererror[$k][] = "第".($k+1)."行<span style='color:red;font-weight:bold;'>$v[7]</span>用户身份不存在";
                        }

                        if(!empty($usererror[$k])){
                            $j = $j + 1;
                        }else{
                            $i = $i + 1;
                            $user = array(
                                'login_name'      => $v[0],
                                'name'            => $v[1],
                                'password'        => md5($v[2]),
                                'student_id'      => $v[3],
                                'organization_id' => $org['id'],
                                'email'           => $v[5],
                                'gender'          => $sex,
                                'type'            => $type
                            );
                            $this->User_Model->insert($user);
                        }
                    }
                }else{
                    $errormsg[] = "导入数据为空";
                }
            }
            //返回数据
            $result = array(
                'errormsg'  => $errormsg,
                'error'     => $error,
                'usererror' => $usererror,
                'i'         => $i,
                'j'         => $j
            );
            $this->setComponent('import', $result);
            $this->showTemplate('admin_base');
        } else {
            $this->setComponent('import');
            $this->showTemplate('admin_base');
        }
    }

}