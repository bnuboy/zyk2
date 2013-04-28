<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达合创
 * 代码首次编写日期：2012-07-21
 */

class Study_Course_Log_Model extends DAO
{

    function __construct()
    {
        parent::initTable( 'gz_study_course_log', 'id' );
    }

    /*
     * 取得学生的学习时长
     */

    function getTime( $where )
    {
        $this->db->select_sum( "study_time", "timecount" );
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
     * 添加阅读记录
     */

    function update_read( $data, $where )
    {
        parent::initTable( 'gz_study_course_log', 'id' );
        $this->db->set( 'read_num', 'read_num+1', false );
        $this->update( $data, $where );
    }

    /*
     * 修改阅读时间
     */

    function update_timer( $data, $where )
    {
        parent::initTable( 'gz_study_course_log', 'id' );
        $this->db->set( 'study_time', 'study_time+1', false );
        $this->update( $data, $where );
    }

}
