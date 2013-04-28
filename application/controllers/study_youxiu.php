<?php
include_once '_studyController.php';


class Study_YouXiu extends StudyController
{
    public $abc_array = Array(
        'A', 'B', 'C', 'D', 'F',
        'G', 'H', 'I', 'J', 'K', 
        'L', 'M', 'N', 'O', 'P', 
        'Q', 'R', 'S', 'T', 'U', 
        'V', 'W', 'X', 'Y', 'Z'
     );
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Study_YouXiu_Model');
        $this->load->model('Study_HomeWork_Model');
        $this->load->model('Study_MyTest_Model');
        $this->load->library('adminpagination');
    }
    
    /**
     * 默认列表
     */
    
    function index($start=0)
    {
        $limit=10;
        $where='';
        $get = $this->input->get();
        $where = '`gz_study_jiaojuan`.`user_id` = '.  $this->user['id']." and `good_work` = 'y'";
        $where .= ' and `gz_study_shijuan`.`course_id` ='.$this->course['id'];
        if($get['name'])
            $where .=" and `gz_study_shijuan`.`title` like '%".$get['name']."%'";
        $list = $this->Study_YouXiu_Model->get_list($where,'*','`gz_study_jiaojuan`.`id` desc',$limit,$start);
        $count = $this->Study_YouXiu_Model->get_count($where);
        $result = array(
            'list' => $list,
            'count' => $count
        );
        $this->setComponent('youxiu_list',$result);
        $this->showTemplate('study_base');
    }
    
     /**
     *$type_id 作业类型
     *$id     作业ID  
     * 查看我的试题
     */
    
    function test($type_id,$id)
    {
       //参数初始化
        $event=array();
        $info = $this->Study_HomeWork_Model->getOne(array('id'=>$id));
        $info['scores'] = unserialize($info['scores']);
        if($type_id==3)
        {
            $list = $this->Study_HomeWork_Model->getOne(array('type_id'=>$type_id,'id'=>$id));
            $list['zhangjie_name'] = $this->Study_HomeWork_Model->get_zhangjie("`id` in (".$list['zhangjie_id'].")");
            $this->setComponent('fujian_see',array('list'=>$list));
            $this->showTemplate('study_base');
        }
        else{           
            $list = $this->Study_HomeWork_Model->get_shijuan(array('type_id'=>$type_id,'gz_study_shijuan.id'=>$id));
            $answer = $this->Study_YouXiu_Model->get_answer(array('shijuan_id'=>$id));
            $answers = unserialize($answer['daan']);
            foreach($list as $key=>$val)
            {
                $name = $this->Study_MyTest_Model->get_tixing(array('id'=>$val['tixing_id']));
                $event[$val['jibenleixing']][$name['name'].'_'.$val['tixing_id']][] = $val;
            }
          $result = array(
              'event'     => $event,
              'info'      => $info,
              'answer'    => $answers,
              'pingjia'   => $answer,
              'abc_array' =>$this->abc_array
          );        
            $this->setComponent('seework',$result);
            $this->showTemplate('study_base');
        }
    }
    
    /*
     * 下载文件
     */

    function uploadfile($id){
        $this->load->helper('download');
       
        $this->load->library('zip');
        //获取要下载的文件夹或文件
        $file=$this->Study_HomeWork_Model->getOne('`id` = '.$id);
        $name = substr($file['param'],  strrpos($file['param'], '/')+1,  strlen($file['param']));
        //echo $name;die();
        $data = file_get_contents('.'.$file['param']);
           //$this->Study_Teachinfo_Model->update_down(array(),'`id` = '.$file['id']);
           force_download($name, $data);
    }
}
?>
