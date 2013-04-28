<?php
include_once '_studyController.php';

class Study_Class_Manage extends StudyController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model( 'Study_Class_Manage_model' );
        $this->load->library( 'adminpagination' );
        $this->load->model( 'Study_Teach_Manage_Model' );
    }
    function index( $start=0 )
    {
         //参数初始化
        $where = array();
        $limit = 10;
        //构造查询条件
        $where[ 'course_id' ] = $this->course['id'];
        //构造数据
        $list = $this->Study_Class_Manage_model->get_class_list( $where, $limit, $start );      
        $count = $this->Study_Class_Manage_model->getClassCount( $where );
        if ( $list )
        {
            foreach ( $list as $k => $v )
            {              
                $list[ $k ][ 'username' ] = $this->Study_Class_Manage_model->get_class_assistant( array('gz_study_class_join_user.class_id' => $v[ 'id' ],
                            'gz_study_course_part.name' => '助教') );
                $list[ $k ][ 'num' ] = $this->Study_Class_Manage_model->getClassList( array('gz_study_class_join_user.class_id' => $v[ 'id' ]) );
                if ( $list[ $k ][ 'username' ] )
                {
                    $list[ $k ][ 'usernames' ] = '';
                    foreach ( $list[ $k ][ 'username' ] as $key => $val )
                    {
                        $list[ $k ][ 'usernames' ] .=$val[ 'name' ] . ',';
                    }
                    $list[ $k ][ 'usernames' ] = substr( $list[ $k ][ 'usernames' ], 0, strlen( $list[ $k ][ 'usernames' ] ) - 1 ) . '...';
                }
                else
                {
                    $list[ $k ][ 'usernames' ] = '';
                }
            }         
        }
        //构造返回数据
        $result = array(
            'list' => $list
        );
        $this->setComponent( 'class_manage', $result );
        $this->showTemplate( 'study_base' );
    }

    /**
     * 重命名
     * @param type $id 
     */
    function rewritename( $id )
    {
        if($_POST){
            $post = $this->input->post();
            $this->Study_Class_Manage_model->update( array('name' => $post[ 'name' ]), array('id' => $id) );
            Util::redirect('/study_class_manage/index');
        }
        //构造数据
        $list = $this->Study_Class_Manage_model->getClassInfo( array('id' => $id) );      
        //构造返回数据
        $result = array(
            'list' => $list,
            'id'   =>$id
        );
        $this->setComponent( 'rewritename', $result );
        $this->showTemplate( 'study_base' );
    }

    /**
     * 创建班级
     */
    function add_class()
    {
        if($_POST)
        {
            $post = $this->input->post();
            $post[ 'course_id' ] = $this->course['id'];
            $this->Study_Class_Manage_model->insert( $post );
            Util::redirect('/study_class_manage/index');
        }
        $this->setComponent( 'add_class' );
        $this->showTemplate( 'study_base' );
    }

   
    /**
     * 导入用户
     */
    function add_user( $class_id )
    {
        $parts = array();
        $id = $this->course['id'];
        //构造数据
        $part = $this->Study_Teach_Manage_Model->get_part();
          if(!empty ($part))
          {
           foreach($part as $key=>$val)
           {
               if($val['name'] !='教师')
               {
                   $parts[]=$val;  
               }
           }
         }
        //构造返回数据
        $result = array(
            'id'        => $class_id, 
            'part'      => $parts, 
            'course_id' => $id
        );
        $this->setComponent( 'add_user', $result );
        $this->showTemplate( 'base' );
    }

    function insert_user( $class_id )
    {
        $_POST[ 'user_id' ] = array();
        if ( !empty( $_POST[ 'users' ] ) )
        {
            $_POST[ 'users' ] = str_replace( '，', ',', $_POST[ 'users' ] );
            $_POST[ 'users' ] = explode( ',', $_POST[ 'users' ] );
            foreach ( $_POST[ 'users' ] as $val )
            {
                if ( trim( $val ) )
                {
                    $info = $this->Study_Class_Manage_model->get_userinfo( array('login_name' => trim( $val )) );
                    if ( !empty( $info ) )
                        Util::jumpback( $val . ' 已经存在，请重新填写！' );
                    $_POST[ 'user_id' ][ ] = $this->Study_Class_Manage_model->get_user( array('login_name' => $val) );
                }
            }
            if ( !empty( $_POST[ 'user_id' ] ) )
            {
                foreach ( $_POST[ 'user_id' ] as $key => $val )
                {
                    $this->Study_Class_Manage_model->add_users( array(
                        'user_id'       => $val[ 'id' ],
                        'class_id'      => $class_id, 
                        'part_id'       => $_POST[ 'part_id' ]) 
                    );
                }
            }
        }
        echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
    }

    /**
     * 获取班级下的用户列表
     * @param type $id
     * @param type $start 
     */
    function get_user_list( $id, $start=0 )
    {
        $limit = 10;
        $where = array();
        //构造数据
        $list = $this->Study_Class_Manage_model->get_user_list( array('gz_study_class_join_user.class_id' => $id), $limit, $start );
        //构造返回数据
        $result = array(
            'list'  => $list,
            'id'    => $id
        );
        $this->setComponent( 'user_list', $result );
        $this->showTemplate( 'study_base' );
    }

    function delete_users()
    {
        try
        {
            //构造数据
            $data = $this->input->post( 'item_id' );
            //删除数据
            $this->Study_Class_Manage_model->delete_users( $data );
            $this->AJAXSuccess();
        }
        catch ( Exception $ex )
        {
            $this->AJAXFail();
        }
    }
    
    function delete()
    {
         try
        {
            //构造数据
            $data = $this->input->post( 'item_id' );
            //删除数据
            $this->Study_Class_Manage_model->delete( $data );
            $this->AJAXSuccess();
        }
        catch ( Exception $ex )
        {
            $this->AJAXFail();
        }
    }

}
?>
