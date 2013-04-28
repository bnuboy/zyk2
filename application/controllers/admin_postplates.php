<?php
include_once "_adminController.php";

class Admin_postPlates extends AdminController
{

  function __construct()
  {
    parent::__construct();
    $this->load->model( 'postplatemodel' );
  }

  /**
   * 默认方法
   * @param int $start 
   */
  function index( $start = 0 )
  {
    $this->load->library( 'adminpagination' );
    $limit = 10;
    $where = array();
    $get = $this->input->get();
    if ( $get[ 'name' ] )
      $where[ 'title LIKE' ] = '%' . $get[ 'name' ] . '%';
    if ( $get[ 'id' ] )
      $where[ 'id' ] = $get[ 'id' ];
    $data = $this->postplatemodel->getAll();
    $list = $this->postplatemodel->getList( $where, $limit, $start );
    $count = $this->postplatemodel->getCount( $where );

    $config[ 'base_url' ] = base_url() . 'admin_postplates/index';
    $config[ 'total_rows' ] = $count;
    $config[ 'per_page' ] = $limit;

    $this->adminpagination->initialize( $config );
    $pagination = $this->adminpagination->create_links();

    $this->setComponent( 'postplates', array('list' => $list, "pagination" => $pagination, 'count' => $count, 'data' => $data, 'get' => $get) );
    $this->showTemplate( 'admin_base' );
  }

  /**
   * 添加论坛板块
   */
  function add()
  {
    $this->setComponent( 'postplates_add' );
    $this->showTemplate( 'admin_base' );
  }

  /**
   * 保存添加的板块内容
   */
  function addUp()
  {
    $post = $this->input->post();
    $this->postplatemodel->insert( $post );
    $this->success();
  }

  /**
   * 修改一条记录
   * @param int $id 
   */
  function edit( $id )
  {
    $list = $this->postplatemodel->getInfo( array('id' => $id) );
    $this->setComponent( 'postplates_edit', array('list' => $list) );
    $this->showTemplate( 'admin_base' );
  }

  /**
   * 保存、更新修改的板块内容
   * @param int $id 
   */
  function editUp( $id )
  {
    $post = $this->input->post();
    foreach ( $_FILES as $file_key => $file_item )
    {
      if ( $file_item[ 'error' ] == 0 )
      {
        $dir = '/upload/postplates/' . date( 'Y' ) . '/' . date( 'md' ) . '/';
        $path = $_SERVER[ 'DOCUMENT_ROOT' ] . $dir;
        @mkdir( $path, 0777, true );
        $newfilename = time() . rand( 0, 10000 );
        $config[ 'upload_path' ] = $path;
        $config[ 'allowed_types' ] = 'gif|jpg|png';
        $config[ 'max_size' ] = '10000000';
        $config[ 'overwrite' ] = true;
        $config[ 'file_name' ] = $newfilename . '.' . pathinfo( $file_item[ 'name' ], PATHINFO_EXTENSION );
        $this->load->library( 'upload', $config );
        $this->upload->initialize( $config );
        if ( !$this->upload->do_upload( $file_key ) )
        {
          echo $this->upload->display_errors();
        }
        else
        {
          $imgurl = $dir . $config[ 'file_name' ];
          $post[ $file_key ] = $imgurl;
        }
      }
    }
    $this->postplatemodel->update( $post, array('id' => $id) );
    $this->success();
  }

  /**
   * 删除一条数据
   * @param int $id 
   */
  function delete( $id )
  {
    $this->postplatemodel->deletes( array(array('id' => $id)) );
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
      $this->postplatemodel->deletes( $delete_data );
      $this->AJAXSuccess( '' );
    }
    catch ( Exception $ex )
    {
      $this->AJAXFail( '' );
    }
  }

  function enable( $id )
  {
    try
    {
      $this->postplatemodel->update( array("enabled" => $this->input->post( 'enabled' )), "id = " . $id );
      $this->AJAXSuccess( '' );
    }
    catch ( Exception $ex )
    {
      $this->AJAXFail( $ex );
    }
  }

}
?>
