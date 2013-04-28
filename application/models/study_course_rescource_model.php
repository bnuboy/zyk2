<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达和创
 * 代码首次编写日期：2012-02-28
 */

class Study_Course_Rescource_Model extends DAO
{

    function __construct()
    {
        parent::initTable( "gz_study_course_rescource", "id" );
    }
    /*
     * 添加下载
     */

    public function update_down( $data, $where )
    {
        $this->db->set( "down_num", "down_num+1", false );
        self::update( $data, $where );
    }
    //根据表名  获取所有数据
    public function getALLData($table,$key="id",$where="`id`>0",$limit="",$offset=""){
        $data=array();
        $rows = array();
        $data["title"]=$this->db->list_fields($table);

        $this->db->select( "*" );
        $this->db->where( $where, NULL, FALSE );
        if ( !empty( $limit ) )
        {
            $query = $this->db->get( $table, $limit, $offset );
        }
        else
        {
            $query = $this->db->get( $table );
        }
        foreach ( $query->result_array() as $row )
        {
            $rows[ ] = $row;
        }
        $data["param"]=$rows;
        return $data;
    }
    /*
     * 插入数据
     */
   public function insertALLData($sql){
        $data=explode(";", $sql);
        foreach($data as $key=>$val){
            if(!empty($val)) $query = $this->db->query($val);
          }
      }

}
