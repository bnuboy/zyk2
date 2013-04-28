<?php
include_once "_studyController.php";

class Study_Pattern extends StudyController
{

    function __construct()
    {
        parent::__construct();
        $this->load->library( 'Form_validation' );
        $this->load->model( 'Study_Pattern_Model' );
        $this->load->library( 'adminpagination' );
        $this->load->helper( 'url' );
        $this->load->helper( 'form' );
    }

    /*
     * 题型管理列表
     */

    function index( $start=0 )
    {      
        $get = $this->input->get();
       
        //参数初始化
        $limit = 10;
        $where = array();
        //构造条件
        $where['gz_study_pattern.id >'] = '0';
        if($get['name'])  $where['gz_study_pattern.name LIKE ']='%'.$get['name'].'%';      
        $list = $this->Study_Pattern_Model->get_list( $where,$limit,$start );
        $count = $this->Study_Pattern_Model->get_count( $where );
        foreach($list as $key=>$val)
        {
            if($val['pattern_type']=='单选题'){
                 $list[$key]['shiti_count'] = $this->Study_Pattern_Model->get_shiti_count(array('tixing_id'=>$val['id']),'danxuan');
            }elseif($val['pattern_type']=='多选题'){
                 $list[$key]['shiti_count'] = $this->Study_Pattern_Model->get_shiti_count(array('tixing_id'=>$val['id']),'duoxuan');
            }elseif($val['pattern_type']=='填空题'){
                 $list[$key]['shiti_count'] = $this->Study_Pattern_Model->get_shiti_count(array('tixing_id'=>$val['id']),'tiankong');
            }elseif($val['pattern_type']=='完形填空'){
                 $list[$key]['shiti_count'] = $this->Study_Pattern_Model->get_shiti_count(array('tixing_id'=>$val['id']),'wanxingtiankong');
            }elseif($val['pattern_type']=='阅读理解'){
                  $list[$key]['shiti_count'] = $this->Study_Pattern_Model->get_shiti_count(array('tixing_id'=>$val['id']),'yuedulijie');
            }elseif($val['pattern_type']=='匹配题'){
                  $list[$key]['shiti_count'] = $this->Study_Pattern_Model->get_shiti_count(array('tixing_id'=>$val['id']),'pipei');
            }elseif($val['pattern_type']=='问答题'){
                  $list[$key]['shiti_count'] = $this->Study_Pattern_Model->get_shiti_count(array('tixing_id'=>$val['id']),'wenda');
            }
        }
        //构造分页
        $config[ 'base_url' ] = base_url() . 'study_pattern/index';
        $config[ 'per_page' ] = $limit;
        $config[ 'total_rows' ] = $count;
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        //构造返回数值
        $result = array(
            'list'       => $list, 
            'count'      => $count, 
            'pagination' => $pagination
        );
        $this->setComponent( 'pattern', $result );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 题型添加
     */

    function add()
    {
        if($_POST)
        {
            $post = $this->input->post();
            $this->Study_Pattern_Model->insert( $post );
            echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
        }
        $pattern_type = $this->Study_Pattern_Model->get_pattern_type();
        $result = array(
            'pattern_type' => $pattern_type
        );
        $this->setComponent( 'pattern_add', $result );
        $this->showTemplate( 'base' );
    }

    /*
     * 题型查看
     */

    function get_look( $param,$id )
    {
        $pattern_type = $this->Study_Pattern_Model->get_pattern_type();
        $info = $this->Study_Pattern_Model->getOne( array('id' => $id) );
        $list  = $this->Study_Pattern_Model->getTimu("`tixing_id` =".$id,$param);
        if($param=='tiankong' || $param == 'wanxingtiankong')
        {
            foreach($list as $key=>$val)
            {
                $list[$key]['title'] = unserialize($val['title']);
            }
        }
        $result = array(
            'pattern'   => $pattern_type, 
            'info'      => $info,
            'list'      => $list
        );
        $this->setComponent( 'pattern_look', $result );
        $this->showTemplate( 'base' );
    }

   
    /*
     * 重命名 
     */

    function edit( $id )
    {
        if($_POST)
        {
            $post = $this->input->post();
            $this->Study_Pattern_Model->update( $post, array('id' => $id) );
            echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
        }
        $count = $_GET['num'];
        $info = $this->Study_Pattern_Model->getOne( array('id' => $id) );
        $pattern_type = $this->Study_Pattern_Model->get_pattern_type();
        $result = array(
            'info'          => $info, 
            'pattern_type'  => $pattern_type,
            'count'         => $count
        );
        $this->setComponent( 'pattern_edit', $result );
        $this->showTemplate( 'base' );
    }


    /*
     * 课程删除
     */

    function delete()
    {
        try
        {
            $data = $this->input->post( 'item_id' );         
            foreach ( $data as $val )
            {
                $this->Study_Pattern_Model->delete( array('id' => $val) );
            }
            $this->AJAXSuccess();
        }
        catch ( Exception $ex )
        {
            $this->AJAXFail();
        }
    }

    /*
     * 作业列表
     */

    function task()
    {
        $this->setComponent( 'task' );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 作业添加
     */

    function taskadd()
    {
        $this->setComponent( 'task_add' );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 作业查看
     */

    function taskcheck()
    {
        $this->setComponent( 'task_check' );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 作业修改
     */

    function taskedit()
    {
        $this->setComponent( 'task_edit' );
        $this->showTemplate( 'study_base' );
    }

    
    /*
     *  自测列表
     */

    function selftest()
    {
        $this->setComponent( 'selftest' );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 自测添加
     */

    function selftestadd()
    {
        $this->setComponent( 'selftest_add' );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 自测查看
     */

    function selftestcheck()
    {
        $this->setComponent( 'selftest_check' );
        $this->showTemplate( 'study_base' );
    }

    
   

}
?>
