<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达合创
 * 代码首次编写日期：2012-07-23
 */

include_once '_studyController.php';

class study_function_customized extends StudyController
{

    function __construct(){
        parent::__construct();
        $this->load->model("Study_Course_Menu_Model");
        $this->load->model("Study_Course_Groupmenu_Model");
        $this->load->library( 'adminpagination' );
    }

    /*
     * 显示课程信息
     */

    function index($user_type='10003'){
        //参数初始化
        $this->load->model("Study_Course_Part_Model");
        $course_id=$this->course['id'];
        $parts=array("10001"=>'assistant',"10002"=>'student',"10003"=>"teacher");
        if($_POST){
            $menus    =  $_POST["menus"];
            //清除已有节点
            $this->Study_Course_Groupmenu_Model->delete("`course_id` = '".$course_id."' AND `user_type` = ".$user_type);
            //分配新节点
            if(is_array($menus)){
                foreach($menus as $item){
                    $data = array('course_id' => $course_id,'user_type'=>$user_type ,'menu_id' => $item['id']);
                    $this->Study_Course_Groupmenu_Model->insert($data);
                }
            }
            die();
        }

        //构造数据 所有菜单  所有角色
        $roles_types=  $this->Study_Course_Part_Model->getAll();
        $where= "(`typeview` = '".$parts[$user_type]."' OR `typeview` like '".$parts[$user_type].",%' OR `typeview` like '%,".$parts[$user_type]."' OR `typeview` like '%,".$parts[$user_type].",%')";
        $nodes = $this->Study_Course_Menu_Model->getAll($where,"*","order asc");
        //已有节点
        $roleNodeIds = $this->Study_Course_Groupmenu_Model->getGroupMenuIds($course_id,$user_type);
        //构造返回数据
        $result= array(
             "nodes"       => $nodes,
             "roleNodeIds" => $roleNodeIds,
             "roles_types" => $roles_types,
             "user_type"   => $user_type
        );
        $this->setComponent( 'function_customized',$result);
        $this->showTemplate( 'study_base' );
    }
}
?>