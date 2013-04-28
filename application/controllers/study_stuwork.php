<?php
include_once '_studyController.php';

class Study_StuWork extends StudyController
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
        $this->load->model('Study_HomeWork_Model');
        $this->load->model('Study_Course_Model');
        $this->load->model('Study_MyTest_Model');
        $this->load->model('Study_YouXiu_Model');
    }
    
    /**
     * 默认列表
     */
    function index($start=0)
    {
        $limit=10;
        $where=array();
        $get = $this->input->get();
        $where['`id` >']=0;
        if($get['name'])
            $where['`title` like ']='"%'.$get['name'].'%"';
        $list = $this->Study_HomeWork_Model->getAll($where,'*','id desc',$limit,$start);   
        $count = $this->Study_HomeWork_Model->getCount($where);
        //获取当前课程的人数
        $stu_count  = $this->Study_Course_Model->getOne('`id` ='.$this->course['id'],'student_count');
        foreach($list as $key=>$val)
        {
            //获取已提交的数量
            $list[$key]['ceshi_count']= $this->Study_HomeWork_Model->get_tj_count("`shijuan_id` =".$val['id']);
            $list[$key]['stu_count'] = $stu_count;
        }
       
        $config['base_url']   = base_url().'study_homework/index';
        $config['per_page']   = $limit;
        $config['total_rows'] = $count;
        $this->adminpagination->initialize($config);
        $pagination = $this->adminpagination->create_links();
        $result=array(
            'list'       => $list,
            'count'      => $count,
            'pagination' => $pagination
        );
        $this->setComponent( 'study_stuwork' ,$result);
        $this->showTemplate( 'study_base' );
    }
    
    /**
     * 答题
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
             $list = $this->Study_HomeWork_Model->getOne(array('type_id'=>$type_id,'id'=>$id));//print_r($list);
             $list['zhangjie_name'] = $this->Study_HomeWork_Model->get_zhangjie("`id` in (".$list['zhangjie_id'].")");
             
            $this->setComponent('fujian_see',array('list'=>$list));
            $this->showTemplate('study_base');
        }
        else{
            $list = $this->Study_HomeWork_Model->get_shijuan(array('type_id'=>$type_id,'gz_study_shijuan.id'=>$id));
            //print_r($list);
            foreach($list as $key=>$val)
            {
                $name = $this->Study_MyTest_Model->get_tixing(array('id'=>$val['tixing_id']));
                $event[$val['jibenleixing']][$name['name'].'_'.$val['tixing_id']][] = $val;
            }
          $result = array(
              'event'     => $event,
              'info'      => $info,
              'abc_array' =>$this->abc_array
          );         
            $this->setComponent('shiti_test',$result);
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
    
    /**
     *查看作业 
     */
    
    function see_zuoye($type_id,$id)
    {
        //参数初始化
        $event=array();
        $info = $this->Study_HomeWork_Model->getOne(array('id'=>$id));
        $info['scores'] = unserialize($info['scores']);
        if($type_id==3)
        {
             $list = $this->Study_HomeWork_Model->getOne(array('type_id'=>$type_id,'id'=>$id));//print_r($list);
             $list['zhangjie_name'] = $this->Study_HomeWork_Model->get_zhangjie("`id` in (".$list['zhangjie_id'].")");
             //print_r($list);
            $this->setComponent('fujian_see',array('list'=>$list));
            $this->showTemplate('study_base');
        }
        else{
            $list = $this->Study_HomeWork_Model->get_shijuan(array('type_id'=>$type_id,'gz_study_shijuan.id'=>$id));
            
            foreach($list as $key=>$val)
            {
                $name = $this->Study_MyTest_Model->get_tixing(array('id'=>$val['tixing_id']));
                $event[$val['jibenleixing']][$name['name'].'_'.$val['tixing_id']][] = $val;
            }
          $result = array(
              'event'     => $event,
              'info'      => $info,
              'abc_array' =>$this->abc_array
          );         
            $this->setComponent('see_zuoye',$result);
            $this->showTemplate('study_base');
        }
    }
    
    /**
     * 交卷
     */
    
    function jiaojuan($id)
    {
        //参数初始化
        $score=0;
        $shijuan = $this->Study_HomeWork_Model->getOne(array('gz_study_shijuan.id'=>$id));
        $zongfen =  unserialize($shijuan['scores']);
        $total_score=array_sum($zongfen);
        
        foreach ($_POST as $key=>$val)
        {
            if($key=='danxuan')
            {
                foreach ($val as $k=>$v)
                {
                    foreach($v as $k_id=>$v_daan)
                    {
                     $list = $this->Study_HomeWork_Model->get_check(array('gz_study_join_shiti.shiti_id'=>$k_id,
                         'gz_study_join_shiti.tixing_id'=>$k,'gz_study_join_shiti.shijuan_id'=>$id));                 
                     $list['shiti_info'] =  unserialize($list['shiti_info']);
                     if($list['shiti_info']['daan']==$v_daan){
                         $score +=intval(($zongfen[$k])/(count($v)));   //交总分差2分以上，不准确   
                     }
                    }
                }
            }elseif($key=='duoxuan')
            {
                $daan='';
                foreach($val as $k=>$v)
                {
                    foreach($v as $k_id=>$v_daan)
                    {
                        $list = $this->Study_HomeWork_Model->get_check(array('gz_study_join_shiti.shiti_id'=>$k_id,
                         'gz_study_join_shiti.tixing_id'=>$k,'gz_study_join_shiti.shijuan_id'=>$id));                 
                        $list['shiti_info'] =  unserialize($list['shiti_info']);
                       // print_r($v_daan);
                        foreach($v_daan as $k_s=>$v_s)
                        {
                            $daan .=$v_s.',';
                        }
                        $daan = substr($daan, 0,  strlen($daan)-1);
                       
                        if($list['shiti_info']['daan']==$daan){
                         $score +=intval(($zongfen[$k])/(count($v)));   //交总分差2分以上，不准确  
                        }
                        $daan=''; 
                    }
                }
            }elseif($key=='wanxingtiankong')
            {
                $count=0;
                foreach($val as $k=>$v)
                {   
                    foreach($v as $k_id=>$v_daan )
                    {       //计算共有的试题多少个           
                           $count+=count($v_daan);
                    }
                 }
                foreach($val as $k=>$v)
                {
                    foreach($v as $k_id=>$v_daan)
                    {
                         $list = $this->Study_HomeWork_Model->get_check(array('gz_study_join_shiti.shiti_id'=>$k_id,
                         'gz_study_join_shiti.tixing_id'=>$k,'gz_study_join_shiti.shijuan_id'=>$id));                 
                        $list['shiti_info'] =  unserialize($list['shiti_info']);
                        foreach ($v_daan as $k_s=>$v_s)
                        {
                            if($list['shiti_info']['daan'][$k_s]==$v_s)
                            {
                                $score +=intval(($zongfen[$k])/$count); 
                            }
                        }
                    }
                }
            }elseif($key=='tiankong')
            {
                $count=0;
                foreach($val as $k=>$v)
                {   
                    foreach($v as $k_id=>$v_daan )
                    {       //计算共有的试题多少个           
                           $count+=count($v_daan);
                    }
                 }
                foreach($val as $k=>$v)
                {                    
                    foreach($v as $k_id=>$v_daan)
                    {
                        $list = $this->Study_HomeWork_Model->get_check(array('gz_study_join_shiti.shiti_id'=>$k_id,
                         'gz_study_join_shiti.tixing_id'=>$k,'gz_study_join_shiti.shijuan_id'=>$id));                 
                        $list['shiti_info'] =  unserialize($list['shiti_info']);
                        foreach ($v_daan as $k_s=>$v_s)
                        {
                            if($list['shiti_info']['daan'][$k_s]==$v_s)
                            {
                                $score +=intval(($zongfen[$k])/$count); 
                            }
                        }
                    }
                }
            }elseif($key=='wenda')
            {
                 foreach ($val as $k=>$v)
                {
                    foreach($v as $k_id=>$v_daan)
                    {
                     $list = $this->Study_HomeWork_Model->get_check(array('gz_study_join_shiti.shiti_id'=>$k_id,
                         'gz_study_join_shiti.tixing_id'=>$k,'gz_study_join_shiti.shijuan_id'=>$id));                 
                     $list['shiti_info'] =  unserialize($list['shiti_info']);
                     if($list['shiti_info']['daan']==$v_daan){
                         $score +=intval(($zongfen[$k])/(count($v)));   //交总分差2分以上，不准确   
                     }
                    }
                }
            }elseif($key=='yuedulijie')
            {
                $count=0;
                foreach($val as $k=>$v)
                {   
                    foreach($v as $k_id=>$v_daan )
                    {       //计算共有的试题多少个           
                           $count+=count($v_daan);
                    }
                 }
                 foreach($val as $k=>$v)
                 {
                     foreach($v as $k_id=>$v_daan)
                     {
                         $list = $this->Study_HomeWork_Model->get_check(array('gz_study_join_shiti.shiti_id'=>$k_id,
                         'gz_study_join_shiti.tixing_id'=>$k,'gz_study_join_shiti.shijuan_id'=>$id));                 
                     $list['shiti_info'] =  unserialize($list['shiti_info']);
                         foreach($v_daan as $k_s =>$v_s)
                         {
                             if($list['shiti_info']['daan'][$k_s]==$v_s)
                             {
                                  $score +=intval(($zongfen[$k])/$count);   //交总分差2分以上，不准确 
                             }
                         }
                     }
                 }
            }elseif($key=='pipei')
            {
                $count=0;
                foreach($val as $k=>$v)
                {   
                    foreach($v as $k_id=>$v_daan )
                    {       //计算共有的试题多少个           
                           $count+=count($v_daan);
                    }
                 }
                 
                 foreach($val as $k=>$v)
                 {
                     foreach($v as $k_id=>$v_daan)
                     {
                         $list = $this->Study_HomeWork_Model->get_check(array('gz_study_join_shiti.shiti_id'=>$k_id,
                         'gz_study_join_shiti.tixing_id'=>$k,'gz_study_join_shiti.shijuan_id'=>$id));                 
                     $list['shiti_info'] =  unserialize($list['shiti_info']);
                         foreach($v_daan as $k_s =>$v_s)
                         {
                             if($list['shiti_info']['daan'][$k_s]==$v_s)
                             {
                                  $score +=intval(($zongfen[$k])/$count);   //交总分差2分以上，不准确 
                             }
                         }
                     }
                 }
                 
            }   
        } 
        $attr=array(
            'user_id'    => $this->user['id'],
            'daan'       => serialize($_POST),
            'score'      => $score,
            'pingyu'     => '',
            'pingfen'    => 0,
            'status'     => 'n',
            'good_work'    => 'n',       
            'shijuan_id' => $id
        );
        $this->Study_HomeWork_Model->add_daan($attr);      
        Util::redirect('/study_homework/index');
    }
    
    /**
     *$type_id 作业类型
     *$id     作业ID  
     * 查看我的试题
     */
    
    function test_chakan($type_id,$id)
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
            $answers=array();
            if(isset($answer['daan'])){
              $answers = unserialize($answer['daan']);
                }
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
    
    /**
     * 附件答案
     */
    
    function answer($id)
    {
        if($_POST)
        {
            $info = $this->Study_HomeWork_Model->answer(array('shijuan_id'=>$id,'user_id'=>$this->user['id']));
            if(empty($info))
            {
                $this->Study_HomeWork_Model->insert_answer(array('shijuan_id'=>$id,'user_id'=>$this->user['id'],'daan'=>$_POST['param'],'pingyu'=>'',
                    'pingfen'=>'','score'=>0,'good_work'=>'n','status'=>'n','created'=>date('Y-m-d H:i:s',mktime())));
                Util::redirect('study_stuwork/index');
            }else{
                $this->Study_HomeWork_Model->update_answer($_POST['param'],array('shijuan_id'=>$id,'user_id'=>$this->user['id']));
                 Util::redirect('study_stuwork/index');
            }
        }
    }
}
?>
