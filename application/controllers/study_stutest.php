<?php
include_once '_studyController.php';

class Study_StuTest extends StudyController
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
        $this->load->model('Study_MyTest_Model');
        
    }
    
    function index($start=0)
    {
        //参数的初始化
        $limit=10;
        $where=array();
        $get = $this->input->get();
        $where['`id` >']=0;
        if($get['name'])
            $where['`title` like ']='"%'.$get['name'].'%"';
        $where['course_id'] = $this->course['id'];
        $list  = $this->Study_MyTest_Model->getAll($where,'*','id desc',$limit,$start);//print_r($list);
        foreach ($list as $key=>$val)
        {
            $list[$key]['zice_count'] = $this->Study_MyTest_Model->CountTest('`zice_id` = '.$val['id']);
        }
        $count = $this->Study_MyTest_Model->getCount($where);
        
        $result=array(
            'list' => $list,
            'count'=> $count
        );
        $this->setComponent('test',$result);
        $this->showTemplate('study_base');
    }
    /**
     * 测试
     */
    
    function ceshi($id)
    {
        $info = $this->Study_MyTest_Model->getOne(array('id'=>$id));
        $info['scores']= unserialize($info['scores']);
        $info['shiti'] = unserialize($info['shiti']);
        
        foreach($info['shiti'] as $key=>$val)
        {
            foreach($val as $k=>$v)
            {
               $name = $this->Study_MyTest_Model->get_tixing(array('id'=>$k));
               $list[$key][$name['name']][$k]=  $this->Study_MyTest_Model->get_shiti($key,array('tixing_id'=>$k),$v,'created desc');
            }
        }
        $result=array(
            'list'      => $list,
            'info'      => $info,
            'abc_array' => $this->abc_array
        );            
        $this->setComponent('test_ceshi',$result);
        $this->showTemplate('study_base');
    }
    
    /**
     * 交卷
     */
    
   function jiaojuan($id)
    {
        //参数初始化
        $score=0;
        $shijuan = $this->Study_MyTest_Model->getOne(array('gz_study_mytest.id'=>$id));
        $zongfen =  unserialize($shijuan['scores']);
        $total_score=array_sum($zongfen);
        //print_r($zongfen);
        foreach ($_POST as $key=>$val)
        {
            if($key=='danxuan')
            {
                foreach ($val as $k=>$v)
                {
                    foreach($v as $k_id=>$v_daan)
                    {
                     $list = $this->Study_MyTest_Model->check_answer(array('id'=>$k_id,
                         'tixing_id'=>$k),$key);                 
                     if($list['daan']==$v_daan){
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
                        $list = $this->Study_MyTest_Model->check_answer(array('id'=>$k_id,
                         'tixing_id'=>$k),$key);                                        
                        foreach($v_daan as $k_s=>$v_s)
                        {
                            $daan .=$v_s.',';
                        }
                        $daan = substr($daan, 0,  strlen($daan)-1);
                       
                        if($list['daan']==$daan){
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
                         $list = $this->Study_MyTest_Model->check_answer(array('id'=>$k_id,
                         'tixing_id'=>$k),$key);                 
                        $list['daan'] =  unserialize($list['daan']);
                        foreach ($v_daan as $k_s=>$v_s)
                        {
                            if($list['daan'][$k_s]==$v_s)
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
                        $list = $this->Study_MyTest_Model->check_answer(array('id'=>$k_id,
                         'tixing_id'=>$k),$key);                 
                        $list['daan'] =  unserialize($list['daan']);
                        foreach ($v_daan as $k_s=>$v_s)
                        {
                            if($list['daan'][$k_s]==$v_s)
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
                     $list = $this->Study_MyTest_Model->check_answer(array('id'=>$k_id,
                         'tixing_id'=>$k),$key);                 
                     $list['daan'] =  $list['daan'];
                     if($list['daan']==$v_daan){
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
                         $list = $this->Study_MyTest_Model->check_answer(array('id'=>$k_id,
                         'tixing_id'=>$k),$key);                 
                         $list['daan'] =  unserialize($list['daan']);
                         foreach($v_daan as $k_s =>$v_s)
                         {
                             if($list['daan'][$k_s]==$v_s)
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
                         $list = $this->Study_MyTest_Model->check_answer(array('id'=>$k_id,
                         'tixing_id'=>$k),$key);                 
                            $list['daan'] =  unserialize($list['daan']);
                         foreach($v_daan as $k_s =>$v_s)
                         {
                             if($list['daan'][$k_s]==$v_s)
                             {
                                  $score +=intval(($zongfen[$k])/$count);   //交总分差2分以上，不准确 
                             }
                         }
                     }
                 }
                 
            }
            
            
        } 
        $attr=array(         
            'zongfen'    => $total_score,
            'score'      => $score,
            'zice_id'    => $id,
            'user_id'    => $this->user['id']
        );
        $this->Study_MyTest_Model->add_daan($attr);
        $fenlv=ceil($score/$total_score);
        $msgs = $shijuan['title'].' 正确率： '.$fenlv.'% 再接再厉';
        echo "<script>alert('".$msgs."');</script>";      
        Util::redirect('/study_mytest/index');
    }
}
?>
