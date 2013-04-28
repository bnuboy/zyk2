<?php
if ( !defined( 'BASEPATH' ) )
  exit( 'No direct script access allowed' );

class organizationModel extends CI_Model
{
  private $_table_name = 'gz_school_organization';

  /**
   * 构造函数
   */
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  /**
   * 增加一条记录
   * @param array $data
   */
  function insert( $data )
  {
    $this->db->insert( $this->_table_name, $data );
    return $this->db->insert_id();
  }

  /**
   * 获得一条数据
   * @param array $data
   */
  function getInfo( $data )
  {
    $row = $this->db->get_where( $this->_table_name, $data, 1, 0 )->row_object();
    return $row;
  }

  /**
   *
   * 获取列表数据
   * @param arry $data
   * @param int $limit
   * @param int $offset
   * @param str $orderby
   */
  function getList( $data = array(), $limit='10', $offset='0', $orderby="" )
  {
    if ( $orderby )
      $this->db->order_by( $orderby );
    return $this->db->get_where( $this->_table_name, $data, $limit, $offset )->result_object();
  }


  function getAll()
  {
    return $this->getList( array(), 1000000 );
  }

  function getOrderList( &$list )
  {
    $order_list = array();
    $this->_recursion_list( $list, $order_list );
    return $order_list;
  }

  function _recursion_list( &$list, &$order_list, $result_list = false, $parent_id = 0, $level = 0, $view_name = '' )
  {
    if ( !$result_list )
      $result_list = array();

    foreach ( $list as $item )
    {
      if ( $item->parent_id == $parent_id )
      {
        if ( !isset( $result_list[ $parent_id ] ) )
          $result_list[ $parent_id ] = array();
        $item->view_name = $view_name . $item->name;
        $result_list[ $parent_id ][ ] = $item;
        $order_list[ ] = $item;
        $this->_recursion_list( $list, $order_list, & $result_list, $item->id, $level + 1, $view_name . "&nbsp;|_&nbsp;" );
      }
    }
  }

  /*
   * 数据总数
   * @param arry $data
   */

  function getCount( $data = array() )
  {
    $this->db->where( $data );
    $num = $this->db->count_all_results( $this->_table_name );
    return $num;
  }

  /**
   * 删除数据
   * @param array $data
   */
  function deletes( $data_arr )
  {
    $this->db->trans_start();
    foreach ( $data_arr as $data )
    {
      //foreach($data as $key=>$val){
      //$this->db->delete('gz_resource_stores',array('organization_id'=>$val));
      //$this->db->delete('gz_users',array('organization_id'=>$val));
      // }
      $this->db->delete( $this->_table_name, $data );
    }
    $this->db->trans_complete();
    if ( $this->db->trans_status() === FALSE )
    {
      throw Exception( "错误" );
    }
  }

  /**
   * 修改数据
   * @param array $data
   * @param array $where
   */
  function update( $data, $where )
  {
    $this->db->update( $this->_table_name, $data, $where );
  }

}