<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达和创
 * 代码首次编写日期：2012-02-28
 */

class Study_Course_Part_Model extends DAO{

    function __construct()
    {
        parent::initTable( 'gz_study_course_part', 'id' );
    }
}

