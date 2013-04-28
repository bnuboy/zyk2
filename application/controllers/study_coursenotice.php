<?php
include_once "_studyController.php";

class study_coursenotice extends StudyController
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper( 'url' );
        $this->load->helper( 'form' );
        $this->load->model( 'Study_Coursenotice_Model' );
    }

    /*
     * 课堂公告 列表
     */

    function index( $offset = 0 )
    {
        //构造查询条件
        $limit = 10;
        $get = $this->input->get();
        $where = array();
        if ( !empty( $get[ 'title' ] ) )
            $where[ 'title LIKE ' ] = "'%" . $get[ 'title' ] . "%'";
        if ( !empty( $get[ 'priority' ] ) )
            $where[ 'priority' ] = "'" . $get[ 'priority' ] . "'";
        $where['course_id']=  $this->course['id'];
        //构造数据
        $list = $this->Study_Coursenotice_Model->getAll( $where, '*', 'id desc', $limit, $offset );

        //构造返回数据
        $result = array(
            "list" => $list,
            "get" => $get
        );

        $this->setComponent( 'study_coursenotice', $result );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 查看课堂公告
     */

    function view( $id )
    {
        //构造数据
        $notice = $this->Study_Coursenotice_Model->getOne( array('id' => $id) );

        //构造查询数据
        $prev = array();
        $next = array();
        $prev[ 'id >' ] = $id;
        $next[ 'id <' ] = $id;

        //构造数据
        $prev = $this->Study_Coursenotice_Model->getOne( $prev, '*', 'id desc' );
        $next = $this->Study_Coursenotice_Model->getOne( $next, '*', 'id desc' );

        //构造返回数据
        $result = array(
            "notice" => $notice,
            "prev" => $prev,
            "next" => $next
        );
        $this->setComponent( 'study_coursenotice_view', $result );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 新建课堂公告
     */

    function add()
    {
        if ( $_POST )
        {
            $post = $this->input->post();
            $post[ 'created' ] = date( "Y-m-d H:i:s", time() );
            $post['course_id']=  $this->course['id'];
            $this->Study_Coursenotice_Model->insert( $post );
            Util::redirect( '/study_coursenotice/index' );
        }
        $this->setComponent( 'study_coursenotice_add' );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 修改课堂公告
     */

    function edit( $id )
    {
        if ( $_POST )
        {
            $post = $this->input->post();
            $this->Study_Coursenotice_Model->update( $post, 'id = ' . $id );
            Util::redirect( '/study_coursenotice/index' );
        }
        $notice = $this->Study_Coursenotice_Model->getOne( array('id' => $id) );
        $this->setComponent( 'study_coursenotice_edit', array("notice" => $notice) );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 删除课堂公告
     */

    function delete( $id )
    {
        $this->Study_Coursenotice_Model->delete( "`id` = '" . $id . "'" );
        Util::redirect( '/study_coursenotice/index', '删除成功' );
    }

    function deletes()
    {
        $post = $this->input->post();
        $where = implode( ',', $post[ "item_id" ] );
        $this->Study_Coursenotice_Model->delete( "`id` in (" . $where . ")" );
        $this->AJAXSuccess();
    }



}