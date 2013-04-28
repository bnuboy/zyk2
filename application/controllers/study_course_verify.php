<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达合创
 * 代码首次编写日期：2012-07-23
 */

include_once '_studyController.php';

class study_course_verify extends StudyController
{

    function __construct(){
        parent::__construct();
        $this->load->model("Study_Course_Model");
    }
    
    /*
     * 显示课程信息
     */

    function index(){
        //参数初始化
        $course_id=$this->course['id'];
        //构造数据
        $course=  $this->Study_Course_Model->getOne("`id` = ".$course_id,"course_verify,course_key");
        //构造返回数据
        $result= array(
            "course_id"=>$course_id,
            "course"   =>$course
        );
        $this->setComponent( 'course_verify',$result);
        $this->showTemplate( 'study_base' );
    }
    
    /*
     * 修改课程信息
     */
    function edit_verify($course_id){
        if($_POST['course_verify']!="5")$_POST['course_key']="";
        $this->Study_Course_Model->update($_POST,"`id` = ".$course_id);
        Util::redirect( '/study_course_verify', '设置成功!' );
    }

}
?>