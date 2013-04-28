<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达合创
 * 代码首次编写日期：2012-07-23
 */

include_once '_studyController.php';

class study_course extends StudyController
{

    function __construct(){
        parent::__construct();
        $this->load->model( "Study_Course_Model" );
        $this->load->model("Study_Course_Join_Teacher_Model");
        $this->load->model( "User_Model" );
        $this->load->library( 'adminpagination' );
    }

    /*
     * 显示课程信息
     */

    function index( $offset=0 ){
        //参数初始化
        $this->load->model("School_Organization_Model");
        $this->load->model("Study_Course_Cat_Model");
        $this->load->model("Resource_Library_Model");
        $course_id=  $this->course['id'];
        //构造数据
        $course_info   = $this->Study_Course_Model->getOne('`id` = '.$course_id);
        $teachers  = $this->Study_Course_Model->getTeachers($course_id);
        $organizations = $this->School_Organization_Model->getAll("`f_id` = 0");
        $course_cats   = $this->Study_Course_Cat_Model->getAll("`id` > 0");
        $libs          = $this->Resource_Library_Model->getAll("`id` > 0");
        //构造返回数据
        $result=array(
            "course_info"    => $course_info,
            "teachers"       => $teachers,
            "organizations"  => $organizations,
            "course_cats"    => $course_cats,
            "libs"           => $libs
        );
        $this->setComponent( 'course_info', $result);
        $this->showTemplate( 'study_base' );
    }

    /*
     *获取所有的教师
     */
    function get_teacher( $offset=0 ){
        $limit = 10;
        //构造数据
        $list = $this->User_Model->getAll("gz_users.type = 'teacher'","id,name,mobile" );
        $count = $this->User_Model->getCount("gz_users.type = 'teacher'");
        //构造返回数据
        $result=array(
            'list' => $list,
            'count'=>$count
            );
        $this->setComponent( 'teacher_list', $result );
        $this->showTemplate( 'base' );
  }

  /*
   * 修改课程信息
   * @param $course_id 课程id
   */
  function edit($course_id){
      if($_POST){
           if(!empty($_POST['teacher_ids'])){
                $this->Study_Course_Join_Teacher_Model->delete("`course_id` = '".$course_id."'");
                foreach(explode(',', $_POST['teacher_ids']) as $k => $v){
                    $this->Study_Course_Join_Teacher_Model->insert(array('course_id' => $course_id, 'teacher_id' => $v));
                }
            }
            $data = $_POST['data'];
            $this->Study_Course_Model->update($data,"`id` =" . $course_id);
            Util::redirect('/study_course/index',"修改成功");
      }
  }

  
}
?>