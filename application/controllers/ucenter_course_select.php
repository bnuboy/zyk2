<?php
include_once '_ucenterController.php';

class Ucenter_Course_Select extends UcenterController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Study_Course_Model');
        $this->load->model('School_Organization_Model');
        $this->load->model('Study_Course_Cat_Model');
        $this->load->model('Study_Course_Part_Model');
        $this->load->model('Study_Course_Class_Model');
        $this->load->model('Study_Select_Course_Model');
        $this->load->library('adminpagination');
    }
    
    /**
     * 课程列表
     */
    
    function index($start=0)
    {
        $limit=10;
        $where='';
        $where = '`id` > 0';
        $get=  $this->input->get();
        if($get['classify_cat_id'])
            $where .=' AND `classify_cat_id`='.$get['classify_cat_id'];
        if($get['name'])
            $where .=' AND `name` like "%'.$get['name'].'%"';
        $list = $this->Study_Course_Model->getAll($where, '*', '`id` DESC' );
        $count = $this->Study_Course_Model->getCount( $where );
        $classify = $this->Study_Course_Cat_Model->getAll("`id` > 0",'*','id desc');
        foreach($list as $k => $v){
            $list[$k]['organization'] = $this->School_Organization_Model->getOne("`id` = '".$v['organization_id']."'");
            $list[$k]['cat']          = $this->Study_Course_Cat_Model->getOne("`id` = '".$v['classify_cat_id']."'");
            $list[$k]['teachers']     = $this->Study_Course_Model->getTeachers($v['id']);           
        }
        $config['base_url'] = base_url().'ucenter_course_select/index';
        $config['per_page'] = $limit;
        $config['total_rows'] = $count;
         $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        //echo $this->course['id'];
        $result = array(
            'list' => $list,
            'count'=> $count,
            'pagination' =>$pagination,
            'get'   => $get,
            'classify' => $classify
        );
        $this->setComponent('course_list',$result);
        $this->showTemplate('ucenter_base');
    }
    
    /**
     * 开始选课
     */
    
    function select_course($id)
    {
       $part = $this->Study_Course_Part_Model->getAll('id > 0','*','id desc');
       $info = $this->Study_Course_Model->getOne('`id`='.$id);
       $class = $this->Study_Course_Class_Model->getAll('`course_id` ='.$id,'*','`id` desc');
       $result = array(
           'id'   => $id,
           'part' => $part,
           'info' => $info,
           'class' => $class
       );
       $this->setComponent('select_course',$result);
       $this->showTemplate('base');
    }
    
    function add($id)
    {
        if($_POST){
            $_POST['user_id'] = $this->user['id'];
            $_POST['course_id'] = $id;
            $_POST['created'] = date('Y-m-d H:i:s', mktime());
        }
        $this->Study_Select_Course_Model->insert($_POST);
         echo "<script>parent.$('.iframe').colorbox.close();</script>";
    }
}
?>
