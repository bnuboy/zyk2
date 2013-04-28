<?php
include '_adminController.php';

class Admin_posts extends AdminController
{

  function __construct()
  {
    parent::__construct();
    $this->load->model( 'postmodel' );
    $this->load->helper( 'date' );
  }

  /**
   * 默认方法
   * @param int $start 
   */
  function index( $start =0 )
  {
    $this->load->library( 'adminpagination' );
    $this->load->model( 'postplatemodel' );

    $get = $this->input->get();
    $limit = 10;
    $where = array();
    if ( $get[ 'status' ] )
      $where[ 'status LIKE' ] = '%' . $get[ 'status' ] . '%';

    $where[ 'parent_id' ] = 0;
    $list = $this->postmodel->getList( $where, $limit, $start );
    $count = $this->postmodel->getCount( $where );
    $config[ 'total_rows' ] = $count;
    $config[ 'per_page' ] = $limit;
    $config[ 'base_url' ] = base_url() . 'admin_posts/index';
    $this->adminpagination->initialize( $config );
    $pagination = $this->adminpagination->create_links();
    $this->setComponent( 'posts', array('list' => $list, 'count' => $count, 'pagination' => $pagination, 'get' => $get) );
    $this->showTemplate( 'admin_base' );
  }

  /**
   * 增加帖子
   */
  function add()
  {
    $this->load->model( 'postplatemodel' );
    $data = $this->postplatemodel->getAll();
    $this->setComponent( 'posts_add', array('data' => $data) );
    $this->showTemplate( 'admin_base' );
  }

  /**
   * 保存添加帖子
   */
  function addUp()
  {
    $post = $this->input->post();
    $this->postmodel->insert( $post );
    $this->success();
  }

  /**
   * 修改一条帖子
   * @param int $id 
   */
  function edit( $id )
  {
    $data = $this->postmodel->getInfo( array('id' => $id) );
    $this->setComponent( 'posts_edit', array('data' => $data) );
    $this->showTemplate( 'admin_base' );
  }

  /**
   * 保存、更新修改的内容
   * @param int $id 
   */
  function editUp( $id )
  {
    $post = $this->input->post();
    if ( $post[ 'top' ] == 0 )
    {
      $post[ 'top' ] = 0;
    }
    else
    {
      $post[ 'top' ] = now();
    }
    $this->postmodel->update( $post, array('id' => $id) );
    $this->success();
  }

  /**
   * 删除一条数据
   * @param int $id 
   */
  function delete( $id )
  {
    $this->postmodel->deletes( array(array('id' => $id)) );
    $this->success();
  }

  /**
   * 删除多条数据
   */
  function deletes()
  {
    try
    {
      $deletes = $this->input->post( 'item_id' );
      $delete_data = array();
      foreach ( $deletes as $delete_id )
      {
        $delete_data[ ] = array('id' => $delete_id);
      }
      $this->postmodel->deletes( $delete_data );
      $this->AJAXSuccess( '' );
    }
    catch ( Exception $ex )
    {
      $this->AJAXFail( '' );
    }
  }

  /**
   * 更新帖子状态
   * @param int $id 
   */
  function enable( $id )
  {

    try
    {
      $this->postmodel->update( array("top" => $this->input->post( 'top' ) == '0' ? '0' : now()), "id = " . $id );
      $this->AJAXSuccess( '' );
    }
    catch ( Exception $ex )
    {
      $this->AJAXFail( $ex );
    }
  }

}
?>
