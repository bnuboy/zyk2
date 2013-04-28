<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达合创
 * 代码首次编写日期：2012-07-21
 */

class Study_Class_Doirss_Model extends DAO
{

    function __construct()
    {
        parent::initTable( 'gz_study_select_course', 'id' );
    }

    /*
     * 取得学生的学习记录
     */

    function getStudyLog( $where = '`id` > 0', $select = '*', $orderby = '`id` DESC', $limit = '', $offset = '' )
    {
        parent::initTable( 'gz_study_course_log', 'id' );
        return $this->getAll( $where, $select = '*', $orderby = '`id` DESC', $limit = '', $offset = '' );
    }

    /*
     * 取得学生的学习次数
     */

    function getStudyLogCount( $data )
    {
        parent::initTable( 'gz_study_course_log', 'id' );
        return $this->getCount( $data );
    }

    /*
     * 取得学生的学习时长
     */

    function getTime( $where )
    {
        $this->db->select_sum( "gz_study_course_log.study_time", "timecount" );
        $this->db->where( $where );
        $query = $this->db->get( 'gz_study_course_log' );
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

    /*
     * 班级  关联课程
     */

    function getClass( $where = '`id` > 0', $select = '*', $orderby = '`id` DESC', $limit = '', $offset = '' )
    {
        parent::initTable( 'gz_study_course_class', 'id' );
        return $this->getAll( $where, $select, $orderby, $limit, $offset );
    }

    function getOneClass( $where = '`id` > 0', $select = '*', $orderby = '`id` DESC', $limit = '', $offset = '' )
    {
        parent::initTable( 'gz_study_course_class', 'id' );
        return $this->getOne( $where, $select, $orderby );
    }

}
