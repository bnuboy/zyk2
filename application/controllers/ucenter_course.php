<?php
include_once '_ucenterController.php';

class Ucenter_Course extends UcenterController
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
        $this->load->model( 'Study_Course_Part_Model');
        $this->load->model( 'Study_Course_Class_Model');
        $this->load->model( 'Study_Course_Groupmenu_Model');
        $this->load->model('Study_Course_Menu_Model');
        
        
    }

    /*
    * 老师课程列表
    */
    function mycourseselect() {
        if($this->user['type'] == 'teacher'){
            self::course_teache_list();
        }else if($this->user['type'] == 'student'){
            self::course_student_list();
        }else{
            die('the user is null');
        }
    }

    /*
    * 老师课程列表
    */
    function course_teache_list() {
        $where = array();
        //我的课程ids
        $courseids = '';
        $course_ids = array();
        $courseids = $this->Study_Course_Join_Teacher_Model->getAll("`teacher_id` = '".$this->user['id']."'");
        if(!empty($courseids)){
            foreach($courseids as $v){
                $course_ids[]  = $v['course_id'];
            }
            $courseids = implode(',', $course_ids);
            $where[] = "`id` in (".$courseids.")";
        }else{
            $where[] = 'id < 0';
        }
        $condition = implode(' AND ', $where);

        //$lists = $this->Study_Course_Model->getAll($condition, '*', '`id` DESC' );
        $lists = $this->Study_Select_Course_Model->get_teacher_course("`gz_study_course_join_teacher`.`teacher_id` = '".$this->user['id']."'",'`gz_study_course`.created DESC');
       $list1 = $this->Study_Select_Course_Model->teacher_select(array('`gz_study_select_course`.user_id'=>  $this->user['id']));
        if(!empty($list1))
        {
            foreach($list1 as $key=>$val)
            {
                $list1[$key]['banji'] = $this->Study_Select_Course_Model->get_class(array('id'=>$val['course_class_id']));
            }
        }
        $list = array_merge($lists,$list1);
        $count = $this->Study_Course_Model->getCount( $condition );
        //关联项
//        foreach($list as $k => $v){
//            $list[$k]['organization'] = $this->School_Organization_Model->getOne("`id` = '".$v['organization_id']."'");
//            $list[$k]['cat']          = $this->Study_Course_Cat_Model->getOne("`id` = '".$v['classify_cat_id']."'");
//            $list[$k]['teachers']     = $this->Study_Course_Model->getTeachers($v['id']);          
//        }
        $this->setComponent( 'course_teache_list', array('list' => $list) );
        $this->showTemplate( 'ucenter_base' );
    }

    /*
    * 学生课程列表

    function course_student_list() {
        $select = "user.id as userid, course.name as coursename, course.id as courseid,user.name as username, class.name as classname, select_course.status as coursestatus, select_course.created, study_patterntype.name as partname";
        $where = "`user`.`id` = " . $this->user['id'] . " AND course.id <> ''";
        $list = $this->User_Model->myCourseInfo($where, $select);
        $this->setComponent( 'course_student_list', array('list' => $list) );
        $this->showTemplate( 'ucenter_base' );
    }
    */


    /**
     * 课程列表
     */

    function course_student_list($start=0)
    {
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $where='';
        $limit=10;
        $where = '`gz_study_select_course`.`id` > 0 and `gz_study_select_course`.`user_id` ='.$this->user['id'];
        $get=  $this->input->get();
        if($get['classify_cat_id'])
            $where .=' AND `gz_study_course`.`classify_cat_id`='.$get['classify_cat_id'];
        if($get['name'])
            $where .=' AND `gz_study_course`.`name` like "%'.$get['name'].'%"';
        //$list = $this->Study_Course_Model->getAll($where, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize );
        //$count = $this->Study_Course_Model->getCount( $where );
        $list = $this->Study_Select_Course_Model->get_student_select($where,$limit,$start);
        $count = $this->Study_Select_Course_Model->get_student_count($where);
        if(!empty($list))
        {
            foreach($list as $key=>$val)
            {
                $list[$key]['banji'] = $this->Study_Select_Course_Model->get_class(array('id'=>$val['course_class_id']));
            }
        }
        $classify = $this->Study_Course_Cat_Model->getAll("`id` > 0",'*','id desc');
//        foreach($list as $k => $v){
//            $list[$k]['organization'] = $this->School_Organization_Model->getOne("`id` = '".$v['organization_id']."'");
//            $list[$k]['cat']          = $this->Study_Course_Cat_Model->getOne("`id` = '".$v['classify_cat_id']."'");
//            $list[$k]['teachers']     = $this->Study_Course_Model->getTeachers($v['id']);
//            $list[$k]['xuanke']       = $this->Study_Select_Course_Model->getOne('`course_id` ='.$v['id'].' AND `user_id`='.$this->user['id']);
//        }

        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showWeb_1();
//        $config['base_url']   = base_url().'ucenter_course/course_student_list';
//        $config['per_page']   = $limit;
//        $config['total_rows'] = $count;
//        $this->adminpagination->initialize($config);
//        $pagination = $this->adminpagination->create_links();
        $result = array(
            'list'       => $list,
            'count'      => $count,
            'pagination' => $pagination,
            'get'        => $get,
            'classify'   => $classify
        );//echo BASEPATH;
        $this->setComponent('course_list',$result);
        $this->showTemplate('ucenter_base');
    }

    /**
     * 开始选课
     */

    function select_course($id)
    {
       $parts=array();
       $part = $this->Study_Course_Part_Model->getAll('id > 0','*','id desc');
       if(!empty ($part))
       {
           foreach($part as $key=>$val)
           {
               if($val['name'] !='教师')
               {
                   $parts[]=$val;  
               }
           }
       }
       $info = $this->Study_Course_Model->getOne('`id`='.$id);
       $class = $this->Study_Course_Class_Model->getAll('`course_id` ='.$id,'*','`id` desc');
       $result = array(
           'id'   => $id,
           'part' => $parts,
           'info' => $info,
           'class' => $class
       );
       $this->setComponent('select_course',$result);
       $this->showTemplate('base');
    }

    function add($id)
    {
        if($_POST){
            $_POST['user_id'] = $this->user['id'];
            $_POST['course_id'] = $id;
            $_POST['created'] = date('Y-m-d H:i:s', mktime());
        }
        $this->Study_Select_Course_Model->insert($_POST);
         echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
    }
    
    
   /*
    * 创建课程
    */
    function courseedit() {
        if($_POST){
            $data = $_POST['data'];             
                $data['status'] = 'wait';
                $data['user_id']=  $this->user['id'];
                $data['created'] = date('Y-m-d H:i:s', time());
                $id = $this->Study_Course_Model->insert($data);      
            //课程教师
            if(!empty($_POST['teacher_ids'])){
                $this->Study_Course_Join_Teacher_Model->delete("`course_id` = '".$id."'");
                //删除课程权限
                $this->Study_Course_Groupmenu_Model->delete("`course_id` = ".$id." AND `user_type` ='10003'");
                if(  !in_array( $this->user['id'],explode(',', $_POST['teacher_ids']) )){
                   $_POST['teacher_ids'] .=",".$this->user['id'];
                }
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
            Util::redirect('/ucenter_course/mycourseselect');
        }
        $data = '';
        $teachers = '';
        if(!empty($_GET['id'])){
            $data = $this->Study_Course_Model->getOne("`id` = '".$_GET['id']."'");
            $teachers = $this->Study_Course_Model->getTeachers($_GET['id']);
        }
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
            'user_id'       => $this->user['id']
        );
        $this->setComponent( 'courseedit', $result );
        $this->showTemplate( 'ucenter_base' );
    }

    function tuike($course_id,$user_id)
    {
        try{
            $this->Study_Select_Course_Model->tuike($course_id,$user_id);
            $this->AJAXSuccess('退课成功');
        }
        catch (Exception $ex)
        {
            $this->AJAXFail('退课失败！');
        }
        
    }

}