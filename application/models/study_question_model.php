<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Study_Question_Model extends DAO {

    public function __construct() {
        parent::initTable('gz_study_line_question', 'id');
    }

    /**
     * 获取未回答问题列表
     * @param type $data
     * @param type $limit
     * @param type $offset
     * @param type $orderby
     * @return type 
     */
    public function getList($data, $limit = 10, $offset = 0, $orderby = '') {
        if ($orderby)
            $this->db->order_by($orderby);
        $this->db->select('gz_study_line_question.*,gz_users.name as username');
        $this->db->join('gz_users', 'gz_users.id = gz_study_line_question.quser_id');
        $list = $this->db->get_where('gz_study_line_question', $data, $limit, $offset)->result_array();
        return $list;
    }

    /**
     * 获取未回答问题的数量
     * @param type $data
     * @return type 
     */
    public function getQuestionCount($data) {
        $this->db->where($data);
        $count = $this->db->count_all_results('gz_study_line_question');
        return $count;
    }

    /**
     * 获取一条数据
     */
    public function getInfo($data) {
        $this->db->select('gz_study_line_question.*,gz_users.name as username');
        $this->db->join('gz_users', 'gz_users.id = gz_study_line_question.quser_id');
        $rows = $this->db->get_where('gz_study_line_question', $data)->row_array();
        return $rows;
    }

    /**
     * 获取回复的数量、次数
     */
    public function get_answer_count($data) {
        $this->db->where($data);
        $count = $this->db->count_all_results('gz_study_line_answer');        
        return $count;
    }

    /**
     * 回复问题，并且更新回答状态
     */
    public function reply($data, $where) {
        $this->db->set('atime', 'NOW()', FALSE);
        $this->db->insert('gz_study_line_answer', $data, $where);
        $this->db->update('gz_study_line_question', array('status' => 'y'), $where);
    }

    /**
     * 更新问题浏览次数
     */
    public function browse_count($data, $where) {
        $this->db->update('gz_study_line_question', $data, $where);
    }

    /**
     * 查询收藏夹是否已经存在本问题ID
     */
    public function get_collect_info($data) {
        //$this->db->update('gz_study_line_question', $data, $where);
        $info = $this->db->get_where('gz_study_collect',$data)->result_array();
        return $info;
    }
    /**
     * 收藏次数
     */
    
    function get_collect_count($data)
    {
        $this->db->where($data);
        $count = $this->db->count_all_results('gz_study_collect');
        return $count;
    }


    /**
     * 收藏本问题
     */
    public function insert_collect($data)
    {
        $this->db->insert('gz_study_collect',$data);
    }

    

    /**
     * 删除操作
     */
    public function delete($data) {
        foreach ($data as $val) {
            $this->db->delete('gz_study_line_answer', array('question_id' => $val));
            $this->db->delete('gz_study_line_question', array('id' => $val));
        }
    }

    /**
     * 获取每个问题的回复时间
     */
    public function get_lasttime($data) {
        $this->db->select('max(atime) as last_time');
        $this->db->group_by('gz_study_line_answer.question_id');
        $info = $this->db->get_where('gz_study_line_answer', $data)->row_array(); 
        return $info;
    }

    /**
     * 获取问题下的所有回答 
     */
    public function get_all_answer($data) {
        $this->db->select('gz_study_line_answer.*,gz_users.name as username');
        $this->db->join('gz_users', 'gz_users.id = gz_study_line_answer.auser_id');
        $list = $this->db->get_where('gz_study_line_answer', $data)->result_array();
        return $list;
    }

    /**
     * 添加常见问题 
     */
    public function faq_insert($data) {
        $attr['reply'] = $data['reply'];
        $attr['auser_id'] = $data['quser_id'];
        unset($data['reply']);
        $this->db->set('qtime', 'NOW()', FALSE);
        $this->db->insert('gz_study_line_question', $data);
        $attr['question_id'] = $this->db->insert_id();
        $this->db->set('atime', 'NOW()', FALSE);
        $this->db->insert('gz_study_line_answer', $attr);
    }

    /**
     * 取消收藏 
     */
    function change_collect($data) {
        foreach ($data as $val) {
            $this->db->update('gz_study_line_question', array('collect' => 'n'), array('id' => $val));
            $this->db->delete('gz_study_collect',array('question_id '=>$val));
        }
    }

    
    /**
     *统计信息 
     */
    
    function stat_info($param,$data)
    {
        $this->db->select('count('.$param.') as num, plan_id,'.$param);
        $this->db->group_by('plan_id ,'.$param);
        $list = $this->db->get_where('gz_study_line_question ',$data)->result_array();
        //echo $this->db->last_query();
        return $list;
    }
    
    /**
     *按照用户来统计 
     */
    
    function stat_user_info($param,$data)
    {
        $this->db->select('count('.$param.') as num,gz_users.name as quser_name ,'.$param);
        $this->db->join('gz_users','gz_users.id = gz_study_line_question.quser_id');
        $this->db->group_by('quser_id ,'.$param);
        $list = $this->db->get_where('gz_study_line_question ',$data)->result_array();
        //echo $this->db->last_query();
        return $list;
    }
    
    /**
     * 取出、显示收藏问题
     */
    function show_collect($data,$limit=10, $offset=0,$orderby='')
    {
        if($orderby)
            $this->db->order_by($orderby);
        $this->db->select('gz_study_line_question.*,gz_users.name as username');
        $this->db->join('gz_users', 'gz_users.id = gz_study_line_question.quser_id');
      //  $this->db->join('gz_study_line_question','gz_study_line_question.id = gz_study_collect.question_id');
        $this->db->join('gz_study_collect','gz_study_collect.question_id = gz_study_line_question.id');
        $list = $this->db->get_where('gz_study_line_question',$data,$limit, $offset)->result_array();
        return $list;
    }
    
    /**
     * 我的问题列表
     */
    
    function my_question_list($data,$limit=10,$offset=0,$orderby='')
    {
        if($orderby)
            $this->db->order_by($orderby);
        $list = $this->db->get_where('gz_study_line_question',$data,$limit,$offset)->result_array();
        return $list;
    }
    
    /**
     * 我的问题数量
     */
    
    function my_question_count($data)
    {
        $this->db->where($data);
        $count = $this->db->count_all_results('gz_study_line_question');
        return $count;
    }
    
    /**
     * 获取章节的名称
     */
    
    function get_zhangjie_name($data)
    {
        $this->db->select('title');
        $info = $this->db->get_where('gz_study_coursecontent')->row_array();
        return $info;
    }
   
}

?>
