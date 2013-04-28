<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Study_Course_Model extends DAO
{

    function __construct() {
        parent::initTable( 'gz_study_course', 'id' );
    }
    
    function getTeachers($course_id){
        $rows = array();
        $this->db->select("user.id,user.name");
        $this->db->from('gz_study_course as course');
        $this->db->join('gz_study_course_join_teacher as teacher', 'teacher.course_id = course.id', 'left');
        $this->db->join('gz_users as user', 'user.id = teacher.teacher_id', 'left');
        $this->db->where("course.`id` = '".$course_id."' AND user.id <> ''", NULL, FALSE);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $rows[] = $row;
        }
        return $rows;
    }


}
