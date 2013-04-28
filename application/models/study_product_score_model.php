<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达合创
 * 代码首次编写日期：2012-07-31
 */
class Study_Product_Score_Model extends DAO{
   	function __construct() {
      		parent::initTable('gz_study_product_score', 'id');
   	}

    /*
     * 获取学生互评   教师评分 总分
     */
    public function stuCommont($data){
       $stu_sum="SELECT sum( score ) as stu_sum FROM `gz_study_product_score` left join gz_study_class_join_user on
           `gz_study_product_score`.user_id=gz_study_class_join_user.user_id where 	gz_study_class_join_user.part_id='10002' and gz_study_product_score.product_id=".$data['product_id'];
       $row=$this->db->query($stu_sum)->result_array();
       return $row[0]['stu_sum'];
    }
    function teaCommont($data){
      $tea_sum="SELECT sum( score ) as tea_sum FROM `gz_study_product_score` left join gz_study_class_join_user on
           `gz_study_product_score`.user_id=gz_study_class_join_user.user_id where 	gz_study_class_join_user.part_id='10003' and gz_study_product_score.product_id=".$data['product_id'];
      $row=$this->db->query($tea_sum)->result_array();
      return $row[0]['tea_sum'];
    }

}
