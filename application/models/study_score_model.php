<?php
if ( !defined( 'BASEPATH' ) )
  exit( 'No direct script access allowed' );

class Study_Score_Model extends DAO
{
    public function __construct()
    {
        parent::initTable('gz_study_course_class', 'id');
    }
    
    /**
     * 获取已选择的学生
     */
    
    function get_list($data)
    {
       $this->db->select('gz_users.name,gz_users.id');
       $this->db->join('gz_users','gz_users.id=gz_study_class_join_user.user_id');
       $list = $this->db->get_where('gz_study_class_join_user',$data)->result_array();//echo $this->db->last_query();
       return $list;
    }
    
    /**
     * 获取当前课程下的作业
     */
    
    function get_zuoye($data,$limit=10,$offset=0)
    {
        $this->db->select('gz_study_shijuan.*');          
        $list = $this->db->get_where('gz_study_shijuan',$data,$limit,$offset)->result_array();
        return $list;
    }
    
    /**
     * 获取作业的数量
     */
    
    function get_zuoye_count($data)
    {
        $this->db->where($data);
        $count = $this->db->count_all_results('gz_study_shijuan');
        return $count;
    }
    
    /**
     * 获取已选择的作业
     */
     function get_zuoye_list($data)
    {
       $list = $this->db->get_where('gz_study_shijuan',$data)->result_array();
       return $list;
    }
    
    
     /**
     * 获取当前课程下的作品
     */
    
    function get_zuopin($data,$limit=10,$offset=0)
    {
        $this->db->select('gz_study_product.*'); 
        $this->db->join('gz_study_plan','gz_study_plan.id = gz_study_product.plan_id');
        $list = $this->db->get_where('gz_study_product',$data,$limit,$offset)->result_array();
        return $list;
    }
    
    /**
     * 获取作品的数量
     */
    
    function get_zuopin_count($data)
    {
        $this->db->where($data);
        $this->db->join('gz_study_plan','gz_study_plan.id = gz_study_product.plan_id');
        $count = $this->db->count_all_results('gz_study_product');
        return $count;
    }
    
    /**
     * 获取已选择的作品
     */
     function get_zuopin_list($data)
    {
        $this->db->select('gz_study_product.*');
       $this->db->join('gz_study_plan','gz_study_plan.id = gz_study_product.plan_id');
       $list = $this->db->get_where('gz_study_product',$data)->result_array();
       return $list;
    }
    
    /**
     * 查出作业
     */
    function getzuoye($data)
    {
        $this->db->select('id,title');
        $info = $this->db->get_where('gz_study_shijuan',$data)->row_array();
        return $info;
    }
    
    /**
     * 获取成绩
     */
    
    function get_score($data)
    {
        $this->db->select('gz_users.name,gz_study_jiaojuan.shijuan_id,gz_study_jiaojuan.score');
        $this->db->join('gz_study_jiaojuan','gz_study_jiaojuan.user_id = gz_users.id');
        $list = $this->db->get_where('gz_users',$data)->result_array();//echo $this->db->last_query();
        return $list;
    }
    
    /**
     * 查出作品
     * 
     */
    function getzuopin($data)
    {
        $this->db->select('id,name,plan_id,user_id');
        $list = $this->db->get_where('gz_study_product',$data)->row_array();
        return $list;
    }
    
    /**
     * 获取作品考核分值
     */
    
    function get_zuopin_score($data)
    {
        $this->db->select('gz_study_product.id,gz_study_product.name,gz_users.name as user_name');
        $this->db->join('gz_users','gz_users.id = gz_study_product.user_id'); 
        $list = $this->db->get_where('gz_study_product',$data)->row_array();
        return $list;
    }
    
    /**
     * 获取学生
     */
    
    function getStudent($data,$limit=10,$offset=0)
    {
       $this->db->select('gz_users.name,gz_users.id');
       $this->db->join('gz_users','gz_users.id=gz_study_class_join_user.user_id');
       $list = $this->db->get_where('gz_study_class_join_user',$data,$limit,$offset)->result_array();
       return $list;
    }
    /**
     * 获取学生数量
     */
    
    function getStuCount($where)
    {
        $this->db->where($where);
         $this->db->join('gz_users','gz_users.id=gz_study_class_join_user.user_id');
        $count = $this->db->count_all_results('gz_study_class_join_user');
        return $count;
    }
    
    /**
     *以选择的题目查询为条件查询成绩 
     */
    
    
    function get_zuoye_score($data)
    {
        //$this->db->select();
        $list = $this->db->get_where('gz_study_jiaojuan',$data)->result_array();//echo $this->db->last_query();
        return $list;
    }
    
    /**
     *统计题量 
     */
    function get_tiliang($data)
    {
        $this->db->where($data);
        $count = $this->db->count_all_results('gz_study_join_shiti');
        return $count;
    }
    /**
     * 条件查询最高分数
     */
    function get_maxfenshu($data)
    {
        $this->db->select('max(score) as tops');
        $this->db->group_by('shijuan_id');
        $list = $this->db->get_where('gz_study_jiaojuan',$data)->row_array();//echo $this->db->last_query();
        return $list;
    }
   /**
    * 查询最低分数
    */
    
   function get_minfenshu($data)
   {
       $this->db->select('min(score) as low');
       $this->db->group_by('shijuan_id');
       $list = $this->db->get_where('gz_study_jiaojuan',$data)->row_array();
       return $list;
   }
   /**
    * 查询最低分数
    */
    
   function get_avgfenshu($data)
   {
       $this->db->select('avg(score) as pjf');
       $this->db->group_by('shijuan_id');
       $list = $this->db->get_where('gz_study_jiaojuan',$data)->row_array();
       return $list;
   }
   
   /**
    * 查询总分数
    */
    
   function get_totalfenshu($data)
   {
       $this->db->select('sum(score) as total');
       $this->db->group_by('shijuan_id');
       $list = $this->db->get_where('gz_study_jiaojuan',$data)->row_array();
       return $list;
   }
   
   /**
    * 查询优秀的人数
    */
   
   function get_youxiu($data)
   {
       //$this->db->select('count(*) as count');
       $this->db->where($data);
       $this->db->group_by('shijuan_id');
       $count = $this->db->count_all_results('gz_study_jiaojuan');
       //$list = $this->db->get_where('gz_study_jiaojuan',$data)->row_array();//echo $this->db->last_query();    
       return $count;
   }
  
   /**
    * 取得本作业的总人数
    */
   
    function get_youxiu_count($data)
   {
       $this->db->where($data);
       $this->db->group_by('shijuan_id');
       $list = $this->db->count_all_results('gz_study_jiaojuan');//echo $this->db->last_query();    
       return $list;
   }
    /**
     *获取作业的id,name 
     */
    function get_zy($data)
    {
        $this->db->select('id,title');
        $info = $this->db->get_where('gz_study_shijuan',$data)->row_array();
        return $info;
    }
  
}
?>
