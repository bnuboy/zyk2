<?php
/*
 * 代码编写者：康云超
 * 公司：奥孚创新
 * 代码首次编写日期：2012-02-13
 */

class Study_Coursecontent_Model extends DAO
{

    function __construct()
    {
        parent::initTable( 'gz_study_coursecontent', 'id' );
    }

    /*
     * 查询多个信息
     */

    public function getAllCoursecontents( $where = '`id` > 0', $select = '*', $orderby = '`id` DESC', $limit = '', $offset = '' )
    {
        $rows = array();
        $this->db->select( $select );
        $this->db->order_by( $orderby );
        $this->db->where( $where, NULL, FALSE );
        if ( !empty( $limit ) )
        {
            $query = $this->db->get( 'gz_study_coursecontent', $limit, $offset );
        }
        else
        {
            $query = $this->db->get( 'gz_study_coursecontent' );
        }
        foreach ( $query->result_array() as $row )
        {
            $rows[ ] = $row;
        }
        return $rows;
    }

    /*
     * 格式树形结构
     * @param string $cid
     * @param array $childs
     * @return array
     */

    public function getTreeCourses( $where = 'id > 0', $select = '*', $order = '`order` ASC', $cid = 0, $tags = "--", $level = 0, & $childs = array() )
    {
        if ( empty( $cid ) )
            $cid = 0;
        $ret = self::getAllCoursecontents( "`cid` = '$cid' AND " . $where . "", $select, $order );
        if ( is_array( $ret ) )
        {
            foreach ( $ret as $item )
            {//print_r($item);
                $str = '';
                for ( $i = 0; $i < $level; $i++ )
                {
                    $str .= $tags;
                }
                $keys = array_keys( $item );
                $item[ 'tag' ] = $str;
                $item[ 'level' ] = $level;
                $childs[ ] = $item;
                self::getTreeCourses( $where, $select, $order, $item[ 'id' ], $tags, $level + 1, $childs );
            }
        }
        return $childs;
    }

    /*
     * 返回分类下所有子分类ID
     * @param string $cid
     * @param array $childs
     * @return array
     */

    public function getChildIds( $id, $select = '*', & $childids = array() )
    {
        $ret = self::getAll( "`cid` = '$id'", $select );
        if ( is_array( $ret ) )
        {
            foreach ( $ret as $item )
            {
                $childids[ ] = $item[ 'id' ];
                self::getChildIds( $item[ 'id' ], $select, $childids );
            }
        }
        return $childids;
    }

    /*
     * 返回分类下所有子分类
     * @param string $cid
     * @param array $childs
     * @return array
     */

    public function getChilds( $cid = 0, $select = '*', & $childs = array() )
    {
        $ret = self::getAllCoursecontents( "`cid` = '$cid'", $select, "`id` ASC" );
        if ( is_array( $ret ) )
        {
            foreach ( $ret as $key => $item )
            {
                $childs[ ] = $item;
                self::getChilds( $item[ 'id' ], $select, $childs );
            }
        }
        return $childs;
    }

    /*
     * 返回顶级分类
     * @param string $id
     * @return array
     */

    public function getTopCourse( $id, $topClass = null )
    {
        $ret = self::getOneCoursecontent( "`id` = '$id'" );
        if ( $ret[ 'cid' ] == 0 )
        {
            $topClass = $ret;
        }
        else
        {
            self::getTopCourse( $ret[ 'cid' ], & $topClass );
        }
        return $topClass;
    }

    /*
     * 返回所有的顶级分类
     */

    function _current( $data, $parent_id, & $list )
    {
        foreach ( $data as $v )
        {
            if ( $v[ "id" ] == $parent_id )
            {
                $list[ ] = $v;
                $this->_current( $data, $v[ 'cid' ], $list );
            }
        }
    }

}
