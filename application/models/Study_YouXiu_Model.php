<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Study_YouXiu_Model extends DAO {

    function __construct() {
        parent::__construct();
        parent::initTable( 'gz_study_jiaojuan', 'id' );
    }
    /**
     *获取优秀列表
     * @param type $data
     * @return type 
     */
    function get_list($data,$select='*',$orderby='',$limit=10,$offset=0)
    {
        if($orderby)
            $this->db->order_by($orderby);
        $this->db->select('gz_study_shijuan.title,gz_study_jiaojuan.*,gz_study_shijuan.type_id');
        $this->db->join('gz_study_shijuan','gz_study_shijuan.id = gz_study_jiaojuan.shijuan_id');
        $list = $this->db->get_where('gz_study_jiaojuan',$data,$limit,$offset)->result_array();
        return $list;
    }
    /**
     *获取优秀作业条数
     * @param type $data
     * @return type 
     */
    function get_count($data)
    {
        $this->db->where($data);
        $this->db->join('gz_study_shijuan','gz_study_shijuan.id = gz_study_jiaojuan.shijuan_id');
        $count = $this->db->count_all_results('gz_study_jiaojuan');
        return $count;
    }
    /**
     * 获取试题的答案
     */
    function get_answer($data)
    {   
        //$this->db->select('*');
        $info = $this->db->get_where('gz_study_jiaojuan',$data)->row_array();
        return $info;
    }
}
?>
