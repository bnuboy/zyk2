<?php
include_once '_studyController.php';

class Study_MyTest extends StudyController
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
        $this->load->model('Study_HomeWork_Model');   
        $this->load->model('Study_Coursecontent_Model');
        $this->load->library('adminpagination');
    }
    
    /**
     * 默认列表
     */
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
        $list  = $this->Study_MyTest_Model->getAll($where,'*','id desc',$limit,$start);
        $count = $this->Study_MyTest_Model->getCount($where);
        
        $result=array(
            'list' => $list,
            'count'=> $count
        );
        $this->setComponent('mytest',$result);
        $this->showTemplate('study_base');
    }
    
    /**
     * 添加自测
     */
    function add()
    {
        if($_POST)
        {
            $post =array(
                'title'         => $_POST['title'],
                'start_time'    => $_POST['start_time'],
                'end_time'      => $_POST['end_time'],
                'content'       => $_POST['content'],
                'scores'        => serialize($_POST['scores']),
                'score'         => $_POST['score'],
                'zhangjie_id'   => $_POST['zhangjie'],
                'course_id'     => $this->course['id']
            );   
            unset($_POST['title']);
            unset($_POST['start_time']);
            unset($_POST['end_time']);
            unset($_POST['content']);
            unset($_POST['scores']);   
            unset($_POST['score']);
            unset($_POST['zhangjie']); 
            //array_sum($v) 为本题库类型下选择的试题数量
            foreach ($_POST as $key=>$val)
            {
                foreach ($val as $k=>$v)
                {
                    $_POST[$key][$k]=array_sum($v);
                }
            }
                $post['shiti']=serialize($_POST);  
              
                $this->Study_MyTest_Model->insert($post);
                Util::redirect('/study_mytest/index');
         }
         else
        {
             $list = $this->Study_Coursecontent_Model->getTreeCourses("`course_id` = ".$this->course['id']);
            $this->setComponent('mytest_add',array('list'=>$list));
            $this->showTemplate('study_base');
        }
        
    }
    
    /**
     * 筛选
     */
    function zhangjie_type()
    {
        $post = $this->input->post();
        //unset($post['zhangjie']);
     
        $list['danxuan']['info']         = $this->Study_HomeWork_Model->get_tixing('gz_study_shiti_danxuan','zsd_id in('.$post['zhangjie'].')');
        $list['duoxuan']['info']         = $this->Study_HomeWork_Model->get_tixing('gz_study_shiti_duoxuan','zsd_id in('.$post['zhangjie'].')');
        $list['tiankong']['info']        = $this->Study_HomeWork_Model->get_tixing('gz_study_shiti_tiankong','zsd_id in('.$post['zhangjie'].')');
        $list['wanxingtiankong']['info'] = $this->Study_HomeWork_Model->get_tixing('gz_study_shiti_wanxingtiankong','zsd_id in('.$post['zhangjie'].')');
        $list['pipei']['info']           = $this->Study_HomeWork_Model->get_tixing('gz_study_shiti_pipei','zsd_id in('.$post['zhangjie'].')');
        $list['wenda']['info']           = $this->Study_HomeWork_Model->get_tixing('gz_study_shiti_wenda','zsd_id in('.$post['zhangjie'].')');
        $list['yuedulijie']['info']      = $this->Study_HomeWork_Model->get_tixing('gz_study_shiti_yuedulijie','zsd_id in('.$post['zhangjie'].')');
       
          $events=array();
          foreach($list as $key=>$val)
          {
              if(!empty($val['info']))
              {
                  foreach($val['info'] as $k=>$v)
                  {
                      $events[$key][$v['tixing_name']]['tixing_id']=$v['tixing_id'];
                      $events[$key][$v['tixing_name']]['zsd'][$k]['name']=$v['zsd_name'];
                      $events[$key][$v['tixing_name']]['zsd'][$k]['zsd_id']=$v['zsd_id'];                  
                  }
              }
          }
        
          foreach($events as $key=>$val)
          {
            if(!empty($val))
            {                  
                foreach ($val as $k=>$v)
                {
                    foreach($v['zsd'] as $ks=>$vl){
                     $events[$key][$k]['zsd'][$ks]['count'] = $this->Study_HomeWork_Model->get_shiti_count($key,array('zsd_id'=>$vl['zsd_id'],'tixing_id'=>$v['tixing_id']),'zsd_id');
                     $events[$key][$k]['sum'] =$this->Study_HomeWork_Model->get_shiti_sum($key,array('tixing_id'=>$v['tixing_id']));
                    }
                }
            }
          }    
        $result = array(
            'list'      => $events,
            'post_val'  => $post
        );
        $this->setComponent('selectshiti',$result);
        $this->showTemplate('study_base');
    }
    
    /**
     * 查看
     */
    
    function get_look($id)
    {
        $info = $this->Study_MyTest_Model->getOne(array('id'=>$id));
        $info['scores']=unserialize($info['scores']);
        $info['shiti'] = unserialize($info['shiti']);
        $list = array();
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
        $this->setComponent('test_see',$result);
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
    
    /**
     * 自测统计
     */
    
    function tongji($id,$start=0)
    {
        $limit=10;
        $where=array();
        $where['gz_study_zice_result.zice_id'] = $id;
      
        $list = $this->Study_MyTest_Model->get_tongji($where,$limit,$start);
        $count = $this->Study_MyTest_Model->get_tongji_count($where);
        //构造分页
        $config[ 'base_url' ] = base_url() . 'study_mytest/tongji/'.$id;
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links(4);
        $result=array(
            'list'       => $list,
            'count'      => $count,
            'pagination' =>$pagination
        );
        $this->setComponent('zice_tongji',$result);
        $this->showTemplate('study_base');
    }
    
     /**
     * 删除数据
     */
    function delete()
    {
        try
        {
            //构造数据
            $data = $this->input->post( 'item_id' );
            //删除数据
            foreach ( $data as $val )
            {
                $this->Study_MyTest_Model->delete( array('id' => $val) );
            }
            $this->AJAXSuccess();
        }
        catch ( Exception $ex )
        {
            $this->AJAXFail();
        }
    }
}
?>
