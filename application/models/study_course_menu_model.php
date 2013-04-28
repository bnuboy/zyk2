<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达和创
 * 代码首次编写日期：2012-02-28
 */

class Study_Course_Menu_Model extends DAO
{

    function __construct()
    {
        parent::initTable( 'gz_study_course_menu', 'id' );
    }

     /*
     * 返回顶级菜单
     * @param string $id
     * @return array
     */
     public function getTopMenu($id, $topMenu = null){ 
         $ret = self::getOne("`id` = '$id'"); 
         if($ret['f_id'] == 0){ 
             $topMenu = $ret; 
         }else{ 
             self::getTopMenu($ret['f_id'], & $topMenu); 
         } 
         return $topMenu; 
     } 
     
    /*
     * 获取树形菜单
     */

    public function toTree( $arr, $key_node_id, $key_parent_id = 'f_id', $key_childrens = 'childrens', & $refs = null )
    {
        $refs = array();
        foreach ( $arr as $offset => $row )
        {
            $arr[ $offset ][ $key_childrens ] = array();
            $refs[ $row[ $key_node_id ] ] = & $arr[ $offset ];
        }

        $tree = array();
        foreach ( $arr as $offset => $row )
        {
            $parent_id = $row[ $key_parent_id ];
            if ( $parent_id )
            {
                if ( !isset( $refs[ $parent_id ] ) )
                {
                    $tree[ ] = & $arr[ $offset ];
                    continue;
                }
                $parent = & $refs[ $parent_id ];
                $parent[ $key_childrens ][ ] = & $arr[ $offset ];
            }
            else
            {
                $tree[ ] = & $arr[ $offset ];
            }
        }

        return $tree;
    }


}
