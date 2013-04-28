<?php
include_once '_studyController.php';

class Study extends StudyController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Study_Course_Model");
        $this->load->model("Study_Coursenotice_Model");
        $this->load->model("School_Organization_Model");
        $this->load->model("Study_Course_Cat_Model");
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
    * 首页
    */
    function index() {
        //构造条件
        $works=array();
        $course_id=$this->course['id'];
        $course_info=$this->Study_Course_Model->getOne("`id` = " .$course_id);
        $organization=  $this->School_Organization_Model->getOne('`id` ='.$course_info['organization_id'],'name');
        $course_cat=  $this->Study_Course_Cat_Model->getOne('`id` ='.$course_info['classify_cat_id'],'name');
        $course_notice=$this->Study_Coursenotice_Model->getAll("`course_id` = " .$course_id,'id,title,created','created desc',10,0);
        $count_mytest=  $this->Study_MyTest_Model->getCount("`course_id` = " .$course_id);
        $count_teachinfo=  $this->Study_Teachinfo_Model->getCount("`course_id` = " .$course_id);
        $count_question=  $this->Study_Question_Model->getCount("`course_id` = " .$course_id);
        $select_course = $this->Study_Teach_Manage_Model->get_select_course( "`course_id` = " .$course_id." AND `status`='wait'", '10', '0' );
        $question= $this->Study_Question_Model->getAll("`course_id` = " .$course_id,"*","qtime desc",10,0);
        foreach($question as $key=>$val){
            $question[$key]['user']=$this->User_Model->getOne("`id` = ".$val['quser_id'],'name');
        }
        $post=$this->postModel->getList(array(),10,0,'created desc');
        foreach($post as $k=>$v){
            $user=$this->usermodel->getInfo("`id` = ".$v->user_id,'name');
            $v->user=$user->name;
        }
        //班级信息查出用户的角色
        $part="10003";
        $user_part= $this->Study_Select_Course_Model->getOne('`user_id` = '.$this->user['id']." AND `course_id` = ".$this->course['id'],'course_part_id');      
        if($user_part){
            $part=$user_part['course_part_id'];
        }
        $stu_count=  $this->Study_Select_Course_Model->getCount("`course_part_id` = '10002' AND `course_id`= " .$this->course['id'] );
        $homework=$this->Study_HomeWork_Model->getALL("`course_id` = " .$course_id,"*","id desc",10,0);
        $work_id=implode(',', $works);
        foreach($homework as $key=>$val){
                 $type=$this->Study_HomeWork_Model->get_zuoye("`user_id` = ".$this->user['id']." AND `shijuan_id` =".$val['id']);
                 if($type){
                    $homework[$key]['hometype'] = "已提交";
                 }else{
                    $homework[$key]['hometype'] = "答题";
                 }
            }

        //构造返回数据
        $result=array(
            "course_notice"   => $course_notice,
            "course_info"     => $course_info,
            "organization"    => $organization,
            'course_cat'      => $course_cat,
            "count_mytest"    => $count_mytest,
            "count_teachinfo" => $count_teachinfo,
            "count_question"  => $count_question,
            "select_course"   => $select_course,
            "question"        => $question,
            "post"            => $post,
            "homework"        => $homework,
            "user_part"       => $part,
            "stu_count"       => $stu_count
        );
        $this->setComponent('index',$result);
        $this->showTemplate('study_index');
    }


}