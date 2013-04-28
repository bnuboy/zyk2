<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达和创
 * 代码首次编写日期：2012-02-28
 */

class Study_Course_Groupmenu_Model extends DAO
{

    function __construct()
    {
        parent::initTable( 'gz_study_course_groupmenu', 'id' );
    }

    /*
     * 课程和菜单关联
     */
       public function getGroupMenuIds($courseId,$user_type){
        $rows = array();
        if(is_array($courseId)){
            $ids = implode(",", $courseId);
            $where = "`course_id` in (".$ids.") And user_type = ".$user_type;
        }else{
            $where = "`course_id` = '".$courseId."' And user_type = ".$user_type;
        }
        $this->db->where($where, NULL, FALSE);
        $query = $this->db->get('gz_study_course_groupmenu');
        foreach ($query->result_array() as $row) {
            $rows[] = $row['menu_id'];
        }
        return $rows;
    }
}

