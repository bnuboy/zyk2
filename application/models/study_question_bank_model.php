<?php
if ( !defined( 'BASEPATH' ) )
  exit( 'No direct script access allowed' );

class Study_Question_Bank_Model extends DAO
{
    function __construct()
    {
        parent::__construct();
        parent::initTable('', 'id');
    }
    /**
     *根据条件获取题型
     * @param type $data 
     */
    function get_pattern($data)
    {
        $this->db->get_where('gz_study_patterntype',$data)->result();
    }
    /**
     * 存储单选内容
     */
    
    function danxuan_insert($data)
    {
        $attr = array(
            'title'     =>$data['title'],
            'xx'        =>$data['subject_id'],
            'tixing_id' =>$data['pattern_id'],
            'daan'      =>$data['daan'],
            'zsd_id'    =>$data['zsd'],
            'harder'    =>$data['harder'],
            'jieda'     =>$data['jieda']
        );
        $this->db->set('created','NOW()',FALSE);
        $this->db->insert('gz_study_shiti_danxuan',$attr);
        return $this->db->insert_id();
    }
    
    /**
     * 存储多选内容
     */
    
    function duoxuan_insert($data)
    {
        $attr = array(
            'title' =>$data['title'],
            'xx'    =>$data['subject_id'],
            'tixing_id' =>$data['pattern_id'],
            'daan'  =>$data['answer'],
            'zsd_id'=>$data['zsd'],
            'harder'=>$data['harder'],
            'jieda' =>$data['jieda']
        );
        $this->db->set('created','NOW()',FALSE);
        $this->db->insert('gz_study_shiti_duoxuan',$attr);
        return $this->db->insert_id();
    }
     /**
     * 存储多选内容
     */
    
    function wenda_insert($data)
    {
        $attr = array(
            'title'     => $data['title'], 
            'tixing_id' => $data['pattern_id'],
            'daan'      => $data['daan'],
            'zsd_id'    => $data['zsd'],
            'harder'    => $data['harder'],
            'jieda'     => $data['jieda']
        );
        $this->db->set('created','NOW()',FALSE);
        $this->db->insert('gz_study_shiti_wenda',$attr);
        return $this->db->insert_id();
    }
    /**
     * 存储填空题
     */
    
    function tiankong_insert($data)
    {
       
        $attr = array(
            'title'     => $data['title'],  
            'tixing_id' => $data['pattern_id'],
            'daan'      => $data['daan'],
            'zsd_id'    => $data['zsd'],
            'harder'    => $data['harder'],
            'jieda'     => $data['jieda']
        );
        $this->db->set('created','NOW()',FALSE);
        $this->db->insert('gz_study_shiti_tiankong',$attr);
        return $this->db->insert_id();
    }
    /**
     * 存储完型填空
     */
    
    function wanxingtiankong_insert($data)
    {
        $attr = array(
            'title'     => $data['title'],  
            'tixing_id' => $data['pattern_id'],
            'daan'      => $data['daan'],
            'zsd_id'    => $data['zsd'],
            'timu'      => $data['timu'],
            'harder'    => $data['harder'],
            'jieda'     => $data['jieda']
        );
        $this->db->set('created','NOW()',FALSE);
        $this->db->insert('gz_study_shiti_wanxingtiankong',$attr);
        return $this->db->insert_id();
    }
    
    /**
     * 存储匹配题
     */
    
    function pipei_insert($data)
    {
        $attr = array(
            'title'     => $data['title'],  
            'tixing_id' => $data['pattern_id'],
            'daan'      => $data['daan'],
            'zsd_id'    => $data['zsd'],
            'timu'      => $data['timu'],
            'xuanxiang' => $data['xuanxiang'],
            'harder'    => $data['harder'],
            'jieda'     => $data['jieda']
        );
        $this->db->set('created','NOW()',FALSE);
        $this->db->insert('gz_study_shiti_pipei',$attr);
        return $this->db->insert_id();
    }
    /**
     * 存储阅读理解
     */
    
    function yuedulijie_insert($data)
    {
        $attr = array(
            'title'     => $data['title'],  
            'tixing_id' => $data['pattern_id'],
            'daan'      => $data['answer'],
            'zsd_id'    => $data['zsd'],
            'timu'      => $data['tigan'],
            'xuanxiang' => $data['daan'],
            'harder'    => $data['harder'],
            'jieda'     => $data['jieda']
        );
        $this->db->set('created','NOW()',FALSE);
        $this->db->insert('gz_study_shiti_yuedulijie',$attr);
        return $this->db->insert_id();
    }
    
    /**
     * 查询题库、类型
     */
    function get_info($data)
    {
        $this->db->select('gz_study_pattern.id,gz_study_patterntype.name,gz_study_patterntype.id as patterntype_id');
        $this->db->join('gz_study_patterntype','gz_study_patterntype.id = gz_study_pattern.patternType_id');
        $list = $this->db->get_where('gz_study_pattern',$data)->result_array();
        return $list;
    }
    /**
     * 获取试题
     */
    
    function get_shiti($where,$limit=10,$offset=0,$dbname)
    {
        
        $list = $this->db->get_where($dbname,$where,$limit,$offset)->result_array();   
        //echo $this->db->last_query();
        return $list;
    }
    /**
     * 获取单选题信息
     */
    function get_danxuan_info($data)
    {
        $info = $this->db->get_where('gz_study_shiti_danxuan',$data)->row_array();
        return $info;
    }
    
    /**
     *获取多选题信息
     */
    function get_duoxuan_info($data)
    {
        $info = $this->db->get_where('gz_study_shiti_duoxuan',$data)->row_array();
        return $info;
    }
    /**
     *获取问答题 
     */
    function get_wenda_info($data)
    {
         $info = $this->db->get_where('gz_study_shiti_wenda',$data)->row_array();
        return $info;
    }
     /**
     *获取完型填空答题 
     */
    function get_wanxingtiankong_info($data)
    {
         $info = $this->db->get_where('gz_study_shiti_wanxingtiankong',$data)->row_array();
        return $info;
    }
    /**
     *获取填空题信息 
     */
    function get_tiankong_info($data)
    {
        $info = $this->db->get_where('gz_study_shiti_tiankong',$data)->row_array();
        return $info;
    }
    /**
     *获取填空题信息 
     */
    function get_yuedulijie_info($data)
    {
        $info = $this->db->get_where('gz_study_shiti_yuedulijie',$data)->row_array();
        return $info;
    }
    /**
     * 获取匹配题信息
     */
    function get_pipei_info($data)
    {
        $info = $this->db->get_where('gz_study_shiti_pipei',$data)->row_array();
        return $info;
    }
    /**
     *更新单选试题 
     */
    function update_danxuan($data,$data1)
    {
         $attr = array(
            'title'     =>$data['title'],
            'xx'        =>$data['subject_id'],
            'tixing_id' =>$data['pattern_id'],
            'daan'      =>$data['daan'],
            'zsd_id'    =>$data['zsd'],
            'harder'    =>$data['harder'],
            'jieda'     =>$data['jieda']
        );
        $this->db->update('gz_study_shiti_danxuan',$attr,$data1);
    }
    /**
     *更新多选 
     */
    function update_duoxuan($data,$data1)
    {
        $attr = array(
            'title'     =>$data['title'],
            'xx'        =>$data['subject_id'],
            'tixing_id' =>$data['pattern_id'],
            'daan'      =>$data['answer'],
            'zsd_id'    =>$data['zsd'],
            'harder'    =>$data['harder'],
            'jieda'     =>$data['jieda']
        );
        $this->db->update('gz_study_shiti_duoxuan',$attr,$data1);
    }
    /**
     *更新填空题 
     */
    function update_tiankong($data,$data1)
    {
        $attr = array(
            'title'     => $data['title'],  
            'tixing_id' => $data['pattern_id'],
            'daan'      => $data['daan'],
            'zsd_id'    => $data['zsd'],
            'harder'    => $data['harder'],
            'jieda'     => $data['jieda']
        );
        $this->db->update('gz_study_shiti_tiankong',$attr,$data1);
    }
    /**
     *更新问答题 
     */
    function update_wenda($data,$data1)
    {
        $attr = array(
            'title'     => $data['title'], 
            'tixing_id' => $data['pattern_id'],
            'daan'      => $data['daan'],
            'zsd_id'    => $data['zsd'],
            'harder'    => $data['harder'],
            'jieda'     => $data['jieda']
        );
        $this->db->update('gz_study_shiti_wenda',$attr,$data1);
    }
    /**
     *更新完型填空 
     */
    function update_wanxingtiankong($data,$data1)
    {
        $attr = array(
            'title'     => $data['title'],  
            'tixing_id' => $data['pattern_id'],
            'daan'      => $data['daan'],
            'zsd_id'    => $data['zsd'],
            'timu'      => $data['timu'],
            'harder'    => $data['harder'],
            'jieda'     => $data['jieda']
        );
         $this->db->update('gz_study_shiti_wanxingtiankong',$attr,$data1);
    }
    /**
     *更新阅读理解 
     */
    function update_yuedulijie($data,$data1)
    {
        $attr = array(
            'title'     => $data['title'],  
            'tixing_id' => $data['pattern_id'],
            'daan'      => $data['answer'],
            'zsd_id'    => $data['zsd'],
            'timu'      => $data['tigan'],
            'xuanxiang' => $data['daan'],
            'harder'    => $data['harder'],
            'jieda'     => $data['jieda']
        );
        $this->db->update('gz_study_shiti_yuedulijie',$attr,$data1);
    }
    /**
     *更新匹配题 
     */
    function update_pipei($data,$data1)
    {
        $attr = array(
            'title'     => $data['title'],  
            'tixing_id' => $data['pattern_id'],
            'daan'      => $data['daan'],
            'zsd_id'    => $data['zsd'],
            'timu'      => $data['timu'],
            'xuanxiang' => $data['xuanxiang'],
            'harder'    => $data['harder'],
            'jieda'     => $data['jieda']
        );
        $this->db->update('gz_study_shiti_pipei',$attr,$data1);
    }
    
    /**
     *删除题目 
     */
    function timu_delete($type,$attr)
    {
        $this->db->trans_start();
        foreach($attr as $val)
        {
            $this->db->delete('gz_study_shiti_'.$type,array('id'=>$val));
        }
        $this->db->trans_complete();
        if($this->db->trans_status() ==FALSE)
        {
            throw Exception('have wrong!');
        }
    }
}
?>
