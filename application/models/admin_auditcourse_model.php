<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

   class Admin_AuditCourse_Model extends DAO
   {
       function __construct()
       {
           parent::__construct();
       }
       
       /*
        * 获取选课的列表
        */
       function getList($data,$limit=10,$offset=0,$orderby='')
       {
           $this->db->select('gz_study_course.*,gz_users.name as username,gz_study_select_course.user_id as uid');   
           $this->db->join('gz_users','gz_users.id = gz_study_select_course .user_id');
           $this->db->join('gz_study_course','gz_study_course.id = gz_study_select_course .course_id');
           $list = $this->db->get_where('gz_study_select_course ',$data,$limit,$offset)->result_array();
           return $list;
       }
       /**
        *
        * @param type $where
        * @return type 
        */
       function get_count($where)
       { 
           $this->db->join('gz_study_course','gz_study_course.id = gz_study_select_course .course_id');
           $this->db->where($where);
           $count = $this->db->count_all_results('gz_study_select_course');
           return $count;
       }
       /**
        * 审核选择的课程
        */
       function update_status($data)
       {
           $this->db->update('gz_study_select_course',array('status'=>'audit'),$data);
          
       }
       /**
        * 批量审核
        */
       
       function piliang($data)
       {
           $this->db->update('gz_study_select_course',array('status'=>'audit'),$data);
       }
   }
?>
