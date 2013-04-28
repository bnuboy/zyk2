<?php
if ( !defined( 'BASEPATH' ) )
  exit( 'No direct script access allowed' );

class Study_Pattern_Model extends DAO
{

    function __construct()
    {
        parent::__construct();
        parent::initTable( 'gz_study_pattern', 'id' );
    }

    function get_pattern_type()
    {
        $list = $this->db->get('gz_study_patterntype')->result_array();
        return $list;
    }
    
    /**
     * 获取列表信息
     * 
     */
    
    function get_list($data,$limit=10,$offset=0,$orderby='')
    {
        $this->db->select('gz_study_pattern.*,gz_study_patterntype.name as pattern_type');
        $this->db->join('gz_study_patterntype','gz_study_patterntype.id = gz_study_pattern.patternType_id ');
        $list = $this->db->get_where('gz_study_pattern',$data,$limit,$offset)->result_array();
        //echo $this->db->last_query();
        return $list;
    }
    
    function get_count($data)
    {      
        $this->db->select('gz_study_pattern.*,gz_study_patterntype.name as pattern_type');
        $this->db->join('gz_study_patterntype','gz_study_patterntype.id = gz_study_pattern.patternType_id ');
        $this->db->where($data);       
        $count = $this->db->count_all_results('gz_study_pattern');
        return $count;
    }


    /**
     * 获取试题的数量
     */
    function get_shiti_count($data,$param)
    {
        $this->db->where($data);
        $count = $this->db->count_all_results('gz_study_shiti_'.$param);
        return $count;
    }
}
