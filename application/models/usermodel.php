<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class userModel extends CI_Model
{
    private $_table_name = 'gz_users';

    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 增加一条记录
     * @param array $data
     */
    function insert( $data )
    {
        $this->db->insert( $this->_table_name, $data );
        return $this->db->insert_id();
    }

    /*
     * 用户登录记录
     */

    function insert_login_log( $data )
    {
        $this->db->set( 'login_time', 'NOW()', false );
        $this->db->insert( "gz_user_login_log", $data );
        return $this->db->insert_id();
    }

    /*
     * 用户属性
     */

    function insertproperties( $data )
    {
        foreach ( $data as $value )
        {
            $this->db->insert( "gz_user_properties", $value );
        }
        return $this->db->insert_id();
    }

    /**
     * 获得一条数据
     * @param array $data
     */
    function getInfo( $data )
    {
        $row = $this->db->get_where( $this->_table_name, $data, 1, 0 )->row_object();
        return $row;
    }

    /*
     * 获取一条用户登录记录
     */

    function getLogInfo( $data )
    {
        $row = $this->db->get_where( "gz_user_login_log", $data, 1, 0 )->row_object();
        return $row;
    }

    function getLogList( $data = array(), $limit='10', $offset='0', $orderby="" )
    {
        if ( $orderby )
            $this->db->order_by( $orderby );
        $this->db->select( 'gz_user_login_log.*,gz_users.name ' );
        $this->db->join( 'gz_users', 'gz_users.id = gz_user_login_log.user_id' );
        $this->db->where_in( 'user_id', $data[ 'user' ] );
        if ( isset( $data[ 'time' ] ) )
        {
            $where = $data[ 'time' ];
        }
        else
        {
            $where = array();
        }
        return $this->db->get_where( "gz_user_login_log", $where, $limit, $offset )->result_object();
    }

    function getLogCount( $data = array() )
    {
        $this->db->select( 'gz_user_login_log.*,gz_users.name ' );
        $this->db->join( 'gz_users', 'gz_users.id = gz_user_login_log.user_id' );
        $this->db->where_in( 'user_id', $data[ 'user' ] );
        if ( isset( $data[ 'time' ] ) )
            $this->db->where( $data[ 'time' ] );
        $num = $this->db->count_all_results( "gz_user_login_log" );
        return $num;
    }

    function getTimeCount( $data = array() )
    {
        $this->db->select_sum( "gz_user_login_log.timer", "timecount" );
        $this->db->join( 'gz_users', 'gz_users.id = gz_user_login_log.user_id' );
        $this->db->where_in( 'user_id', $data[ 'user' ] );
        if ( isset( $data[ 'time' ] ) )
            $this->db->where( $data[ 'time' ] );
        $query = $this->db->get( 'gz_user_login_log' );
        $row = $query->result_array();
        if ( count( $row ) > 0 )
        {
            return $row[ 0 ];
        }
        else
        {
            return null;
        }
    }

    function getOffice( $data )
    {
        $row = $this->db->get_where( "gz_office", $data, 1, 0 )->row_object();
        return $row;
    }

    function getOfficeList( $data = array(), $limit='10', $offset='0', $orderby="" )
    {
        if ( $orderby )
            $this->db->order_by( $orderby );
        return $this->db->get_where( "gz_office", $data, $limit, $offset )->result_object();
    }

    /**
     *
     * 获取列表数据
     * @param arry $data
     * @param int $limit
     * @param int $offset
     * @param str $orderby
     */
    function getList( $data = array(), $limit='10', $offset='0', $orderby="" )
    {
        if ( $orderby )
            $this->db->order_by( $orderby );
        return $this->db->get_where( $this->_table_name, $data, $limit, $offset )->result_object();
    }

    function getAll()
    {
        return $this->getList( array(), 1000000 );
    }

    function getStudentList()
    {
        $list = $this->db->get_where( $this->_table_name, array('type' => 'student'), 100000 )->result_object();
        // echo $this->db->last_query();
        return $list;
    }

    /*
     * 数据总数
     * @param arry $data
     */

    function getCount( $data = array() )
    {
        $this->db->where( $data );
        $num = $this->db->count_all_results( $this->_table_name );
        return $num;
    }

    /**
     * 删除数据
     * @param array $data
     */
    function deletes( $data_arr )
    {
        $this->db->trans_start();
        foreach ( $data_arr as $data )
        {
            $this->db->delete( $this->_table_name, $data );
        }
        $this->db->trans_complete();
        if ( $this->db->trans_status() === FALSE )
        {
            throw Exception( "错误" );
        }
    }

    /**
     * 修改数据
     * @param array $data
     * @param array $where
     */
    function update( $data, $where )
    {
        $this->db->update( $this->_table_name, $data, $where );
    }

    /*
     * 插入用户退出时间
     */

    function update_user_log( $data, $where )
    {
        $this->db->update( "gz_user_login_log", $data, $where );
    }

    function updateproperties( $data, $where )
    {
        $this->db->update( "gz_user_properties", $data, $where );
    }

    function get_trainplan_user( $data )
    {
        $list = $this->db->get_where( 'gz_train_plan_join_user', $data )->result();
        return $list;
    }

    /**
     * 获取老师id
     * @param array $data
     * @param array $where
     */
    function getUserCat( $data )
    {
        $list = $this->db->get_where( 'gz_users', array('type' => $data) )->result();
        return $list;
    }

}