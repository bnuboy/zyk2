<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达合创
 * 代码首次编写日期：2012-07-21
 */

class Study_Select_Course_Model extends DAO
{

    function __construct()
    {
        parent::initTable( 'gz_study_select_course', 'id' );
    }

    /**
     * 查询教师选的课程
     */
    function teacher_select($data)
    {       
        $this->db->select('gz_study_select_course.*,gz_study_course_part.name as part_name,gz_study_course.name');
        $this->db->join('gz_study_course','gz_study_course.id = gz_study_select_course.course_id');
        $this->db->join('gz_study_course_part','gz_study_course_part.id = gz_study_select_course.course_part_id');
        $list = $this->db->get_where('gz_study_select_course',$data)->result_array();
        return $list;
    }
    /**
     * 查询老师选课的班级
     */
    
    function get_class($data)
    {
        $this->db->select('name');
        $info = $this->db->get_where('gz_study_course_class',$data)->row_array(); 
        return $info;
    }
    
    /**
     * 退课
     * 
     */
    function tuike($course_id,$user_id)
    {
        $this->db->trans_start();
        
          $this->db->delete( 'gz_study_select_course', array('user_id' => $user_id,'course_id'=>$course_id) );
          $this->db->delete( 'gz_study_course_join_teacher',array('teacher_id' => $user_id,'course_id'=>$course_id));
     
        $this->db->trans_complete();
        if ( $this->db->trans_status() === FALSE )
        {
          throw Exception( "错误" );
        }
    }
    
    /**
     * 获取教师自己添加的课程
     */
    
    function get_teacher_course($data,$order_by)
    {
        if($order_by)
            $this->db->order_by($order_by);
        $this->db->select('gz_study_course.name,gz_study_course.created,gz_study_course.status,gz_study_course.description,
            gz_study_course_join_teacher.course_id,gz_study_course_join_teacher.teacher_id as user_id');
        $this->db->join('gz_study_course','gz_study_course.id = gz_study_course_join_teacher.course_id');
        $list = $this->db->get_where('gz_study_course_join_teacher',$data)->result_array();
        return $list;
    }
    /**
     * 获取学生的选课列表
     */
    function get_student_select($data,$limit=10,$offset=0,$orderby='')
    {
        $this->db->select('gz_study_select_course.*,gz_study_course_part.name as part_name,gz_study_course.name');
        $this->db->join('gz_study_course','gz_study_course.id = gz_study_select_course.course_id');
        $this->db->join('gz_study_course_part','gz_study_course_part.id = gz_study_select_course.course_part_id');
        $list = $this->db->get_where('gz_study_select_course',$data,$limit,$offset)->result_array();
        return $list;
    }
    
    /**
     * 数量
     */
    function get_student_count($data)
    {
      
        $this->db->join('gz_study_course','gz_study_course.id = gz_study_select_course.course_id');
        $this->db->join('gz_study_course_part','gz_study_course_part.id = gz_study_select_course.course_part_id');
        $this->db->where($data);
        $sum = $this->db->count_all_results('gz_study_select_course');
        return $sum;
    }
}
