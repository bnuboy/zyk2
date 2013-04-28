<?php
include_once "_forumController.php";

class forum extends ForumController
{

  function __construct()
  {
    parent::__construct();
    $this->load->library( 'Form_validation' );

    $this->load->helper( 'url' );
    $this->load->helper( 'form' );
    $this->load->model( "postplatemodel" );
    $this->load->model( "postmodel" );
    $this->load->model( 'User_Model');
  }

  /*
   * 论坛首页
   * @param array $list 论坛板块
   * @param array $new_post  最后发表的帖子信息
   */

  function index( $start = 0 )
  {
    $this->load->helpers( 'myfunctions_helper' );

    $limit = 10;
    $where = array();
    $list = $this->postplatemodel->getList( $where, '10000', '0', "order_no asc" );

    //最新主题，今日发帖数
    $subject_count = $this->postmodel->getCount( array("parent_id" => 0) );
    $posts_count = $this->postmodel->getCount();
    $today_count = $this->postmodel->getCount( array("created like" => date( "Y-m-d" ) . "%", "parent_id" => 0) );
    //用户
    $this->load->model( "usermodel" );
    $user_count = $this->usermodel->getCount();

    //最后发表
    foreach ( $list as $posts )
    {
      $new_post = $this->postmodel->getInfo( array('id' => $posts->post_id) );

      //compareTime ：帖子发表的时间距和今天的 时间差
      if ( !empty( $new_post->title ) && !empty( $new_post->created ) )
      {
        $posts->cmptime = compareTime( $new_post->created );
        $posts->new_post = $new_post->title;
        $posts->new_post_id = $new_post->id;
      }
      else
      {
        $posts->cmptime = "";
        $posts->new_post = "";
        $posts->new_post_id = "";
      }
    }
    $this->setComponent( 'plate', array('list' => $list, 'subject_count' => $subject_count, "user_count" => $user_count,
        'posts_count' => $posts_count, "today_count" => $today_count) );
    $this->showTemplate( 'forum_base' );
  }

  //主题列表页
  function postlist( $id, $start = 0 )
  {
    $this->load->library( 'frontpagination' );
    $this->load->helpers( 'myfunctions_helper' );
    $get = $this->input->get();
    $limit = 10;
    $where = array('status' => "normal", 'plate_id' => $id, 'parent_id' => '0');
    $list = $this->postmodel->getList( $where, $limit, $start, "top DESC,created DESC" );
    $count = $this->postmodel->getCount( $where );

    $count_info = $this->postplatemodel->getInfo( array('id' => $id) );
    $today_count = $this->postmodel->getCount( array("created like" => date( "Y-m-d" ) . "%", "parent_id" => 0, 'plate_id' => $id) );
    //$total_user 用户
    $total_user = $this->User_Model->getCount('`id` > 0');

    $config[ 'base_url' ] = base_url() . 'forum/postlist/' . $id;
    $config[ 'total_rows' ] = $count;
    $config[ 'per_page' ] = $limit;

    $this->frontpagination->initialize( $config );
    $pagination = $this->frontpagination->create_links( 4 );

    //查询最后回复的用户信息 和时间
    $this->load->model( "usermodel" );
    foreach ( $list as $key => $item )
    {
      $list[ $key ]->user = $this->usermodel->getInfo( array('id' => $item->user_id) );
      $list[ $key ]->last_reply_user = $this->usermodel->getInfo( array('id' => $item->last_reply) );
      $s = $item->last_reply_time;
      if ( $item->last_reply_time != "0000-00-00 00:00:00" )
      {
        $list[ $key ]->cptime = compareTime( $item->last_reply_time );
      }
      else
      {
        $list[ $key ]->cptime = "";
      }
    }

    $this->setComponent( 'post_list', array('list' => $list, 'plate_id' => $id,
        "pagination" => $pagination, 'count' => $count, 'count_info' => $count_info, "today_count" => $today_count,'total_user'=>$total_user
            ) );
    $this->showTemplate( 'forum_base' );
  }

  /*
   * 添加主题
   * @param int $plate_id 板块id
   */
  function add( $plate_id )
  {
    $plate_info = $this->postplatemodel->getInfo( array("id" => $plate_id) );
    $this->setComponent( 'post_add', array('plate_info' => $plate_info) );
    $this->showTemplate( 'forum_base' );
  }

  function addup( $plate_id )
  {
    $data = $this->input->post();
    if ( empty( $data[ 'title' ] ) || empty( $data[ 'content' ] ) )
    {
      Util::jumpback( "不能发表空白的主题" );
    }
    $data[ 'user_id' ] = $this->user['id'];
    $data[ 'plate_id' ] = $plate_id;
    $data[ 'parent_id' ] = "0";
    //最新主题的id
    $this->postmodel->insert( $data );
    Util::redirect( '/forum/postlist/' . $plate_id );
  }

  /*
   * 帖子详细页面
   * @param int $id 帖子的id
   */
  function view( $id, $start = 0 )
  {
    $this->load->library( "frontpagination" );

    $data = $this->postmodel->getInfo( array("id" => $id) );

    $this->load->model( "usermodel" );
    $data->user = $this->usermodel->getInfo( array('id' => $data->user_id) );
    //楼主的发帖数
    $data->user->posts_count = $this->postmodel->getCount( array('user_id' => $data->user_id, 'parent_id' => 0, "status" => "normal") );
    //查看次数
    $this->postmodel->db->set( 'view', 'view+1', false );
    $this->postmodel->update( array(), array('id' => $id) );

    $plate_info = $this->postplatemodel->getInfo( array('id' => $data->plate_id) );
    $limit = 10;
    //回复信息
    //if( $start == 0 ){
    //$limit--;
    //}

    $repeat_info = $this->postmodel->getList( array("parent_id" => $data->id), $limit, $start, "created ASC" );
    $count = $this->postmodel->getCount( array("parent_id" => $data->id) );
    //分页
    $config[ 'base_url' ] = base_url() . 'forum/view/' . $id;
    $config[ 'total_rows' ] = $count;
    $config[ 'per_page' ] = $limit;

    $this->frontpagination->initialize( $config );
    $pagination = $this->frontpagination->create_links( 4 );

    //回复信息的用户信息
    foreach ( $repeat_info as $info )
    {
      $info->user = $this->usermodel->getInfo( array('id' => $info->user_id) );
      //回复用户的发帖数
      $info->user->posts_count = $this->postmodel->getCount( array('user_id' => $info->user_id, 'parent_id' => 0, "status" => "normal") );
    }
    //上一主题
    $prev[ 'top >=' ] = $data->top;
    $prev[ 'created >=' ] = $data->created;
    $prev[ 'id <>' ] = $data->id;
    $prev[ 'parent_id' ] = 0;
    $prev[ 'plate_id' ] = $data->plate_id;
    //上一主题
    $next[ 'top <=' ] = $data->top;
    $next[ 'created <=' ] = $data->created;
    $next[ 'id <>' ] = $data->id;
    $next[ 'parent_id' ] = 0;
    $next[ 'plate_id' ] = $data->plate_id;

    $prev = $this->postmodel->getList( $prev, 1, 0, "top ASC,created ASC,id ASC" );
    $next = $this->postmodel->getList( $next, 1, 0, "top DESC,created DESC,id DESC" );

    $this->setComponent( 'post_view', array('start' => $start, 'data' => $data, 'plate_info' => $plate_info, 'prev' => $prev, "next" => $next, 'repeat_info' => $repeat_info, 'pagination' => $pagination) );
    $this->showTemplate( 'forum_base' );
  }

  //回复帖子
  function reply( $id, $plate_id )
  {
    $post = $this->input->post();
    if ( empty( $post[ 'content' ] ) )
    {
      $this->fail( "请填写回复内容" );
    }
    $post[ 'user_id' ] = $this->user['id'];
    $post[ 'parent_id' ] = $id;
    $post[ 'plate_id' ] = $plate_id;
    $post[ 'title' ] = " ";
    $post[ 'status' ] = "lock";
    $post[ 'content' ] = $post[ 'content' ];
    $this->postmodel->db->set( 'last_reply_time', 'NOW()', false );
    $this->postmodel->db->set( 'last_reply', $this->user['id'], false );
    //回复次数
    $this->postmodel->db->set( 'reply', 'reply+1', false );
    $this->postmodel->update( array(), array('id' => $id) );

    $this->postmodel->insert( $post );
    Util::redirect( "/forum/view/$id" );
  }

}