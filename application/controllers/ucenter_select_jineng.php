<?php
include_once '_ucenterController.php';

class ucenter_select_jineng extends UcenterController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model( 'Study_Course_Model' );
        $this->load->model( 'Resource_Library_Model' );
        $this->load->model( 'School_Organization_Model');
        $this->load->model( 'Study_Course_Cat_Model' );
        $this->load->model( 'Study_Course_Join_Teacher_Model' );
        $this->load->model( 'Study_Select_Course_Model' );
        $this->load->model( 'User_Model' );
        $this->load->model('Study_Course_Part_Model');
        $this->load->model('Study_Course_Class_Model');
        $this->load->model("Study_Coursenotice_Model");
        $this->load->model("Study_MyTest_Model");
        $this->load->model("Study_Teachinfo_Model");
        $this->load->model("Study_Question_Model");
        $this->load->model("Study_Teach_Manage_Model");
        $this->load->model("User_Model");
        $this->load->model("usermodel");
        $this->load->model("postModel");
        $this->load->model("Study_HomeWork_Model");
        $this->load->model("Study_Course_Class_Model");
        $this->load->model("Study_Class_Join_User_Model");
    }

    /*
    * 未选课程列表
    */
    function index($id=0){
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $where='';
        $where = '`id` > 0';
        $catnav = array();
        if(!empty($_GET['name']))
            $where .=' AND `name` like "%'.$_GET['name'].'%"';
        if($id!='0'){$where.=' AND `organization_id` = '.$id;};
        //查询已选中的课程
        $xuanke=$this->Study_Select_Course_Model->getAll("`user_id` = " .$this->user['id']." AND `status` = 'audit'","course_id");
        if($xuanke){
        foreach($xuanke as $val){
            $courses[]=$val['course_id'];
        }
        $course_id=implode(',', $courses);
        $where.=" AND `id` NOT IN (".$course_id.")";
        }
        $where.=" AND `status` = 'audit'";
        $list = $this->Study_Course_Model->getAll($where, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize );
        if(!empty($id)) $catnav = $this->School_Organization_Model->getParents($id, 'id, f_id, name');
        $organizations = $this->School_Organization_Model->getAll("`id` > 0",'*','id desc');
        $count = $this->Study_Course_Model->getCount( $where );
        foreach($list as $k => $v){
            $list[$k]['organization'] = $this->School_Organization_Model->getOne("`id` = '".$v['organization_id']."'");
            $list[$k]['cat']          = $this->Study_Course_Cat_Model->getOne("`id` = '".$v['classify_cat_id']."'");
            $list[$k]['teachers']     = $this->Study_Course_Model->getTeachers($v['id']);
            $list[$k]['xuanke']       = $this->Study_Select_Course_Model->getOne('`course_id` ='.$v['id'].' AND `user_id`='.$this->user['id']);
        }
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showWeb_1();
        $result = array(
            'list'         => $list,
            'count'        => $count,
            'pagination'   => $pagination,
            'organizations' => $organizations,
            "get"          => $_GET,
            'catnav'       => $catnav,
        );
        $this->setComponent('course_list',$result);
        $this->showTemplate('ucenter_select_base');
    }

    /*
     * 查看
     */
    function view($id){
       $catnav=array();
       $organizations = $this->School_Organization_Model->getAll("`id` > 0",'*','id desc');
       $course_info=$this->Study_Course_Model->getOne("`id` = " .$id);
       $organization=  $this->School_Organization_Model->getOne('`id` ='.$course_info['organization_id'],'name');
       $course_cat=  $this->Study_Course_Cat_Model->getOne('`id` ='.$course_info['classify_cat_id'],'name');
       if(!empty($id)) $catnav = $this->School_Organization_Model->getParents($id, 'id, f_id, name');
       $result=array(
           "organization"  =>$organization,
           "organizations" =>$organizations,
           'course_info'   =>$course_info,
           'course_cat'    => $course_cat,
           'catnav'        => $catnav
       );
       $this->setComponent('course_view',$result);
       $this->showTemplate('ucenter_select_base');
    }
//    function index($id=0) {
//        if($this->user['type'] == 'teacher'){
//            self::course_teache_list($id);
//        }else if($this->user['type'] == 'student'){
//            self::course_student_list($id);
//        }else{
//            die('the user is null');
//        }
//    }

//      /*
//    * 老师课程列表
//    */
//    function course_teache_list($id=0) {
//        $where = array();
//        //我的课程ids
//        $courseids = '';
//        $course_ids = array();
//        $courseids = $this->Study_Course_Join_Teacher_Model->getAll();
//        if(!empty($courseids)){
//            foreach($courseids as $v){
//                $course_ids[]  = $v['course_id'];
//            }
//            $courseids = implode(',', $course_ids);
//            $where[] = "`id` in (".$courseids.")";
//        }else{
//            $where[] = 'id < 0';
//        }
//        if($id!='0'){$where[]='`organization_id` = '.$id;};
//        $condition = implode(' AND ', $where);
//
//        $list = $this->Study_Course_Model->getAll($condition, '*', '`id` DESC' );
//        $classify = $this->School_Organization_Model->getAll("`id` > 0",'*','id desc');
//        $count = $this->Study_Course_Model->getCount( $condition );
//        //关联项
//        foreach($list as $k => $v){
//            $list[$k]['teachers']     = $this->Study_Course_Model->getTeachers($v['id']);
//        }
//        $this->setComponent( 'course_teache_list', array('list' => $list,"classify"=>$classify) );
//        $this->showTemplate( 'ucenter_select_base' );
//    }

    /**
     * 课程列表
     */

    function course_student_list($id=0)
    {
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $where='';
        $where = '`id` > 0';
        if(!empty($_GET['name']))
            $where .=' AND `name` like "%'.$_GET['name'].'%"';
        if($id!='0'){$where.=' AND `organization_id` = '.$id;};
        //查询已选中的课程
        $xuanke=$this->Study_Select_Course_Model->getAll("`user_id` = " .$this->user['id']." AND `status` = 'audit'","course_id");
        if($xuanke){
        foreach($xuanke as $val){
            $courses[]=$val['course_id'];
        }
        $course_id=implode(',', $courses);
        $where.=" AND `id` NOT IN (".$course_id.")";
        }
        $where.=" AND `status` = 'audit'";
        $list = $this->Study_Course_Model->getAll($where, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize );
        $classify = $this->School_Organization_Model->getAll("`id` > 0",'*','id desc');
        $count = $this->Study_Course_Model->getCount( $where );
        foreach($list as $k => $v){
            $list[$k]['organization'] = $this->School_Organization_Model->getOne("`id` = '".$v['organization_id']."'");
            $list[$k]['cat']          = $this->Study_Course_Cat_Model->getOne("`id` = '".$v['classify_cat_id']."'");
            $list[$k]['teachers']     = $this->Study_Course_Model->getTeachers($v['id']);
            $list[$k]['xuanke']       = $this->Study_Select_Course_Model->getOne('`course_id` ='.$v['id'].' AND `user_id`='.$this->user['id']);
        }
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showWeb_1();
        $result = array(
            'list' => $list,
            'count'=> $count,
            'pagination' => $pagination,
            'classify'   => $classify,
            "get"        => $_GET
        );
        $this->setComponent('course_list',$result);
        $this->showTemplate('ucenter_select_base');
    }



}