<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Study_Class_Manage_Model extends DAO
{

    public function __construct()
    {
        parent::initTable( 'gz_study_course_class', 'id' );
    }

    /**
     * 获取班级列表
     * @param type $data
     * @param type $limit
     * @param type $offset
     * @param type $orderby
     * @return type 
     */
    public function getClassList( $data )
    {
        $this->db->where( $data );
        $list = $this->db->count_all_results( 'gz_study_class_join_user' );
        return $list;
    }

    /**
     * 获取班级列表
     */
    public function get_class_list( $data )
    {
        $list = $this->db->get_where( 'gz_study_course_class', $data )->result_array();
        return $list;
    }

    /**
     * 获取班级数量
     * @param type $data
     * @return type 
     */
    public function getClassCount( $data )
    {
        $this->db->where( $data );
        $count = $this->db->count_all_results( 'gz_study_course_class' );
        return $count;
    }

    /**
     * 获取班级内的助教
     */
    public function get_class_assistant( $data )
    {
        $this->db->select( 'gz_users.name' );
        $this->db->join( 'gz_users', 'gz_users.id = gz_study_class_join_user.user_id' );
        $this->db->join( 'gz_study_course_part', 'gz_study_course_part.id =gz_study_class_join_user.part_id ' );
        $list = $this->db->get_where( 'gz_study_class_join_user', $data, 3, 0 )->result_array();
        return $list;
    }

    /**
     * 获取班级的信息
     */
    public function getClassInfo( $data )
    {
        $info = $this->db->get_where( 'gz_study_course_class', $data )->result_array();
        return $info;
    }

    /**
     * 判断要添加的用户是否已经存在
     */
    public function get_userinfo( $data )
    {
        $this->db->join( 'gz_users', 'gz_users.id = gz_study_class_join_user.user_id' );
        $info = $this->db->get_where( 'gz_study_class_join_user', $data )->result_array();//echo $this->db->last_query();
        return $info;
    }

    /**
     * 获取用户的ID
     * @param type $data
     * @return type 
     */
    public function get_user( $data )
    {
        $this->db->select( 'id' );
        $info = $this->db->get_where( 'gz_users', $data )->row_array();
        return $info;
    }

    /**
     * 导入用户
     */
    function add_users( $data )
    {
        $this->db->set( 'created', 'NOW()', FALSE );
        $this->db->insert( 'gz_study_class_join_user', $data );
        return $this->db->insert_id();
    }

    /**
     * 获取用户列表
     */
    function get_user_list( $data, $limit=10, $offset=0 )
    {
        $this->db->select( 'gz_study_class_join_user.*,gz_users.name as username,gz_users.login_name as login_name,gz_study_course_part.name as part_name' );
        $this->db->join( 'gz_users', 'gz_users.id = gz_study_class_join_user.user_id' );
        $this->db->join( 'gz_study_course_part', 'gz_study_course_part.id = gz_study_class_join_user.part_id' );
        $list = $this->db->get_where( 'gz_study_class_join_user', $data, $limit, $offset )->result_array();
        // echo $this->db->last_query();
        return $list;
    }

    function delete_users( $data )
    {
        $this->db->trans_start();
        foreach ( $data as $val )
        {
            $this->db->delete( 'gz_study_class_join_user', array('id' => $val) );
        }
        $this->db->trans_complete();
        if ( $this->db->trans_status() == FALSE )
        {
            throw Exception( "错误" );
        }
    }

    function delete( $data )
    {
        $this->db->trans_start();
        foreach ( $data as $val )
        {
            $this->db->delete( 'gz_study_class_join_user', array('class_id' => $val) );
            $this->db->delete( 'gz_study_course_class', array('id' => $val) );
        }
        $this->db->trans_complete();
        if ( $this->db->trans_status() == FALSE )
        {
            throw Exception( "错误" );
        }
    }

}
?>
