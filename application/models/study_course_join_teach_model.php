<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达合创
 * 代码首次编写日期：2012-07-21
 */

class Study_Course_Join_Teacher_Model extends DAO
{

    function __construct()
    {
        parent::initTable( 'gz_study_course_join_teacher', 'id' );
    }

}
