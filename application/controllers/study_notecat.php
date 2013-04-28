<?php
include_once '_studyController.php';

class Study_Notecat extends StudyController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Study_Note_Cat_Model');
        $this->load->model('Study_Note_Model');
        $this->load->library('adminpagination');
    }

    /**
     * 笔记分类列表
     * @param type $start 
     */
    function index( $start=0 ) {
        //参数初始化
        $get = $this->input->get();
        $limit = 10;
        //构造查询条件
        $where = array();
        $where['course_id']=$this->course['id'];
        if (isset($get['name'])) $where['name LIKE '] = '"%' . $get['name'] . '%"';
        //构造数据
        $list = $this->Study_Note_Cat_Model->getAll($where, '*', '`id` DESC', $limit, $start);
        $count = $this->Study_Note_Cat_Model->getCount($where);
        if($list) {
            foreach ($list as $key => $val) {
                $list[$key]['count'] = $this->Study_Note_Model->getCount(array('note_cat_id' => $val['id']));
            }
        }
        //构造分页
        $config[ 'base_url' ]   = base_url() . 'study_notecat/index';
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ]   = $limit;
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        //构造返回数据
        $result = array(
            'list'       => $list, 
            'count'      => $count, 
            'pagination' => $pagination
        );
        $this->setComponent( 'notecat', $result );
        $this->showTemplate( 'study_base' );
    }
    
    /**
     * 新建笔记分类
     */
    function add() {
        if($_POST){
            $post = $this->input->post();
            //if(empty ($post['name'])) Util::jumpback('请填写标题！！');
            $post['course_id']=  $this->course['id'];
            $this->Study_Note_Cat_Model->insert($post);
            echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
        }
        $this->setComponent( 'notecat_add' );
        $this->showTemplate( 'base' );
    }


    /**
     * 根据ID修改分类
     * @param type $id 
     */
    function edit( $id ) {
        if($_POST){
            $post = $this->input->post();
            if(empty($post['name'])) Util::jumpback('请填写标题！！');
            $this->Study_Note_Cat_Model->update( $post, array('id' => $id) );
            echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
        }
        //构造数据
        $info = $this->Study_Note_Cat_Model->getOne( array('id' => $id) );
        //构造返回数据
        $result = array(
            'info' => $info
        );
        $this->setComponent( 'notecat_edit', $result );
        $this->showTemplate( 'base' );
    }

    /**
     * 删除笔记分类
     */
    function delete()
    {
        $count=0;
         $data = $this->input->post( 'item_id' );
         foreach($data as $v)
         {
             //$info = $this->Study_Note_Cat_Model->getOne( array('id' => $val) );
             $count += $this->Study_Note_Model->getCount(array('note_cat_id' => $v));      
         }
             
         if($count==0){             
                try
                {
                    //构造数据       
                    //删除数据
                    foreach ( $data as $val )
                    {   
                            $this->Study_Note_Cat_Model->delete( array('id' => $val) ); 
                            $this->AJAXSuccess(); 
                    }

                }
                catch ( Exception $ex )
                {
                    $this->AJAXFail();
                }
         }else{
             $this->AJAXFail('只能选择笔记数量为0的删除，请检查!') ;
         }
    }

}
?>
