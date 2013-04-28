<?php
include_once '_studyController.php';

class Study_Note extends StudyController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model( 'Study_Note_Model' );
        $this->load->model( 'Study_Note_Cat_Model' );
        $this->load->library( 'adminpagination' );
    }

    /**
     * 默认方法
     * @param type $start 
     */
    function index( $start=0 )
    {
        //参数初始化
        $get = $this->input->get();
        $limit = 10;
        //构造查询条件
        $where = array();
        if ( isset( $get[ 'title' ] ) ) $where[ 'title LIKE ' ] = '"%' . $get[ 'title' ] . '%"';
        if ( $get[ 'note_cat_id' ] ) $where[ 'note_cat_id' ] = '"' . $get[ 'note_cat_id' ] . '"';
        $where['course_id'] = $this->course['id'];
        //构造数据
        $list = $this->Study_Note_Model->getAll( $where, $select = '*', $orderby = '`id` DESC', $limit, $start );
        $count = $this->Study_Note_Model->getCount( $where );
        $cat_list = $this->Study_Note_Cat_Model->getAll( 'id > 0 AND `course_id`='.$this->course['id'], $select = '*', $orderby = '`id` DESC', $limit, $start );
        //构造分页
        $config[ 'base_url' ] = base_url() . 'study_note/index';
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        //构造返回数据
        $result = array(
            'list'          => $list, 
            'count'         => $count, 
            'pagination'    => $pagination, 
            'cat_list'      => $cat_list, 
            'get'           => $get
        );
        $this->setComponent( 'note', $result );
        $this->showTemplate( 'study_base' );
    }

    /**
     * 添加方法
     */
    function add()
    {
        if($_POST){
            $post = $this->input->post();
            $post[ 'created' ] = date( 'Y-m-d H:i:s', time() );
            $post[ 'update_time' ] = date( 'Y-m-d H:i:s', time() );
            $post['course_id'] = $this->course['id'];
            $this->Study_Note_Model->insert( $post );
            Util::redirect('/study_note/index');
        }
        //构造数据
        $cat_list = $this->Study_Note_Cat_Model->getAll( 'id > 0 AND `course_id`='.$this->course['id'], $select = '*', $orderby = '`id` DESC', $limit = 0, $start = 0 );
        //构造返回数据
        $result = array(
            'cat_list' => $cat_list
        );
        $this->setComponent( 'note_add', $result );
        $this->showTemplate( 'study_base' );
    }

  
    /**
     * 修改内容
     * @param type $id 
     */
    function edit( $id )
    {
        if($_POST){
            $post = $this->input->post();
            $post[ 'update_time' ] = date( 'Y-m-d H:i:s', time() );
            $this->Study_Note_Model->update( $post, array('id' => $id) );
            Util::redirect('/study_note/index');
        }
        //构造数据
        $list = $this->Study_Note_Model->getOne( array('id' => $id) );
        $cat_list = $this->Study_Note_Cat_Model->getAll( 'id > 0 AND `course_id`='.$this->course['id'], '*', '`id` DESC' );
        //构造返回数据
        $result = array(
            'list'      => $list, 
            'cat_list'  => $cat_list
        );
        $this->setComponent( 'note_edit', $result );
        $this->showTemplate( 'study_base' );
    }

    /**
     * 保存修改的内容
     * @param type $id 
     */

    /**
     * 删除数据
     */
    function delete()
    {
        try
        {
            //构造数据
            $data = $this->input->post( 'item_id' );
            //删除数据
            foreach ( $data as $val )
            {
                $this->Study_Note_Model->delete( array('id' => $val) );
            }
            $this->AJAXSuccess();
        }
        catch ( Exception $ex )
        {
            $this->AJAXFail();
        }
    }

}
?>
