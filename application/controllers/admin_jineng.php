<?php
include_once "_adminController.php";

class Admin_jineng extends AdminController
{

    function __construct() {
        parent::__construct();
        $this->load->model( 'Study_Course_Model' );
        $this->load->model( 'Resource_Library_Model' );
        $this->load->model( 'School_Organization_Model');
        $this->load->model( 'Study_Course_Cat_Model' );
        $this->load->model( 'Study_Course_Join_Teacher_Model' );
        $this->load->model('Study_Course_Groupmenu_Model');
        $this->load->model('Study_Course_Menu_Model');
        $this->load->library('adminpagination');
    }

    /*
    * 课程列表
    */
    function courselist($start=0) {
        $get = $this->input->get();
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $where = array();
        $limit=10;
        $where[] = 'id > 0';
        //院系管理员
        if($this->type=='organization'){$where[] = "`organization_id` = '".$this->admin['organization_id']."'";}
        if(!empty($get['name'])) $where[] = "`name` like '%".$get['name']."%'";
        if(!empty($get['status'])) $where[] = "`status` = '".$get['status']."'";
        if(!empty($get['organization_id'])) $where[] = "`organization_id` = '".$get['organization_id']."'";
        if(!empty($get['classify_cat_id'])) $where[] = "`classify_cat_id` = '".$get['classify_cat_id']."'";
        $condition = implode(' AND ', $where);

        $list = $this->Study_Course_Model->getAll($condition, '*', '`id` DESC', $limit, $start );
        $count = $this->Study_Course_Model->getCount( $condition );
        //
        foreach($list as $k => $v){
            $list[$k]['organization'] = $this->School_Organization_Model->getOne("`id` = '".$v['organization_id']."'");
            $list[$k]['cat']          = $this->Study_Course_Cat_Model->getOne("`id` = '".$v['classify_cat_id']."'");
            $list[$k]['teachers']     = $this->Study_Course_Model->getTeachers($v['id']);
            
        }
        //所有院系
        $organizations = $this->School_Organization_Model->getTrees("`enabled` = 'y'");
        $cats = $this->Study_Course_Cat_Model->getAll();
        //
        //$page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        //$pagination  =  $page->showAdmin_1();
         $config[ 'total_rows' ] = $count;
         $config[ 'per_page' ] = $limit;
         $config[ 'base_url' ] = base_url() . 'admin_study_course/courselist';
         $this->adminpagination->initialize( $config );
         $pagination = $this->adminpagination->create_links();
        $result = array(
            'list'          => $list, 
            "pagination"    => $pagination, 
            'count'         => $count, 
            'organizations' => $organizations,
            'cats'          => $cats,
            'get'           => $get
        );
        $this->setComponent( 'courselist', $result );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 编辑课程
    */
    function courseedit() {
        if($_POST){//print_r($_POST);exit;
            $data = $_POST['data'];
            $id = $data['id'];
            if($this->type=='organization'){$data['organization_id'] = $this->admin['organization_id'];}
            if(!empty($id)){
                if(!empty($_POST['teacher_ids']) && !empty($id)){
                    $this->Study_Course_Join_Teacher_Model->delete("`course_id` = ".$id);
                    foreach(explode(',', $_POST['teacher_ids']) as $k => $v){
                        $this->Study_Course_Join_Teacher_Model->insert(array('course_id' => $id, 'teacher_id' => $v));
                    }
                }
                $this->Study_Course_Model->update($data, "id = " . $id);
            }else{
                unset($data['id']);
                $data['status'] = 'wait';
                $data['user_id']=  $this->admin['id'];
                $data['created'] = date('Y-m-d H:i:s', time());
                $id = $this->Study_Course_Model->insert($data);
                //课程教师
            if(!empty($_POST['teacher_ids']) && !empty($id)){
                foreach(explode(',', $_POST['teacher_ids']) as $k => $v){
                    $this->Study_Course_Join_Teacher_Model->insert(array('course_id' => $id, 'teacher_id' => $v));
                }
            }
            //查出教师应有的权限
            $menu=$this->Study_Course_Menu_Model->getAll("`typeview` like 'teacher%'","id");
               //插入权限
            foreach($menu as $val){
                   $this->Study_Course_Groupmenu_Model->insert(array("course_id"=>$id,"user_type"=>"10003","menu_id"=>$val['id']));
                }
            //添加学生权限
            $stu_menu=$this->Study_Course_Menu_Model->getAll("(`typeview` = 'student' OR `typeview` like 'student,%' OR `typeview` like '%,student' OR `typeview` like '%,student,%')","id");
            foreach($stu_menu as $v){
                        $this->Study_Course_Groupmenu_Model->insert(array("course_id"=>$id,"user_type"=>"10002","menu_id"=>$v['id']));
                    }
            }
            Util::redirect('/admin_study_course/courselist');
        }
        $data = '';
        $teachers = '';
        if(!empty($_GET['id'])){
            $data = $this->Study_Course_Model->getOne("`id` = '".$_GET['id']."'");
            $teachers = $this->Study_Course_Model->getTeachers($_GET['id']);
        }
        //院系管理员
        $org='';
        if($this->type=='organization'){$org = $this->admin['organization_id'];}
        //关联数据
        $organizations = $this->School_Organization_Model->getAll("`f_id` = 0");
        $cats          = $this->Study_Course_Cat_Model->getAll("`id` > 0");
        $libs          = $this->Resource_Library_Model->getAll("`id` > 0");
        $result = array(
            'data'          => $data,
            'organizations' => $organizations,
            'cats'          => $cats,
            'teachers'      => $teachers,
            'libs'          => $libs,
            'org'           => $org
        );
        $this->setComponent( 'courseedit', $result );
        $this->showTemplate( 'admin_base' );
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
            'status' => $status
        );
        $this->Study_Course_Model->update($data, $where);
        Util::redirect($url);
    }
    /*
    * 删除
    */
    function coursedel() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect('/admin_study_course/courselist', '请选择要删除的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect('/admin_study_course/courselist', '请选择要删除的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->Study_Course_Model->delete($where);
        Util::redirect('/admin_study_course/courselist');
    }

    /*
    * 待审核课程
    */
    function coursewaitlist($start=0) {
        $get = $this->input->get();
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $limit=10;
        $where = array();
        //院系管理员
        if($this->type=='organization'){$where[] = "`organization_id` = '".$this->admin['organization_id']."'";}
        $where[] = "`status` = 'wait'";
        if(isset($get['name'])) $where[] = "`name` like '%".$get['name']."%'";
        $condition = implode(' AND ', $where);

        $list = $this->Study_Course_Model->getAll($condition, '*', '`id` DESC', $limit, $start );
        $count = $this->Study_Course_Model->getCount( $condition );
        //
        foreach($list as $k => $v){
            $list[$k]['organization'] = $this->School_Organization_Model->getOne("`id` = '".$v['organization_id']."'");
            $list[$k]['cat']          = $this->Study_Course_Cat_Model->getOne("`id` = '".$v['classify_cat_id']."'");
            $list[$k]['teachers']     = $this->Study_Course_Model->getTeachers($v['id']);
        }
        //
        //$page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
       // $pagination  =  $page->showAdmin_1();
         $config[ 'total_rows' ] = $count;
         $config[ 'per_page' ] = $limit;
         $config[ 'base_url' ] = base_url() . 'admin_study_course/coursewaitlist';
         $this->adminpagination->initialize( $config );
         $pagination = $this->adminpagination->create_links();
        $this->setComponent( 'coursewaitlist', array('list' => $list, "pagination" => $pagination, 'count' => $count, 'get' => $get) );
        $this->showTemplate( 'admin_base' );
    }


    /*
    * 审核
    */
    function courseaudit() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect('/admin_study_course/coursewaitlist', '请选择要审核的课程');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect('/admin_study_course/coursewaitlist', '请选择要审核的课程');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->Study_Course_Model->update(array('status' => 'audit'), $where);
        Util::redirect('/admin_study_course/coursewaitlist');
    }
    

}

