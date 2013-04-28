<?php

class MY_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

}
/*
 * 代码编写者：康云超
 * 公司：奥孚创新
 * 代码首次编写日期：2012-06-28
 */

class DAO extends MY_Model
{
    protected $table_name;
    protected $primary_key;

    /*
     * 初始化
     */

    function initTable( $table_name, $primary_key )
    {
        $this->table_name = $table_name;
        $this->primary_key = $primary_key;
    }

    /*
     * 查询单个信息
     */

    public function getOne( $where, $select = '*', $orderby = '`id` DESC' )
    {
        $row = array();
        $this->db->select( $select );
        $this->db->order_by( $orderby );
        $this->db->where( $where, NULL, FALSE );
        $query = $this->db->get( $this->table_name );
        $row = $query->result_array();
        if ( count( $row ) > 0 )
        {
            return $row[ 0 ];
        }
        else
        {
            return null;
        }
    }

    /*
     * 查询多个信息
     */

    public function getAll( $where = '`id` > 0', $select = '*', $orderby = '`id` DESC', $limit = '', $offset = '' )
    {
        $rows = array();
        $this->db->select( $select );
        $this->db->order_by( $orderby );
        $this->db->where( $where, NULL, FALSE );
        if ( !empty( $limit ) )
        {
            $query = $this->db->get( $this->table_name, $limit, $offset );
        }
        else
        {
            $query = $this->db->get( $this->table_name );
        }
        foreach ( $query->result_array() as $row )
        {
            $rows[ ] = $row;
        }
        return $rows;
    }

    /*
    * 添加信息
    */
    public function insert($data){
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;

    }
    
    /*
     * 插入多条信息
     */
     public function insertArray($data){
        $this->db->insert_batch($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    /*
     * 修改信息
     */

    public function update( $data, $where )
    {
        $this->db->update( $this->table_name, $data, $where );
    }

    /*
     * 查询数量
     */

    public function getCount( $where = '' )
    {
        if(!empty($where)) $this->db->where( $where, NULL, FALSE );
        $query = $this->db->get( $this->table_name );
        $count = $query->num_rows();
        return $count;
    }

    /*
     * 删除信息
     */

    public function delete( $where )
    {
        $this->db->where( $where, NULL, FALSE );
        $this->db->delete( $this->table_name );
    }

}
