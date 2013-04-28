<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Study_Teach_Manage_Model extends DAO
{
    public $tablename='gz_study_select_course';
    public $key='id';
    public function __construct()
    {
        parent::initTable('gz_study_note_cat', 'id');
    }

    public function get_select_course( $data ,$limit=10,$offset=0,$orderby='')
    {
        $this->db->select('gz_study_select_course.*,gz_study_course_part.name as part_name,gz_users.name as username');
        $this->db->join('gz_users','gz_users.id = gz_study_select_course.user_id');
        $this->db->join('gz_study_course_part','gz_study_course_part.id = gz_study_select_course.course_part_id');
        $list = $this->db->get_where('gz_study_select_course',$data,$limit,$offset)->result_array();
        return $list;
    }
    
    public function get_select_count($data)
    {
         $this->db->join('gz_users','gz_users.id = gz_study_select_course.user_id');
        $this->db->join('gz_study_course_part','gz_study_course_part.id = gz_study_select_course.course_id');
        $count = $this->db->count_all_results('gz_study_select_course',$data);
        return $count;
    }

     /**
      * 审核
      */
  function audit( $data )
  {   
         $this->db->update( 'gz_study_select_course', array('status'=>'audit'), array('id'=>$data) );
  }
  
  /*
   * 删除方法
   */
  
  public function delete_course($data)
  {
      $this->db->trans_start();
      foreach ($data as $val){
      $this->db->delete($this->tablename,array('id'=>$val));
      }
      $this->db->trans_complete();
      if($this->db->trans_status() == FALSE)
      {
          throw Exception( "错误" );
      }
  }
  
  /**
   * 获取用户角色
   */
  public function get_part()
  {
      $list = $this->db->get('gz_study_course_part')->result_array();
      return $list;
  }
  
  /**
   * 判断要添加的用户是否已经存在
   */
  
  public function get_userinfo($data)
  {
      $this->db->join('gz_users','gz_users.id = gz_study_select_course.user_id');
      $info = $this->db->get_where('gz_study_select_course',$data)->result_array();
      return $info;
  }
  
  public function get_user($data)
  {
      $this->db->select('id');
     $info = $this->db->get_where('gz_users',$data)->row_array();  
     return $info;
  }

  /**
   * 导入用户
   */
  
  function add_users($data)
  {
      $this->db->set('created','NOW()',FALSE);
      $this->db->insert('gz_study_select_course',$data);
      return $this->db->insert_id();
  }
}
?>
