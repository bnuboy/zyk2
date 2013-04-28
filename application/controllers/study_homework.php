<?php
include_once '_studyController.php';
//my name is liuwenhu 

class Study_HomeWork extends StudyController
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
        $this->load->model('Study_MyTest_Model');
        $this->load->model('Study_Coursecontent_Model');
        $this->load->model('Study_Course_Model');
        $this->load->library('adminpagination');
    }

    /**
     * 默认列表
     */
    function index( $start=0 )
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
        $this->setComponent( 'study_homework' ,$result);
        $this->showTemplate( 'study_base' );
    }

    /**
     * 筛选作业类型
     */
    function select_type()
    {
        if ( $_GET )
        {
            $typename = '';
            switch ( $_GET[ 'id' ] )
            {
                case 1:
                    $typename = 'shoudong';
                    break;
                case 2:
                    $typename = 'zidong';
                    break;
                case 3:
                    $typename = 'fujian';
                default :
                    break;
            }
             $course_id=$this->course['id'];
             $list = $this->Study_Coursecontent_Model->getTreeCourses("`course_id` = ".$course_id);
          
            $this->setComponent( $typename . '_zuoye',array('list'=>$list) );
            $this->showTemplate( 'study_base' );
        }
        else
        {
            $this->setComponent( 'select_type' );
            $this->showTemplate( 'study_base' );
        }
    }
    /**
     * 筛选章节内的类型
     */
    function get_zhangjie_type()
    {
        $post = $this->input->post();
       
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
       // print_r($list);
        $this->setComponent('zhangjie_xuanti',$result);
        $this->showTemplate('study_base');
    }
    
    /**
     *选择试题 
     */
    function get_shiti($param,$id,$zsd_id)
    {
        $ids=array();
        $ul_id = $param.$_GET['key_id'];
         if(isset($_GET['ids']))
            $ids = $_GET['ids'];
        if($param=='tiankong' || $param=='wanxingtiankong'){
           $list = $this->Study_HomeWork_Model->select_shiti($param,array('tixing_id'=>$id,'zsd_id'=>$zsd_id)); 
           foreach ($list as $key=>$val)
           {
               $list[$key]['title'] = unserialize($val['title']);
           }
        }else{
        $list = $this->Study_HomeWork_Model->select_shiti($param,array('tixing_id'=>$id,'zsd_id'=>$zsd_id));
        }
        $result=array(
            'ul_id' => $ul_id ,
            'list'  => $list,
            'param' => $param,
            'tx_id' => $id,
            'zsd_id'=> $zsd_id,
            'k_id'  => $_GET['key_id'],
            'ids'   => $ids
        );
        $this->setComponent('select_shiti',$result);
        $this->showTemplate('base');
    }
    
    /**
     * 提交选择试题
     */
    
    function add_shiti()
    {
        $events=array();
        $post = $_POST; 
        $post['course_id'] = $this->course['id'];
        unset($_POST['title']);
        unset($_POST['type_id']);
        unset($_POST['score']);
        unset($_POST['scores']);
        unset($_POST['start_time']);
        unset($_POST['end_time']);
        unset($_POST['content']);     
        unset($_POST['zhangjie']);
        //根据选择的试题ID，获取试题信息，题型，存储
          //print_r($_POST);
        if($_POST){
            foreach ($_POST as $key=>$val)
            {
                foreach($val as $k=>$v)
                {
                    foreach($v as $ks=>$vl)
                    {
                        if($vl)
                        {
                           $list[$key][$k] = $this->Study_HomeWork_Model->select_shiti($key,'id in('.$vl.')');
                        }
                    }
                }
            }
        }
     if(isset($list)){
        foreach ($list as $key =>$val)
        {
            foreach ($val as $k=>$v)
            {
                foreach($v as $ks=>$vl)
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
                   //$key 基本类型名 $k 题型ID;
                    $events[$k.'_'.$key][]=$vl;
                }
            }
        }
     }
         $this->Study_HomeWork_Model->add_shijuan($post,$events);
        Util::redirect('/study_homework/index');
    }
    /**
     *修改信息
     * @param type $id 
     */
    function edit($id)
    {
        $info = $this->Study_HomeWork_Model->getShitiInfo('id ='.$id);
        $this->setComponent('shiti_edit');
        $this->showTemplate('study_base');
    }

    
    /**
     * 自动选择、添加课程
     */
    
    function zidong_zhangjie_type()
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
        $this->setComponent('zidong_selectshiti',$result);
        $this->showTemplate('study_base');
    }
    
    /**
     * 自动添加
     */
    function zidong_add_shiti()
    {
        $post = $_POST;
        $post['course_id'] = $this->course['id'];
        unset($_POST['zhangjie']);
        unset($_POST['type_id']);
        unset($_POST['title']);
        unset($_POST['start_time']);
        unset($_POST['end_time']);
        unset($_POST['content']);
        unset($_POST['scores']);   
        unset($_POST['score']); 
        $event = array();
        foreach ($_POST as $key=>$val)
        {
            foreach($val as $k=>$v)
            {
                foreach ($v as $ks=>$vl)
                {
                    if($vl)
                    {
                        $event[$key][$k] = $this->Study_HomeWork_Model->zidong_select_shiti($key,array('tixing_id'=>$k),$vl,'created desc');
                    }
                }
            }
        }
        $this->Study_HomeWork_Model->zidong_insert($post,$event);
        Util::redirect('/study_homework/index');
    }
    /**
     * 附件作业的添加
     */
    
    function fujian_add()
    {
        $post = $_POST;
        $post['course_id'] = $this->course['id'];
        $this->Study_HomeWork_Model->fujian_insert($post);
        Util::redirect('/study_homework/index');
    }
    
    /**
     * 答题测试
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
       // print_r($zongfen);
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
            
            
        } //print_r($_POST);die();
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
     * 批阅作业
     */
    function piyue($start=0)
    {
        $limit=10;
        $where=array();
        $list  = $this->Study_HomeWork_Model->piyue($where,$limit,$start);
        $count = $this->Study_HomeWork_Model->piyue_count($where);       
        
        $result = array(
            'list' =>$list,
            'count'=>$count
        );
        $this->setComponent('piyue',$result);
        $this->showTemplate('study_base');
    }
    /**
     *修改状态
     * @param type $id 
     */
    function enable( $id )
    {
        try
        {
            $this->Study_HomeWork_Model->update_zuoye( array("good_work" => $this->input->post( 'enabled' )), "id = " . $id );
            $this->AJAXSuccess( '' );
        }
        catch ( Exception $ex )
        {
            $this->AJAXFail( $ex );
        }
    }
    
    /**
     * 批量修改作业
     */
    function pi_work($id)
    {
        
        $list = $this->Study_HomeWork_Model->get_zuoye(array('gz_study_jiaojuan.id'=>$id));        
        $list['zj_name']='';
        
        $zhangjie_name = $this->Study_HomeWork_Model->get_zhangjie_name('id in('.$list['zhangjie_id'].")");   
        
        foreach ($zhangjie_name as $key=>$val)
        {
            $list['zj_name'] .=$val['title'].',';
        }
        
        if(isset ($list['zj_name']))
            $list['zj_name'] = substr($list['zj_name'],0,  strlen($list['zj_name'])-1);
        
        $result = array(
            'list' =>$list
        );
        $this->setComponent('pi_work',$result);
        $this->showTemplate('study_base');
    }
    
    /**
     * 批阅评价
     */
    function pingjia($id)
    {   
        $_POST['status']='y';
        if(!isset ($_POST['good_work']))
            $_POST['good_work'] ='n';
        $this->Study_HomeWork_Model->update_jiaojuan($_POST,'id ='.$id);
        Util::redirect('/study_homework/piyue');
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
                $this->Study_HomeWork_Model->delete( array('id' => $val) );
            }
            $this->AJAXSuccess();
        }
        catch ( Exception $ex )
        {
            $this->AJAXFail();
        }
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
     * 考试统计
     */
    
    function tongji($id,$start=0)
    {
        $limit=10;
        $where=array();
        $where['gz_study_jiaojuan.shijuan_id'] = $id;
      
        $list = $this->Study_HomeWork_Model->get_tongji($where,$limit,$start);
        $count = $this->Study_HomeWork_Model->get_tongji_count($where);
        //构造分页
        $config[ 'base_url' ] = base_url() . 'study_homework/tongji/'.$id;
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links(4);
        $result=array(
            'list'       => $list,
            'count'      => $count,
            'pagination' =>$pagination
        );
        $this->setComponent('ceshi_tongji',$result);
        $this->showTemplate('study_base');
    }


}
?>
