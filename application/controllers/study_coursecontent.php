<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达合创
 * 代码首次编写日期：2012-07-21
 */

include_once "_studyController.php";

class study_coursecontent extends StudyController
{

    function __construct()
    {
        parent::__construct();
        $this->load->library( 'Form_validation' );
        $this->load->helper( 'url' );
        $this->load->helper( 'form' );
        $this->load->model( 'Study_Coursecontent_Model' );
        $this->load->model( 'Study_Course_Log_Model' );
        $this->load->model('Resource_Library_Model');
        $this->load->model('Resource_Info_Model');
        $this->load->model('Resource_Cat_Model');
        $this->load->helper( 'Util' );
    }

    /*
     * 课程内容
     */

    function index( $id=null, $start=0 )
    {
        //构造数据
        $content=array();
        $course_id=$this->course['id'];
        $list = $this->Study_Coursecontent_Model->getTreeCourses("`course_id` = ".$course_id,"*","order DESC");
        if ( $list )
        {
            if ( !isset( $id ) )
                $id = $list[ 0 ][ 'id' ];
            $content = $this->Study_Coursecontent_Model->getOne( 'id =' . $id );
            //关联资源
                if(!empty($content['resource_id'])){
                   $content['resource']=$this->Resource_Info_Model->getAll("`id` in(".$content['resource_id'].")","swf_path,file_path");
                }
           // 阅读记录  构造插入数据
            $data = array(
                "content_id" => $id,
                "user_id"    => $this->user[ 'id' ]
            );
            //构造  阅读记录数据
            $log = $this->Study_Course_Log_Model->getOne( "`content_id` =" . $id . " AND `user_id` =" . $this->user[ 'id' ] );
            if ( $log )
            {
                $this->Study_Course_Log_Model->update_read( array(), 'content_id =' . $id . " AND `user_id` =" . $this->user[ 'id' ] );
            }
            else
            {
                $this->Study_Course_Log_Model->insert( $data );
            }
        }
        //构造返回数据
        $result = array(
            "list"    => $list,
            "content" => $content,
            "id"      => $id
        );
        $this->setComponent( 'coursecontent', $result );
        $this->showTemplate( 'study_content_base' );
    }

    /*
     * 上移下移
     */
    function move($id,$type){
        //构造条件
        $content_info=$this->Study_Coursecontent_Model->getOne("`id` = " .$id,"`order`, cid");

        if($type=='up'){
            $prev=$this->Study_Coursecontent_Model->getOne("`order` >= '".$content_info['order']."' AND `cid` = '".$content_info['cid']."'", 'id,order', 'order asc' );
            $data = array( 'order' => $prev['order']+1 );
            $this->Study_Coursecontent_Model->update($data, "`id` = '".$id."'");
        }else{
            $next=$this->Study_Coursecontent_Model->getOne("`order` <= '".$content_info['order']."' AND `cid` = '".$content_info['cid']."'",'id,order','order desc' );
            if($next && $next['order']!=0){
            $data = array( 'order' => $next['order']-1 );
            $this->Study_Coursecontent_Model->update($data, "`id` = '".$id."'");
            }
        }
       Util::redirect('/study_coursecontent/index/'.$id);
    }

    /*
     * 修改阅读时间
     */

    function addtimer( $content_id )
    {
        $this->Study_Course_Log_Model->update_timer( array(), 'content_id =' . $content_id . " AND `user_id` =" . $this->user["id"] );
    }

    /*
     * 课程章目添加
     */

    function add(){
        if ( $_POST ){
            $data = array(
                "content"     =>   $_POST[ 'content' ],
                "title"       =>   $_POST[ 'title' ],
                'cid'         =>   '0',
                'course_id'   =>  $this->course['id'],
                'resource_id' => $_POST['resource_id']
            );
          $insert_id=$this->Study_Coursecontent_Model->insert( $data );
          Util::redirect('/study_coursecontent/index/'.$insert_id);
        }
        //构造数据
        $list = $this->Study_Coursecontent_Model->getTreeCourses("`course_id` = ".$this->course['id'],"*","order DESC");
        //构造返回数据
        $result = array(
            "list" => $list
        );
        $this->setComponent( 'coursecontent_add', $result );
        $this->showTemplate( 'study_content_base' );
   }

    /*
     * 节点增加
     */

    function nodeadd( $parent_id )
    {
        if($_POST){
           $_POST[ 'cid' ] = $parent_id;
           $_POST['course_id']=  $this->course['id'];
           $insert_id = $this->Study_Coursecontent_Model->insert( $_POST );
           Util::redirect('/study_coursecontent/index/'.$insert_id);
        }
        //构造数据
        $list = $this->Study_Coursecontent_Model->getTreeCourses("`course_id` = ".$this->course['id'],"*","order DESC");
        //返回所有的父级
        $this->Study_Coursecontent_Model->_current( $list, $parent_id, $current );
        $current = array_reverse( $current );

        //构造返回数据
        $result = array(
            "list" => $list,
            "parent_id" => $parent_id,
            "id" => $parent_id,
            "current" => $current
        );
        $this->setComponent( 'nodeadd', $result );
        $this->showTemplate( 'study_content_base' );
    }

    /*
     * 节点编辑
     */

    function edit( $id )
    {
        if($_POST){
            $this->Study_Coursecontent_Model->update( $_POST, "id = " . $id );
            Util::redirect('/study_coursecontent/index/'.$id);
        }
        //构造数据
        $list = $this->Study_Coursecontent_Model->getTreeCourses("`course_id` = ".$this->course['id'],"*","order DESC");
        $content = $this->Study_Coursecontent_Model->getOne( 'id =' . $id );

        //构造返回数据
        $result = array(
            'list' => $list,
            'id' => $id,
            'content' => $content
        );
        $this->setComponent( 'coursecontent_edit', $result );
        $this->showTemplate( 'study_content_base' );
    }

    /*
     * * 删除
     */

    function delete( $id )
    {
        $where = 'id=' . $id;
        //获取章节的子列
        $delete_id = $this->Study_Coursecontent_Model->getChildIds( $id );
        array_push( $delete_id, $id );
        $delete_data = implode( ',', $delete_id );

        //构造删除数据
        if ( $delete_data )
            $where = '`id` in (' . $delete_data . ')';

        $result = $this->Study_Coursecontent_Model->delete( $where );
        Util::redirect( '/study_coursecontent/index', '删除成功' );
    }

    /*
     * 关联资源库
     */

    function connectresource($cat_id = 0){
        //初始化条件
        $this->load->model("Study_Course_Model");
        $catnav = array();
        $content_id='';
        //构造条件
        $course=$this->course['id'];
        $resource=$this->Study_Course_Model->getOne("`id` = ".$course,'resource_id');
        //分类导航
        if(!empty($cat_id)) $catnav = $this->Resource_Cat_Model->getParents($cat_id, 'id, f_id, name');
        //所有分类
        $cats = $this->Resource_Cat_Model->getAll("`library_id` = '".$resource['resource_id']."'");
        //资源库信息
        $library = $this->Resource_Library_Model->getOne("`id` = '".$resource['resource_id']."'");
        if(!empty($_GET['content_id'])){
           $content_id=$_GET['content_id'];
        }
        //构造返回
        $result = array(
            'library'     => $library,
            'cat_id'      => $cat_id,
            'cats'        => $cats,
            'catnav'      => $catnav,
            'content_id' =>$content_id
        );
        $this->setComponent( 'connectresource', $result);
        $this->showTemplate( 'base' );
    }

    /*
     * 取得资源列表
     */
    function getresource($cat_id=0){
        //初始化数据
        $this->load->model("Study_Course_Model");
        //构造条件
        $where = array();
        $where[] = "`status` = 'succeed'";
        $course=$this->course['id'];
        $resource=$this->Study_Course_Model->getOne("`id` = ".$course,'resource_id');
        $where[]="`library_id` = ".$resource['resource_id'];
        if(!empty($cat_id)) $where[] = "(`cat_id` = '".$cat_id."' OR `cat_id` like '".$cat_id.",%' OR `cat_id` like '%,".$cat_id."' OR `cat_id` like '%,".$cat_id.",%')";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->Resource_Info_Model->getAll($condition, '*', '`id` DESC');
        //判断是否已经关联资源
        if(!empty($_GET['content_id'])){
            $content=$this->Study_Coursecontent_Model->getOne("`id` = ".$_GET['content_id']);
            if($content['resource_id']!=""){
                $resource_id=explode(',', $content['resource_id']);
                //edit 时判断是否已经被选中
                foreach($list as $key=>$value){
                if(in_array($value['id'],$resource_id)){$list[$key]['check']="1";}
                }
            }
        }
        //构造返回
        $this->AJAXSuccess($list);
    }


}
?>