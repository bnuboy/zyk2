<?php
/*
 * 代码编写者：康云超
 * 公司：奥孚创新
 * 代码首次编写日期：2012-02-28
 */
class Study_Plan_Model extends DAO{
   	function __construct() {
      		parent::initTable('gz_study_plan', 'id');;
   	}

   public function getParents($id, $select = '*', & $parents = array() ){
        $ret = self::getOne("`id` = '$id'", $select);
        if(is_array($ret)){
            $parents[] = $ret;
            self::getParents($ret['cid'], $select, $parents);
        }
        return $parents;
    }

}
