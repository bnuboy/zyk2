<?php
include_once '_studyController.php';

class Study_Teach_Manage extends StudyController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model( 'Study_Teach_Manage_Model' );
        $this->load->library( 'adminpagination' );
        $this->load->helpers('url');
    }

    function index( $start=0 )
    {
       //参数初始化
        $get = $this->input->get();
        $where = array();
        $limit = 10;
        //构造查询条件
        if ( $get[ 'name' ] ) $where[ 'gz_users.name LIKE' ] = '%' . $get[ 'name' ] . '%';
        if ( $get[ 'status' ] )
        {
            $where[ 'gz_study_select_course.status' ] = $get[ 'status' ];
        }
        else
        {
            $where[ 'gz_study_select_course.status' ] = 'wait';
        }
        $where[ 'gz_study_select_course.course_id' ] = $this->course['id'];
        //构造数据
        $list = $this->Study_Teach_Manage_Model->get_select_course( $where, $limit, $start );
        $count = $this->Study_Teach_Manage_Model->get_select_count( $where );
        //构造分页
        $config[ 'base_url' ] = base_url() . 'Study_Teach_Manage/index';
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        //构造返回数据
        $results = array(
            'list'       => $list, 
            'count'      => $count,
            'pagination' => $pagination, 
            'get'        => $get
        );
        $this->setComponent( 'teach_manage', $results );
        $this->showTemplate( 'study_base' );
    }

    /**
     * 审核信息
     * @param type $id
     */
    function audit( $id )
    {
        $this->Study_Teach_Manage_Model->audit( $id );
        Util::redirect('/study_teach_manage/index');
    }

    /**
     * 删除信息
     */
    function delete()
    {
        try
        {
            //构造数据
            $data = $this->input->post( 'item_id' );
            //删除数据
            $this->Study_Teach_Manage_Model->delete_course( $data );
            $this->AJAXSuccess();
        }
        catch ( Exception $ex )
        {
            $this->AJAXFail();
        }
    }

    /**
     * 导入用户
     */
    function add_user()
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
            'id'    => $id, 
            'part'  => $parts
        );
        $this->setComponent( 'add_user', $result );
        $this->showTemplate( 'base' );
    }

    function insert_user()
    {
       $_POST[ 'user_id' ] = array();
        if ( !empty( $_POST[ 'users' ] ) )
        {
            $_POST[ 'users' ] = str_replace( '，', ',', $_POST[ 'users' ] );
            $_POST[ 'users' ] = explode( ',', $_POST[ 'users' ] );
            //print_r($_POST);
            foreach ( $_POST[ 'users' ] as $val )
            {
                if (  trim($val  ))
                {
                    $info = $this->Study_Teach_Manage_Model->get_userinfo( array('login_name' => trim( $val )) );
                    if ( !empty( $info ) )
                        Util::jumpback( $val . ' 已经存在，请重新填写！' );
                    $_POST[ 'user_id' ][ ] = $this->Study_Teach_Manage_Model->get_user( array('login_name' => $val) );
                }
            }
            if ( !empty( $_POST[ 'user_id' ] ) )
            {
                foreach ($_POST['user_id'] as $key=>$val)
                {
                    if(isset($val['id'])){
                    $this->Study_Teach_Manage_Model->add_users(array('user_id'=>$val['id'],'course_id'=>  $this->course['id'],
                        'course_class_id'=>" ",'course_part_id'=>$_POST['course_part_id']));
                    }else{
                        echo "<script>alert('不存在此用户,请重新添加！');</script>";
                    }
                }
            }
        }
            echo "<script>parent.$('.iframe').colorbox.close();</script>";
    }

}
?>
