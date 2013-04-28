<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class User_Model extends DAO {

    function __construct() {
        parent::__construct();
        parent::initTable( 'gz_users', 'id' );
    }
    
    public function myCourseInfo($where = '', $select = '*', $orderby = 'user.id DESC', $limit = '', $offset = ''){
        $rows = array();
        $this->db->select($select, FALSE);
        $this->db->order_by($orderby);
        $this->db->where($where, NULL, FALSE);
        $this->db->from('gz_users as user');
        $this->db->join('gz_study_select_course as select_course', 'user.id = select_course.user_id', 'left');
        $this->db->join('gz_study_patterntype as study_patterntype', 'study_patterntype.id = select_course.course_part_id', 'left');
        $this->db->join('gz_study_course as course', 'course.id = select_course.course_id', 'left');
        $this->db->join('gz_study_class_join_user as class_user', 'class_user.user_id = user.id', 'left');
        $this->db->join('gz_study_course_class as class', 'class.id = class_user.class_id', 'left');
        if(!empty($limit)){
            $query = $this->db->get('', $limit, $offset);
        }else{
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $row) {
            $rows[] = $row;
        }
        return $rows;
    }    
    
    
    
    
}
