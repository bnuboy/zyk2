<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Study_Teachinfo_Model extends DAO
{

    function __construct()
    {
        parent::initTable( 'gz_study_teachinfo', 'id' );
    }

    /*
     * 获取顶级分类
     */

    public function getParents( $id, $select = '*', & $parents = array() )
    {
        $ret = self::getOne( "`id` = '$id'", $select );
        if ( is_array( $ret ) )
        {
            $parents[ ] = $ret;
            self::getParents( $ret[ 'cid' ], $select, $parents );
        }
        return $parents;
    }

    /*
     * 下载记录
     */
    /*
     * 添加阅读记录
     */

    function update_down( $data, $where )
    {
        $this->db->set( 'down_num', 'down_num+1', false );
        self::update( $data, $where );
    }

}
?>