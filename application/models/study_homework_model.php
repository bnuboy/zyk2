<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Study_HomeWork_Model extends DAO
{

    public function __construct()
    {   
         parent::initTable('gz_study_shijuan', 'id');
    }
    
    /**
     * 获取题型
     */
    
    function get_tixing($dbname,$data)
    {
        $this->db->select($dbname.'.zsd_id,gz_study_pattern.name as tixing_name,gz_study_pattern.id as tixing_id,gz_study_coursecontent.title as zsd_name');
        $this->db->join('gz_study_coursecontent','gz_study_coursecontent.id = '.$dbname.'.zsd_id');
        $this->db->join('gz_study_pattern','gz_study_pattern.id = '.$dbname.'.tixing_id');
        $this->db->group_by(array($dbname.'.tixing_id',$dbname.'.zsd_id'));
        $list = $this->db->get_where($dbname,$data)->result_array();         
        return $list;
    }
    /**
     * 获取试题数量
     */

    function get_shiti_count($dbname,$data,$param)
    {
        $this->db->where($data);
        $this->db->group_by($param);
        $count = $this->db->count_all_results('gz_study_shiti_'.$dbname);
        return $count;
    }
    /**
     * 获取试题总数
     */
    function get_shiti_sum($dbname,$data)
    {
        $this->db->where($data);
        $this->db->group_by('tixing_id');
        $sum = $this->db->count_all_results('gz_study_shiti_'.$dbname);
        return $sum;
    }
    /**
     *选择试题 
     */
    function select_shiti($dbname,$data)
    {
        $list = $this->db->get_where('gz_study_shiti_'.$dbname,$data)->result_array();
        return $list;
    }
    /**
     * 添加试卷
     */
    function add_shijuan($data,$data2)            
    {
      
        $attr = array(
            'title'         => $data['title'],
            'type_id'       => $data['type_id'],
            'scores'        => serialize($data['scores']),
            'score'         => $data['score'],
            'start_time'    => $data['start_time'],
            'end_time'      => $data['end_time'],
            'content'       => $data['content'],
            'zhangjie_id'   => $data['zhangjie'],
            'course_id'     => $data['course_id'],
            'param'         =>''
        );
        unset($data['title']);
        unset($data['type_id']);
        unset($data['score']);
        unset($data['scores']);
        unset($data['start_time']);
        unset($data['end_time']);
        unset($data['content']);     
        unset($data['zhangjie']);
       
        foreach ($data as $val)
        {
           $attr['shiti'] = serialize( $val); 
        }       
        $this->db->insert('gz_study_shijuan',$attr);
        $insert_id = $this->db->insert_id();
        foreach ($data2 as $key=>$val)
        {
            $attr=  explode('_', $key);
            foreach($val as $k=>$v)
            {
                $arr = array(
                    'shijuan_id'  => $insert_id,
                    'tixing_id'   => $attr['0'],
                    'jibenleixing'=>$attr[1],
                    'shiti_id'    => $v['id'],
                    'shiti_info'  => serialize($v)
                );
                $this->db->insert('gz_study_join_shiti',$arr);
            }
        }
        
    }
    /**
     * 获取试题信息
     */
    function getShitiInfo($data){
        $this->db->select('gz_study_shijuan.*,');
        $this->db->join('gz_study_join_shiti','gz_study_join_shiti.shijuan_id = gz_study_shijuan.id');
        $info = $this->db->get_where('gz_study_shijuan',$data)->row_array();
        return $info;
    }
    
    /**
     *自动选择试题 
     */
    function zidong_select_shiti($dbname,$data,$limit=0,$order='')
    {
        if($limit)
            $this->db->limit($limit);
        if($order)
            $this->db->order_by($order);
        $list = $this->db->get_where('gz_study_shiti_'.$dbname,$data)->result_array();
        return $list;
    }
    
    /**
     * 自动作业类型添加数据
     */
    
    function zidong_insert($data,$data1)
    {
         $attr = array(
            'title'      => $data['title'],
            'type_id'    => $data['type_id'],
            'scores'     => serialize($data['scores']),
            'score'      => $data['score'],
            'start_time' => $data['start_time'],
            'end_time'   => $data['end_time'],
            'content'    => $data['content'],
            'zhangjie_id'=> $data['zhangjie'],
            'course_id'  => $data['course_id'],
            'shiti'      => '',
            'param'      => ''
        );
        $this->db->insert('gz_study_shijuan',$attr);
        $insert_id = $this->db->insert_id();
        foreach ($data1 as $key=>$val)
        {
            foreach($val as $k=>$v)
            {
                foreach ($v as $ks=>$vl)
                {
                    if($key=='danxuan'){
                        $vl['xx'] = unserialize($vl['xx']);
                    }
                    if($key=='duoxuan'){
                        $vl['xx'] = unserialize($vl['xx']);
                    }
                    if($key=='tiankong'){
                        $vl['title'] = unserialize($vl['title']);
                        $vl['daan']  = unserialize($vl['daan']);
                    }if($key=='wanxingtiankong'){
                        $vl['title'] = unserialize($vl['title']);
                        $vl['daan']  = unserialize($vl['daan']);
                        $vl['timu']  = unserialize($vl['timu']);
                    }
                    if($key=='pipei'){
                        $vl['xuanxiang'] = unserialize($vl['xuanxiang']);
                        $vl['timu']      = unserialize($vl['timu']);
                        $vl['daan']      = unserialize($vl['daan']);
                    }
                    if($key=='yuedulijie'){
                        $vl['xuanxiang'] = unserialize($vl['xuanxiang']);
                        $vl['timu']      = unserialize($vl['timu']);
                        $vl['daan']      = unserialize($vl['daan']);
                    }  
                    $arr = array(
                    'shijuan_id'  => $insert_id,
                    'tixing_id'   => $k,
                    'jibenleixing'=> $key,
                    'shiti_id'    => $vl['id'],
                    'shiti_info'  => serialize($vl)
                    );
                    $this->db->insert('gz_study_join_shiti',$arr);
                }
            }
        }
    }
    /**
     * 附件作业
     */
    function fujian_insert($data)
    {
         $attr = array(
            'title'      => $data['title'],
            'type_id'    => $data['type_id'],
            'scores'     => '',
            'score'      => $data['score'],
            'start_time' => $data['start_time'],
            'end_time'   => $data['end_time'],
            'content'    => $data['content'],
            'zhangjie_id'=> $data['zhangjie'],
            'course_id'  => $data['course_id'],
            'shiti'      => '',
             'param'     => $data['param']
        );
        $this->db->insert('gz_study_shijuan',$attr);
    }
    
    /**
     * 获取试卷
     */
    function get_shijuan($data)
    {
        $this->db->select('gz_study_shijuan.title,gz_study_join_shiti.*');
        $this->db->join('gz_study_join_shiti','gz_study_join_shiti.shijuan_id = gz_study_shijuan.id');
        $list = $this->db->get_where('gz_study_shijuan',$data)->result_array();
       // echo $this->db->last_query();
        return $list;
    }
    
    /**
     * 核对答案
     */
    function get_check($data)
    {
        //$this->db->select('gz_study_shijuan.*,gz_study_join_shiti.shiti_info');
        //$this->db->join('gz_study_join_shiti','gz_study_join_shiti.shijuan_id = gz_study_shijuan.id');
        $list = $this->db->get_where('gz_study_join_shiti',$data)->row_array();//echo $this->db->last_query();
        return $list;
    }
    
    /**
     * 添加答案
     */
    
    function add_daan($data)
    {
        $this->db->set('created','NOW()',FALSE);
        $this->db->insert('gz_study_jiaojuan',$data);
    }

    /**
     *批阅作业列表 
     */
    function piyue($data=array(),$limit=10,$offset=0)
    {
        $this->db->select('gz_users.name as username,gz_study_jiaojuan.*');
        $this->db->join('gz_users','gz_users.id = gz_study_jiaojuan.user_id');
        $list = $this->db->get_where('gz_study_jiaojuan',$data,$limit,$offset)->result_array();
        return $list;
    }
    /**
     *批阅作业数量
     * @param type $data
     * @return type 
     */
    function piyue_count($data)
    {
        $this->db->where($data);
        $count = $this->db->count_all_results('gz_study_jiaojuan');
        return $count;
    }
    
    /**
     * 更新作业状态
     */
    
    function update_zuoye($data,$where)
    {
        $this->db->update('gz_study_jiaojuan',$data,$where);
    }
    /**
     * 得到作业
     */
    
    function get_zuoye($data)
    {
        $this->db->select('gz_study_shijuan.*,gz_study_jiaojuan.id as jz_id,gz_study_jiaojuan.pingyu,gz_study_jiaojuan.pingfen,gz_study_jiaojuan.good_work');
        $this->db->join('gz_study_jiaojuan','gz_study_jiaojuan.shijuan_id = gz_study_shijuan.id ');
        $list = $this->db->get_where('gz_study_shijuan',$data)->row_array();
        return $list;
    }
    /**
     *获取章节的名称
     * @param type $data
     * @return type 
     */
    function get_zhangjie_name($data)
    {
        $this->db->select('title');
        $list = $this->db->get_where('gz_study_plan',$data)->result_array();
        return $list;
    }
    
    /**
     * 更新批阅
     */
    
    function update_jiaojuan($data,$where)
    {
        $this->db->update('gz_study_jiaojuan',$data,$where);
    }


    /*
     * 查询作业记录
     */

    function selectHomeworkLog($where = '`id` > 0', $select = '*', $orderby = '`id` DESC', $limit = '', $offset = ''){
         $rows = array();
         $this->db->select( $select );
         $this->db->join('gz_study_shijuan','gz_study_jiaojuan.shijuan_id = gz_study_shijuan.id');
         $this->db->order_by( $orderby );
         $this->db->where( $where, NULL, FALSE );
         if ( !empty( $limit ) ){
                $query = $this->db->get( "gz_study_jiaojuan", $limit, $offset );
            }else{
                $query = $this->db->get( "gz_study_jiaojuan");
            }
         foreach ( $query->result_array() as $row ){
                $rows[ ] = $row;
            }
         return $rows;
    }

    /*
     * 计算作业记录
     */
    function CountHomeworkLog($where){
        if(!empty($where)) $this->db->where( $where, NULL, FALSE );
        $query = $this->db->get( "gz_study_jiaojuan" );
        $count = $query->num_rows();
        return $count;
    }
    /**
     * 取得已提交作业的数量
     */
    function get_tj_count($data)
    {
        $this->db->where($data);
        $count = $this->db->count_all_results('gz_study_jiaojuan');
        return $count;
    }
    /**
     * 获取章节名称
     */
    
    function get_zhangjie($data)
    {
        $this->db->select('title');
        $list = $this->db->get_where('gz_study_coursecontent',$data)->result_array();
        return $list;
    }

	 /**
     * 作业试题统计
     */
    
    function get_tongji($data,$limit=10,$offset=0)
    {
        $this->db->select('gz_users.name as username,gz_users.login_name as login_name,gz_study_jiaojuan.score,max(gz_study_jiaojuan.created) as created');
        $this->db->join('gz_study_jiaojuan','gz_study_jiaojuan.user_id = gz_users.id','left');
        $this->db->group_by('gz_study_jiaojuan.user_id');       
        $list = $this->db->get_where('gz_users',$data,$limit,$offset)->result_array();   
        return $list;
    }
    
    function get_tongji_count($where)
    {
        $this->db->select('count(DISTINCT gz_study_jiaojuan.user_id) as num');
        $this->db->join('gz_users','gz_users.id = gz_study_jiaojuan.user_id ');   
        $this->db->where($where);
        $list = $this->db->get('gz_study_jiaojuan')->row();
        return $list->num;
    }
    /**
     * 查询附件作业答案
     */
    function answer($data)
    {
        $row = $this->db->get_where('gz_study_jiaojuan',$where)->row_array();
        return $row;
    }
    /**
     * 添加附件答案
     */
    function insert_answer($data)
    {
        $this->db->insert('gz_study_jiaojuan',$data);
        return $this->db->insert_id();
    }
    /**
     * 更新附件答案
     */
    function update_answer( $data, $where )
    {
        $this->db->update('gz_study_jiaojuan',$data,$where);
    }
}
?>
