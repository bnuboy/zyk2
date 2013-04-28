<?php
if ( !defined( 'BASEPATH' ) )
  exit( 'No direct script access allowed' );

class postModel extends CI_Model {
  private $_table_name = 'gz_posts';

  /**
   * 构造函数
   */
  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  /**
   * 增加一条记录
   * @param array $data
   */
  function insert( $data ) {
    $this->db->set( 'uuid', 'UUID()', false );
    $this->db->set( 'created', 'NOW()', false );
    $this->db->insert( $this->_table_name, $data );
    $post_id=$this->db->insert_id();
    $this->update_post_plates($post_id,$data);
  }
  function update_post_plates($post_id,$data) {
    if($data['parent_id']==0) {
      $this->db->set('subject_count','subject_count+1',false);
      $this->db->set('post_id',$post_id,'false');
    }
    $this->db->set('post_count','post_count+1',false);
    $this->db->update( "gz_post_plates", array(),array("id"=>$data['plate_id']));
    return $post_id;
  }

  /**
   * 获得一条数据
   * @param array $data
   */
  function getInfo( $data ) {
    $row = $this->db->get_where( $this->_table_name, $data, 1, 0 )->row_object();
    //$str = $this->db->last_query();echo $str;
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
  function getList( $data = array(), $limit='10', $offset='0', $orderby="" ) {
    if ( $orderby )
      $this->db->order_by( $orderby );
    return $this->db->get_where( $this->_table_name, $data, $limit, $offset )->result_object();
  }

  function getAll() {
    return $this->getList( array(), 1000000 );
  }

  /*
   * 数据总数
   * @param arry $data
  */

  function getCount( $data = array() ) {
    $this->db->where( $data );
    $num = $this->db->count_all_results( $this->_table_name );
    return $num;
  }

  /**
   * 删除数据
   * @param array $data
   */
  function deletes( $data_arr ) {
    $this->db->trans_start();

    foreach ( $data_arr as $data ) {
      $this->db->delete( $this->_table_name, array('parent_id' => $data['id']) );
      $this->db->delete( $this->_table_name, $data );
    }
    $this->db->trans_complete();
    if ( $this->db->trans_status() === FALSE ) {
      throw Exception( "错误" );
    }
  }

  /**
   * 修改数据
   * @param array $data
   * @param array $where
   */
  function update( $data, $where ) {
    $this->db->update( $this->_table_name, $data, $where );
  }

}