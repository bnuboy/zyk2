<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Study_Course_Join_Teacher_Model extends DAO
{

    function __construct()
    {
        parent::initTable( 'gz_study_course_join_teacher', 'id' );
    }
    /*
     * 获取所有的教师
     */
    public function getTeacher( $where = '`id` > 0', $limit='10', $offset='0', $orderby="" )
    {
        if ( $orderby )
            $this->db->order_by( $orderby );
        $this->db->select( 'gz_study_course_join_teacher.teacher_id,gz_users.name' );
        $this->db->join( 'gz_users', 'gz_users.id = gz_study_course_join_teacher.teacher_id' );
        $list = $this->db->get_where( 'gz_study_course_join_teacher', $where, $limit, $offset )->result_array();
        return $list;
    }

    /*
     * 更新课程和老师的关联
     */
    public function insertTeacher($data,$course_id){
            foreach($data as $value){
                self::insert(array("teacher_id"=>$value,"course_id"=>$course_id));
            }
    }
}
?>
