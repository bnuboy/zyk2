<?php

include_once '_studyController.php';

class Study_Question extends StudyController {

    function __construct() {
        parent::__construct();
        $this->load->model('Study_Question_Model');
        $this->load->model('Study_Coursecontent_Model');
        $this->load->model('Study_Coursecontent_Model');
        $this->load->library('adminpagination');
    }

    function index($start = 0) {
        $get = $this->input->get();
        //参数初始化
        $limit = 10;
        $where = array();
        //构造条件
        if (isset($get['title']))  $where['title LIKE '] = '%' . $get['title'] . '%';
        $where['gz_study_line_question.status  '] = 'n';
        //构造数据
        $list = $this->Study_Question_Model->getList($where, $limit, $start, 'id desc');
        $count = $this->Study_Question_Model->getQuestionCount($where);
        //构造分页
        $config['base_url'] = base_url() . 'study_question/index';
        $config['total_rows'] = $count;
        $config['per_page'] = $limit;
        $this->adminpagination->initialize($config);
        $pagination = $this->adminpagination->create_links();
        //构造返回数据
        $result = array(
            'list'         => $list, 
            'count'        => $count, 
            'pagination'   => $pagination, 
            'get'          => $get
        );
        $this->setComponent('question', $result);
        $this->showTemplate('study_base');
    }

    function reply($id) {
        $post = $this->input->post();

        if ($post['reply']) {
            $post['auser_id'] = $this->user['id'];
            $post['question_id '] = $id;
            $this->Study_Question_Model->reply($post, array('id' => $id));
            Util::redirect('/study_question/index');
        } else {
            Util::jumpback('请填写回复内容再提交！');
        }
    }

    /**
     * 获取未回复问题信息
     * @param type $id 
     */
    function get_question_info($id) {
        $info = $this->Study_Question_Model->getInfo(array('gz_study_line_question.id' => $id));
        $answer_count = $this->Study_Question_Model->get_answer_count(array('id' => $id));
        //更新浏览次数
        $this->Study_Question_Model->browse_count(array('browse_count' => $info['browse_count'] + 1), array('id' => $id));
        //构造数据
        $collect_count = $this->Study_Question_Model->get_collect_count(array('question_id' => $id));
        //构造返回数据
        $result = array(
            'info'          => $info, 
            'answer_count'  => $answer_count,
            'collect_count' => $collect_count
        );
        $this->setComponent('reply', $result);
        $this->showTemplate('study_base');
    }

    /**
     * 更新收藏次数
     */
    function get_collect($param, $id) {
        $info = $this->Study_Question_Model->get_collect_info(array('gz_study_collect.question_id' => $id,'user_id'=>$this->user['id']));
        if(!empty ($info)){
             $this->AJAXFail('您已经收藏了');die();
        }
        if ($param == 'add') {
            $this->Study_Question_Model->insert_collect(array('gz_study_collect.question_id' => $id,'user_id'=>$this->user['id']));
            $info = $this->Study_Question_Model->getInfo(array('gz_study_line_question.id' => $id));
            $this->AJAXSuccess($info);
        }
    }

    /**
     * 单个删除操作
     */
    function delete_one($id) {
        $this->Study_Question_Model->delete(array(array($id)));
        Util::redirect('/study_question/index');
    }

    /**
     * 删除问题
     */
    function delete() {
        try {
            $data = $this->input->post('item_id');
            $this->Study_Question_Model->delete($data);
            $this->AJAXSuccess();
        } catch (Exception $ex) {
            $this->AJAXFail();
        }
    }

    /**
     * 问题汇总
     */
    function question_list($start = 0) {
        $get = $this->input->get();
        //参数初始化
        $limit = 10;
        $where = array();
        //构造条件
        if (isset($get['title']))  $where['title LIKE '] = '%' . $get['title'] . '%';
        //构造数据
        $list = $this->Study_Question_Model->getList($where, $limit, $start, 'id desc');
        $count = $this->Study_Question_Model->getQuestionCount($where);       
        if ($list) {
            foreach ($list as $key => $val) {
                $list[$key]['answer_count'] = $this->Study_Question_Model->get_answer_count(array('question_id' => $val['id']));
                $list[$key]['last_time'] = $this->Study_Question_Model->get_lasttime(array('question_id' => $val['id']));
            }
        }
        //构造分页
        $config['base_url'] = base_url() . 'study_question/question_list';
        $config['total_rows'] = $count;
        $config['per_page'] = $limit;
        $this->adminpagination->initialize($config);
        $pagination = $this->adminpagination->create_links();
        //构造返回数据
        $result = array(
            'list'          => $list, 
            'count'         => $count, 
            'pagination'    => $pagination, 
            'get'           => $get
        );
        $this->setComponent('question_list', $result);
        $this->showTemplate('study_base');
    }

    /**
     * 问题汇总查看
     */
    function get_look($param, $id) {
        $info = $this->Study_Question_Model->getInfo(array('gz_study_line_question.id' => $id));
        $answer_count = $this->Study_Question_Model->get_answer_count(array('question_id' => $id));
        //更新浏览次数
        $this->Study_Question_Model->browse_count(array('browse_count' => $info['browse_count'] + 1), array('id' => $id));
        //获取所有的回答
        $results = $this->Study_Question_Model->get_all_answer(array('question_id' => $id));
        $collect_count = $this->Study_Question_Model->get_collect_count(array('question_id' => $id));
         //构造返回数据
        $result = array(
            'info'          => $info, 
            'answer_count'  => $answer_count, 
            'results'       => $results,
            'collect_count' =>$collect_count
        );
        $this->setComponent($param . '_question_look', $result);
        $this->showTemplate('study_base');
    }

    /**
     * 常见问题 
     */
    function faq_question($start = 0) {
        //
        $get = $this->input->get();
        $limit = 10;
        $where = array();
        //构造条件
        if (isset($get['title'])) $where['title LIKE '] = '%' . $get['title'] . '%';
        $where['gz_study_line_question.faq'] = 'y';
        //构造数据
        $list = $this->Study_Question_Model->getList($where, $limit, $start, 'id desc');
        $count = $this->Study_Question_Model->getQuestionCount($where);
        //构造分页
        $config['base_url'] = base_url() . 'study_question/faq_question';
        $config['total_rows'] = $count;
        $config['per_page'] = $limit;
        $this->adminpagination->initialize($config);
        $pagination = $this->adminpagination->create_links();
        //构造返回数据
        $result = array(
            'list'          => $list, 
            'count'         => $count, 
            'pagination'    => $pagination, 
            'get'           => $get
        );
        $this->setComponent('faq_question', $result);
        $this->showTemplate('study_base');
    }

    /**
     * 创建常见问题 
     */
    function faq_add() {
        
        $list = $this->Study_Coursecontent_Model->getTreeCourses("`course_id` = ".$this->course['id']);
        $this->setComponent('faq_add',array('list'=>$list));
        $this->showTemplate('study_base');
    }

    /**
     * 保存添加的常见问题 
     */
    function faq_addup() {
        $post = $this->input->post();
        if (!empty($post)) {
            $post['quser_id'] = $this->user['id'];
            $post['faq'] = 'y';
            $post['status'] = 'y';
            $post['collect_count']=0;
            $this->Study_Question_Model->faq_insert($post);
            Util::redirect('/study_question/faq_question');
        }
    }

    /**
     * 收藏夹 
     */
    function collect($start = 0) {
        $get = $this->input->get();
        //参数初始化
        $limit = 10;
        $where = array();
        if (isset($get['title'])) $where['title LIKE '] = '%' . $get['title'] . '%';     
        $where['gz_study_collect.user_id'] = $this->user['id'];
        //构造数据
        $info = $this->Study_Question_Model->get_collect_info(array('user_id'=> $this->user['id']));
        $list = $this->Study_Question_Model->show_collect($where, $limit, $start, 'id desc');
        if ($list) {
            foreach ($list as $key => $val) {
                $list[$key]['answer_count'] = $this->Study_Question_Model->get_answer_count(array('question_id' => $val['id']));
                $list[$key]['last_time'] = $this->Study_Question_Model->get_lasttime(array('question_id' => $val['id']));
            }
        }
        //构造分页
        $count = $this->Study_Question_Model->get_collect_count(array('user_id' => $this->user['id']));
        $config['base_url'] = base_url() . 'study_question/collect';
        $config['total_rows'] = $count;
        $config['per_page'] = $limit;
        $this->adminpagination->initialize($config);
        $pagination = $this->adminpagination->create_links();
        //构造返回数据
        $result = array(
            'list'          => $list, 
            'count'         => $count, 
            'pagination'    => $pagination, 
            'get'           => $get
        );
        $this->setComponent('collect', $result);
        $this->showTemplate('study_base');
    }

    /**
     * 取消收藏操作 
     */
    function collect_status() {
        try {
            $data = $this->input->post('item_id');
            $this->Study_Question_Model->change_collect($data);
            $this->AJAXSuccess();
        } catch (Exception $ex) {
            $this->AJAXFail();
        }
    }

    /**
     * 统计信息 
     */
    function statinfo() {
        //参数初始化
        $attr = array();
        $attr_user = array();
        //构造数据
        $list = $this->Study_Question_Model->stat_info('status', array('status' => 'y'));
        foreach ($list as $key=>$val)
        {
            $list[$key]['zj_name'] = $this->Study_Question_Model->get_zhangjie_name(array('id'=>$val['plan_id']));
        }
        $list1 = $this->Study_Question_Model->stat_info('status', array('status' => 'n'));
        foreach ($list1 as $key=>$val)
        {
            $list1[$key]['zj_name'] = $this->Study_Question_Model->get_zhangjie_name(array('id'=>$val['plan_id']));
        }
        
        $faq = $this->Study_Question_Model->stat_info('faq', array('faq' => 'y'));
        foreach ($faq as $key=>$val)
        {
            $faq[$key]['zj_name'] = $this->Study_Question_Model->get_zhangjie_name(array('id'=>$val['plan_id']));
        }
        if ($list) {
            foreach ($list as $key => $val) {
                $attr[$val['zj_name']['title']][$val['status']] = $val['num'];
            }
        }
        if ($list1) {
            foreach ($list1 as $key => $val) {
                $attr[$val['zj_name']['title']][$val['status']] = $val['num'];
            }
        }
        if ($faq) {
            foreach ($faq as $key => $val) {
                $attr[$val['zj_name']['title']]['faq'] = $val['num'];
            }
        }      
        $list_user = $this->Study_Question_Model->stat_user_info('status', array('status' => 'y'));
        $list1_user = $this->Study_Question_Model->stat_user_info('status', array('status' => 'n'));
        $faq_user = $this->Study_Question_Model->stat_user_info('faq', array('faq' => 'y'));
        if ($list_user) {
            foreach ($list_user as $key => $val) {
                $attr_user[$val['quser_name']][$val['status']] = $val['num'];
            }
        }
        if ($list1_user) {
            foreach ($list1_user as $key => $val) {
                $attr_user[$val['quser_name']][$val['status']] = $val['num'];
            }
        }
        if ($faq_user) {
            foreach ($faq_user as $key => $val) {
                $attr_user[$val['quser_name']]['faq'] = $val['num'];
            }
        }
        //构造返回数据
        $result = array(
            'attr'      =>$attr,
            'attr_user' =>$attr_user
        );
        $this->setComponent('statinfo',$result);
        $this->showTemplate('study_base');
    }
    
    /**
     * 我的问题
     */
    
    function my_question($start=0)
    {
        $limit=10;
        $where='';
        $get = $this->input->get();
        $where ='`quser_id` ='.  $this->user['id'];
        $where .=' AND `course_id` = '.  $this->course['id'];
        if($get['title']) $where .=" AND `title` like '%".$get['title']."%'";
        $list = $this->Study_Question_Model->my_question_list($where,$limit,$start);
        $count = $this->Study_Question_Model->my_question_count($where);
        
        foreach($list as $key=>$val)
        {
            $list[$key]['count'] = $this->Study_Question_Model->get_answer_count(array('question_id'=>$val['id']));
            $list[$key]['last_riqi'] = $this->Study_Question_Model->get_lasttime(array('question_id'=>$val['id']));
        }
        $config['base_url'] = base_url().'study_question/my_question';
        $config['total_rows'] =$count;
        $config['per_page'] = $limit;
        $this->adminpagination->initialize($config);
        $pagination = $this->adminpagination->create_links();
        $result = array(
            'list' =>$list,
            'count' =>$count,
            'pagination' =>$pagination
        );
        
        $this->setComponent('my_question',$result);
        $this->showTemplate('study_base');
    }
    /**
     * 进行提问
     */
    function my_tiwen()
    {
        
        if($_GET)
        {
            
            $list = $this->Study_Question_Model->my_question_list('`title` like "%'.$_GET['title'].'%" and `course_id` ='.$this->course['id']);
            foreach($list as $key=>$val)
            {
                $list[$key]['count'] = $this->Study_Question_Model->get_answer_count(array('question_id'=>$val['id']));
                $list[$key]['last_riqi'] = $this->Study_Question_Model->get_lasttime(array('question_id'=>$val['id']));
            }
            $result=array(
                'list' => $list,
                'post' => $_GET
            );
                       
            $this->setComponent('question_like',$result);
            $this->showTemplate('base');
            //print_r($list);
//$this->Study_Question_Model->insert($_POST);
            // Util::redirect('/study_question/my_question');
        }else{
            $plan = $this->Study_Coursecontent_Model->getAll('id > 0','*','id desc');       
            $result=array(
                'plan' =>$plan
            );
            $this->setComponent('my_tiwen',$result);
            $this->showTemplate('study_base');
        }
    }
    
    function tiwen_add()
    {
        if($_POST)
        {
            $_POST['quser_id'] = $this->user['id']; 
            $_POST['course_id'] = $this->course['id'];
            $_POST['qtime'] =date('Y-m-d H:i:s',  mktime());
            $this->Study_Question_Model->insert($_POST);
            echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
        }
    }
    
    function see_question($id)
    {
         $info = $this->Study_Question_Model->getInfo(array('gz_study_line_question.id' => $id,'course_id'=>  $this->course['id']));
        $answer_count = $this->Study_Question_Model->get_answer_count(array('question_id' => $id));
        
        //获取所有的回答
        $results = $this->Study_Question_Model->get_all_answer(array('question_id' => $id));
        $collect_count = $this->Study_Question_Model->get_collect_count(array('question_id' => $id));
         //构造返回数据
        $result = array(
            'info'          => $info, 
            'answer_count'  => $answer_count, 
            'results'       => $results,
            'collect_count' =>$collect_count
        );
        $this->setComponent('see_question', $result);
        $this->showTemplate('base');
    }

}

?>
