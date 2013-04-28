<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Study_MyTest_Model extends DAO
{

    public function __construct()
    {
        parent::initTable( 'gz_study_mytest', 'id' );
    }

    /**
     * 获取试题
     */
    function get_shiti( $param, $data, $data2, $data3 )
    {
        if ( $data3 )
            $this->db->order_by( $data3 );
        if ( $data2 )
            $this->db->limit( $data2 );
        //$this->db->select('gz_study_pattern.name as tixing_name,gz_study_shiti_'.$param.'.*');
        // $this->db->join('gz_study_pattern','gz_study_pattern.id = gz_study_shiti_'.$param.'.tixing_id');
        $list = $this->db->get_where( 'gz_study_shiti_' . $param, $data )->result_array();
        return $list;
    }

    /**
     * 获取题型
     */
    function get_tixing( $data )
    {
        $this->db->select( 'name' );
        $info = $this->db->get_where( 'gz_study_pattern', $data )->row_array();
        return $info;
    }
    
    /**
     * 核对答案
     */
    function check_answer($data,$param)
    {
        $this->db->select('gz_study_shiti_'.$param.'.daan');
        $list = $this->db->get_where('gz_study_shiti_'.$param,$data)->row_array();
        return $list;
    }
    
    /**
     * 保存测试
     */
    
    function add_daan($data)
    {
        $this->db->set('created','NOW()',false);
        $this->db->insert('gz_study_zice_result',$data);  
    }
    
    /**
     * 自测统计
     */
    
    function get_tongji($data,$limit=10,$offset=0)
    {
        $this->db->select('count(gz_study_zice_result.user_id) as zice_count,gz_users.name as username,
            gz_users.login_name ,gz_study_course_class.name as class_name,gz_study_zice_result.*,max(gz_study_zice_result.created) as riqi ');
        $this->db->join('gz_study_class_join_user','gz_study_class_join_user.user_id = gz_users.id','left');
        $this->db->join('gz_study_zice_result','gz_study_zice_result.user_id = gz_users.id','left');
        $this->db->join('gz_study_course_class','gz_study_course_class.id = gz_study_class_join_user.class_id','right');
        $this->db->group_by('gz_study_zice_result.user_id');       
        $list = $this->db->get_where('gz_users',$data,$limit,$offset)->result_array();
       //echo $this->db->last_query();
        return $list;
    }
    
    function get_tongji_count($where)
    {
        $this->db->select('count(DISTINCT gz_study_zice_result.user_id) as num');
        $this->db->join('gz_study_class_join_user','gz_study_class_join_user.user_id = gz_users.id','left');
        $this->db->join('gz_study_zice_result','gz_study_zice_result.user_id = gz_users.id','left');       
        $this->db->where($where);
        $list = $this->db->get('gz_users')->row();
       // echo $this->db->last_query();
        return $list->num;
    }
    /*
     * 统计用户自测的次数
     */
    function CountTest($where){
        if(!empty($where)) $this->db->where( $where, NULL, FALSE );
        $query = $this->db->get( "gz_study_zice_result" );
        $count = $query->num_rows();
        return $count;
    }
}
?>
