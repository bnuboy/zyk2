<?php
include_once '_adminController.php';

class Admin_AuditCourse extends AdminController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_AuditCourse_Model');
        $this->load->model('School_Organization_Model');
        $this->load->model('Study_Course_Cat_Model');
        $this->load->library('adminpagination');
    }
    //选课列表
    function index($start=0)
    {
        $get = $this->input->get();
        $where=array();
        $limit=10;
        $where['gz_study_select_course.status'] = 'wait';
        $list = $this->Admin_AuditCourse_Model->getList($where,$limit,$start);
        $count = $this->Admin_AuditCourse_Model->get_count($where);
        
        foreach($list as $key=>$val)
        {
           $list[$key]['organization'] = $this->School_Organization_Model->getOne("`id` = '".$val['organization_id']."'");
           $list[$key]['cat']          = $this->Study_Course_Cat_Model->getOne("`id` = '".$val['classify_cat_id']."'");
        }
        //
        $config['base_url']   = base_url().'admin_auditcourse/index';
        $config['total_rows'] = $count;
        $config['per_page']   = $limit;
        $this->adminpagination->initialize($config);
        $pagination = $this->adminpagination->create_links();
        
        $result = array(
            'list'       => $list,
            'count'      => $count,
            'pagination' => $pagination
        );
        $this->setComponent('admin_auditcourse',$result);
        $this->showTemplate('admin_base');
    }
    //批量审核
    function plsh()
    {
        $sttr='';
        try{
             $post = $this->input->post('item_id');
            if(!empty($post))
            {
                foreach($post as $key=>$val)
                {
                    $sttr = explode('_', $val);
                    $this->Admin_AuditCourse_Model->piliang(array('course_id'=>$sttr[0],'user_id'=>$sttr[1] ));                  
                }
              $this->AJAXSuccess();
            }else{
                 $this->AJAXFail();
            }
           
        }
        catch (Exception $ex)
        {
            $this->AJAXFail();
        }
   
    }
    
    //
    function courseaudit()
    {
        $id  = isset($_GET['id']) ? $_GET['id']  : '' ;
        $uid = isset($_GET['uid'])? $_GET['uid'] : '' ;
        if(isset($id) && isset($uid))
        {
            $this->Admin_AuditCourse_Model->update_status(array('course_id'=>$id,'user_id'=>$uid));
        }
             
        
        Util::redirect('/admin_auditcourse/index');
    }
}
?>
