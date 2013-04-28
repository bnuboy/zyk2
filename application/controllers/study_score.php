<?php
include_once '_studyController.php';

class Study_Score extends StudyController
{
    public $per_type=array(
        'zongfen'      => '总分',
        'pingjunfen'   => '平均分',
        'jiaquanzongji'=> '权重'
    );
    function __construct()
    {
        parent::__construct();
        $this->load->model( 'Study_Score_Model' );
        $this->load->model('Study_Product_Set_Model');
        $this->load->model('User_Model');
        $this->load->model('Study_Product_Score_Model');
        $this->load->model('Study_HomeWork_Model');
        $this->load->library( 'adminpagination' );
    }

    function index( $start=0 )
    {
        $list = $this->Study_Score_Model->getAll( array('course_id' => $this->course['id']), '*', 'id desc');
        $this->setComponent( 'score_list',array('list'=>$list));
        $this->showTemplate( 'study_base' );
    }

    function get_class( $start=0 )
    {
        $get = $this->input->get();
        //参数初始化
        $course_id = $this->course['id'];
        $limit = 10;
        $ids=array();

        $where='`gz_study_class_join_user`.`id` > 0';

        $class_attr =array();
        //构造条件

        if(isset($get['user_id'])){ $where="`gz_study_class_join_user`.`class_id` in (".$get['user_id'].")";}
        if(isset ($get['ids'])){
            $tiaojian ="`user_id` in (".$get['ids'].")";
             $class_attr = $this->Study_Score_Model->get_list($tiaojian);
        }
        if(isset($get['ids'])) $ids = explode ( ',', $get['ids'] );
        //构造数据
        $list  = $this->Study_Score_Model->getStudent( $where, $limit, $start );
        $count = $this->Study_Score_Model->getStuCount( $where );
        //构造分页
        $config[ 'base_url' ]   = base_url() . 'study_score/get_classs';
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ]   = $limit;
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        //构造返回数据
        $result = array(
            'list'        => $list,
            'count'       => $count,
            'pagination'  => $pagination,
            'ids'         => $ids,
            'class_attr'  => $class_attr
        );
        $this->setComponent( 'class_list', $result );
        $this->showTemplate( 'base' );
    }

    /**
     * 获取作业
     */

    function get_zuoye($start=0)
    {
        $limit=10;
        $where='';
        $class_attr=array();
        $ids=array();
        $where='`course_id` ='.$this->course['id'];
        $get = $this->input->get();

        if($get['ids']){
            $where .=" and `id` in (".$get['ids'].")";
            $class_attr = $this->Study_Score_Model->get_zuoye_list($where);
        }
         if($get['ids']) $ids = explode ( ',', $get['ids'] );

        $zhangjie = $this->Study_Score_Model->get_zuoye($where,$limit,$start);

        $count =  $this->Study_Score_Model->get_zuoye_count($where);
        $config[ 'base_url' ] = base_url() . 'study_score/get_zuoye';
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        $result=array(
            'list' => $zhangjie,
            'count'=> $count,
            'class_attr'=>$class_attr,
            'ids'   =>$ids
        );
        $this->setComponent('zuoye_list',$result);
        $this->showTemplate('base');
    }
    /**
     * 获取作品
     */

    function get_zuopin($start=0)
    {
         $limit=10;
        $where='';
        $class_attr=array();
        $ids=array();
        $where='`course_id` ='.$this->course['id'];
        $get = $this->input->get();

        if($get['ids']){
            $where .=" and `id` in (".$get['ids'].")";
            $class_attr = $this->Study_Score_Model->get_zuoye_list($where);
        }
         if($get['ids']) $ids = explode ( ',', $get['ids'] );

        $zhangjie = $this->Study_Score_Model->get_zuopin($where,$limit,$start);

        $count =  $this->Study_Score_Model->get_zuopin_count($where);
        $config[ 'base_url' ] = base_url() . 'study_score/get_zuopin';
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        $result=array(
            'list' => $zhangjie,
            'count'=> $count,
            'class_attr'=>$class_attr,
            'ids'   =>$ids
        );
        $this->setComponent('zuopin_list',$result);
        $this->showTemplate('base');
    }


    /**
     * 提交处理筛选成绩条件
     */

    function select_score()
    {
        
        $this->load->library( 'phpexcel/PHPExcel' );
        $this->load->library( 'phpexcel/PHPExcel/IOFactory' );
        $zongtm      = array();//总题目
        $info_total  = array();//学生对应作业、作品的信息
        $tj          = array();//统计条件信息
        $zy_score    = array();
        $zy_sc       = array();
        $zuopin      = array();
        $zuoye       = array();
        $info        = array();
        $info1       = array();
        $userinfo    = array();
        $user_info   = array();
        $zp_timu     = array();
        $zp_sc       = array();
        $td='';
        $tds='';
     
       if(isset($_POST['zuoye']))
         {
            foreach ($_POST['zuoye'] as $key=>$val)
            {
               $zuoye[]= $this->Study_Score_Model->getzuoye('`id` ='.$val);
                  //以作业为条件查询成绩
               $sc = $this->Study_Score_Model->get_zuoye_score('`shijuan_id` ='.$val);
               if(!empty($sc)){
                   $zy_score[$val]=  $sc;
               }else{
                   $zy_score[$val]=array();
               }
            }
           }

            foreach($zy_score as $key=>$val)
            {
                //成绩循环单列 $key为作业ID
                if(!empty($val))
                {
                     foreach($val as $k=>$v)
                     {
                      $zy_sc[$key][$v['user_id']]=$v['score'];
                     }
                }else{
                     $zy_sc[$key]=array();
                }

            }

            //循环列出作业题目

            foreach($zuoye as $key=>$val)
            {
                $zongtimu[]=$val['title'];

            }
            if(isset($_POST['zuopin']))
            {
                 foreach ($_POST['zuopin'] as $key=>$val)
                {
                  $zuopin[] = $this->Study_Score_Model->getzuopin('`id` = '.$val);
                 }
            //循环列出作品题目
            }

            foreach ($zuopin as $key=>$val)
            {
                $zp_timu[]=$val['name'];

            }
            //总题目
            $zongtm = array_merge($zongtimu,$zp_timu);

            //取得选择作品里面的作品分数
            foreach($zuopin as $key=>$val)
            {
                $product_set=$this->Study_Product_Set_Model->getOne('`plan_id` = '.$val['plan_id']);
                $list[$val['id']]['username']=$this->User_Model->getOne('`id` = ' .$val['user_id'],'name');
                $list[$val['id']]['teascore']=$this->Study_Product_Score_Model->teaCommont(array('product_id'=>$val['id']));
                $list[$val['id']]['stuscore']=0;
                if($product_set['type']!='2'){
                $list[$val['id']]['stuscore']=$this->Study_Product_Score_Model->stuCommont(array('product_id'=>$val['id']));
                }
                //取得作品的总得分
                $zp_s =($list[$val['id']]['teascore']*((100-$product_set['stu_weight'])/100)+$list[$val['id']]['stuscore']*$product_set['stu_weight']/100)/5*$product_set['score'];
                    $zp[$val['id']]['sumscore']=$zp_s;
            }

            foreach($zuopin as $key=>$val)
            {
                $zp_sc[$val['id']][$val['user_id']] = $zp[$val['id']]['sumscore'];
            }

            foreach ($_POST['class'] as $key=>$val)
            {//print_r($zy_sc);
                //作业分
                foreach ($zy_sc as $ksc=>$vsc)
                {
                    if(isset($vsc[$val]))
                    {
                        if(isset($_POST['qz'][$ksc]))
                        {//$val 是学生ID $ksc为作业ID
                            $quanzhong[$val]['quanzhong'][] = $vsc[$val]*$_POST['qz'][$ksc]/100;
                        }else{
                            $quanzhong[$val]['quanzhong'][] =0;
                        }
                            $info[$val][] = $vsc[$val];
                    }else{
                        $quanzhong[$val]['quanzhong'][] =0;
                        $info[$val][] = 0;
                    }
                }//print_r($info);
                //作品分值
                 foreach ($zp_sc as $ksc=>$vsc)
                {
                    if(isset($vsc[$val]))
                    {
                        $info1[$val][] = $vsc[$val];
                    }else{
                        $info1[$val][] = 0;
                    }
                }

            }
            //合并作品和作业的分值
            if(!empty($info) && !empty($info1))
              {
                    foreach ($info as $key=>$val)
                    {
                    $info_total[$key]['score']=  array_merge($info[$key],$info1[$key]);
                    }

             }
             if(!empty($info) && empty($info1))
             {
                  foreach ($info as $key=>$val)
                    {
                    $info_total[$key]['score']=  $info[$key];
                    }
             }
              if(!empty($info1) && empty($info))
             {
                  foreach ($info1 as $key=>$val)
                    {
                    $info_total[$key]['score']=  $info1[$key];
                    }
             }

            if(isset($_POST['type'])){
                foreach($_POST['type'] as $k_ty=>$v_ty)
                {
                    if($v_ty=='zongfen'){
                         foreach($info_total as $key=>$val)
                         {
                            $info_total[$key]['total']=  array_sum($val['score']);
                         }
                    }
                    if($v_ty=='pingjunfen')
                    {
                        foreach($info_total as $key=>$val)
                         {
                            $info_total[$key]['avg']= round(array_sum($val['score'])/count($val['score']),2);
                         }
                    }
                    if($v_ty=='jiaquanzongji')
                    {
                        foreach($info_total as $key=>$val)
                         {
                            if($quanzhong[$key]['quanzhong']){
                            $info_total[$key]['jaquan'] = array_sum($quanzhong[$key]['quanzhong']) ;
                            }else{
                                $info_total[$key]['jaquan']= 0;
                            }
                         }
                    }
                }
            }
           $scor_count=0;
            //开始根据统计方式统计
            if(isset($_POST['score']))
            {
                $scor_count = count($_POST['score']);
                foreach($_POST['score'] as $key=>$val)
                {
                    if($val=='tiliang')
                    {

                        foreach ($zy_sc as $ky => $vy)
                        {
                            if($ky){
                                $tiaojian['tiliang'][] = $this->Study_Score_Model->get_tiliang("`shijuan_id` = ".$ky);
                            }
                        }

                        foreach($zp_sc as $ky => $vy)
                        {
                            if($ky)
                            {
                                $tiaojian['zp_tl'][] = 0;
                            }

                        }
                        //增加判断条件
                        if(isset($tiaojian['tiliang']) && isset($tiaojian['zp_tl']))
                        {
                            $tj['tiliang'] = array_merge($tiaojian['tiliang'],$tiaojian['zp_tl']);
                        }elseif(isset($tiaojian['tiliang']) && !isset($tiaojian['zp_tl']))
                        {
                            $tj['tiliang'] =$tiaojian['tiliang'];
                        }else
                        {
                             $tj['tiliang'] =$tiaojian['zp_tl'];
                        }

                    }

                     if($val=='max')
                    {
                        foreach ($zy_sc as $ky => $vy)
                        {
                            if($ky)
                            {
                                $tiaojian['max'][] = $this->Study_Score_Model->get_maxfenshu("`shijuan_id` = ".$ky);
                            }

                        }
                        if(isset($tiaojian['max']))
                        {
                            foreach($tiaojian['max'] as $km=>$vm)
                            {
                                if(isset($vm['tops']) && isset($km))
                                {
                                    $tijiao['top'][]=$vm['tops'];
                                }else{
                                    $tijiao['top'][]=0;
                                }
                            }
                        }
                        if($zp_sc){
                            foreach($zp_sc as $ky => $vy)
                            {
                                $tiaojian['zp_max'][] = 0;
                            }
                        }
                        if(isset($tijiao['top']) && isset($tiaojian['zp_max']))
                       {
                           $tj['top'] = array_merge($tijiao['top'],$tiaojian['zp_max']);
                       }elseif(isset($tijiao['top']) && !isset($tiaojian['zp_max'])){
                           $tj['top'] = $tijiao['top'];
                       }else{
                           $tj['top'] = $tiaojian['zp_max'];
                       }
                            //$tj['top'] = array_merge($tijiao['top'],$tiaojian['zp_max']);
                    }

                    if($val=='min')
                    {
                        foreach ($zy_sc as $ky => $vy)
                        {
                            if($ky)
                            {
                                 $tiaojian['min'][] = $this->Study_Score_Model->get_minfenshu("`shijuan_id` = ".$ky);
                            }

                        }
                        if(isset($tiaojian['min']))
                        {
                            foreach($tiaojian['min'] as $km=>$vm)
                            {
                                if(isset($vm['low']) && isset($km))
                                {
                                    $tijiao['low'][]=$vm['low'];
                                }else{
                                    $tijiao['low'][]=0;
                                }
                            }
                        }
                        if(isset($zp_sc))
                        {
                              foreach($zp_sc as $ky => $vy)
                              {
                                $tiaojian['zp_low'][] = 0;
                              }
                        }
                       if(isset($tijiao['low']) && isset($tiaojian['zp_low']))
                       {
                           $tj['low'] = array_merge($tijiao['low'],$tiaojian['zp_low']);
                       }elseif(isset($tijiao['low']) && !isset($tiaojian['zp_low'])){
                           $tj['low'] = $tijiao['low'];
                       }else{
                           $tj['low'] = $tiaojian['zp_low'];
                       }

                    }
                    //total start
                    if($val=='total')
                    {//echo $val;
                        foreach ($zy_sc as $ky => $vy)
                        {
                            if($ky)
                            {
                                 $tiaojian['total'][] = $this->Study_Score_Model->get_totalfenshu("`shijuan_id` = ".$ky);
                            }

                        }
                        if(isset($tiaojian['total']))
                        {
                            foreach($tiaojian['total'] as $km=>$vm)
                            {
                                if(isset($vm['total']) && isset($km))
                                {
                                    $tijiao['total'][]=$vm['total'];
                                }else{
                                    $tijiao['total'][]=0;
                                }
                            }
                        }
                        if(isset($zp_sc))
                        {
                              foreach($zp_sc as $ky => $vy)
                              {
                                $tiaojian['zp_total'][] = 0;
                              }
                        }
                       if(isset($tijiao['total']) && isset($tiaojian['zp_total']))
                       {
                           $tj['total'] = array_merge($tijiao['total'],$tiaojian['zp_total']);
                       }elseif(isset($tijiao['total']) && !isset($tiaojian['zp_total'])){
                           $tj['total'] = $tijiao['total'];
                       }else{
                           $tj['total'] = $tiaojian['zp_total'];
                       }

                    }

                    //total end

                    if($val=='pingjunfen')
                    {
                        foreach ($zy_sc as $ky => $vy)
                        {
                            if($ky)
                            {
                               $tiaojian['avg'][] = $this->Study_Score_Model->get_avgfenshu("`shijuan_id` = ".$ky);
                            }

                        }
                        if(isset($tiaojian['avg']))
                        {
                            foreach($tiaojian['avg'] as $km=>$vm)
                            {
                                if(isset($vm['pjf']) && isset($km))
                                {
                                    $tijiao['avg'][]=round($vm['pjf'],3);
                                }else{
                                    $tijiao['avg'][]=0;
                                }
                             }
                        }
                        if(isset($zp_sc))
                        {
                             foreach($zp_sc as $ky => $vy)
                              {
                                 $tiaojian['zp_avg'][] = 0;
                              }
                        }
                         if(isset($tijiao['avg']) && isset($tiaojian['zp_avg']))
                         {
                             $tj['avg'] = array_merge($tijiao['avg'],$tiaojian['zp_avg']);
                         }elseif(isset($tijiao['avg']) && !isset($tiaojian['zp_avg']))
                         {
                              $tj['avg'] = $tijiao['avg'];
                         }else{
                             $tj['avg'] = $tiaojian['zp_avg'];
                         }

                    }
                }
            }
             if(isset($_POST['score1']))
            {
                foreach($_POST['score1'] as $key=>$val)
                {
                    if($val =='youxiu')
                    {
                         foreach ($zy_sc as $ky => $vy)
                         {
                             //优秀的总人数
                             $yx = $this->Study_Score_Model->get_youxiu("`shijuan_id` = ".$ky." AND `score` >= 90");
                             //该作业下的总人数
                             $yx_total_pers = $this->Study_Score_Model->get_youxiu_count("`shijuan_id` = ".$ky);
                             //求没门作业的优秀的人数
                             if($yx){
                               $tiaojian['yx'][] = $yx;
                             }else{
                               $tiaojian['yx'][]=0;
                             }
                             //求每门作业的优秀比例
                             if($yx_total_pers!=0)
                             {
                                 $tiaojian['yx_bili'][]=round( intval($yx)/intval($yx_total_pers) * 100 , 2) . "%";
                             }else{
                                 $tiaojian['yx_bili'][] ='0'.'.00%';
                             }
                         }

                        ////需测试^^^^
                         if(isset($zp_sc))
                         {
                              foreach($zp_sc as $ky => $vy)
                             {
                                $tiaojian['zp_yx'][] = 0;
                                $tiaojian['zp_bili_yx'][] = '0'.'.00%';
                             }
                         }
                       if(isset($tiaojian['yx']) && isset($tiaojian['zp_yx']))
                        {
                            $tj['yx'] = array_merge($tiaojian['yx'],$tiaojian['zp_yx']);
                        }elseif(isset($tiaojian['yx']) && !isset($tiaojian['zp_yx']))
                        {
                            $tj['yx'] = $tiaojian['yx'];
                        }else{
                            $tj['yx'] = $tiaojian['zp_yx'];
                        }

                        //$tj['yx'] = array_merge($tiaojian['yx'],$tiaojian['zp_yx']);
                        if(isset($tiaojian['yx_bili']) && isset($tiaojian['zp_bili_yx']))
                        {
                            $tj['yx_bili'] = array_merge($tiaojian['yx_bili'],$tiaojian['zp_bili_yx']);
                        }elseif(isset($tiaojian['yx_bili']) && !isset($tiaojian['zp_bili_yx']))
                        {
                            $tj['yx_bili'] = $tiaojian['yx_bili'];
                        }else{
                            $tj['yx_bili'] = $tiaojian['zp_bili_yx'];
                        }
                        //$tj['yx_bili'] = array_merge($tiaojian['yx_bili'],$tiaojian['zp_bili_yx']);
                    }

                    if($val =='lianghao')
                    {
                         foreach ($zy_sc as $ky => $vy)
                         {
                             $lh = $this->Study_Score_Model->get_youxiu("`shijuan_id` = ".$ky." AND `score` Between 70 and 80");
                              //该作业下的总人数
                             $lh_total_pers = $this->Study_Score_Model->get_youxiu_count("`shijuan_id` = ".$ky);
                             if($lh){
                               $tiaojian['lh'][] = $lh;
                             }else{
                               $tiaojian['lh'][]=0;
                             }

                              //求每门作业的优秀比例
                             if($lh_total_pers!=0)
                             {
                                 $tiaojian['lh_bili'][]=round( intval($lh)/intval($lh_total_pers) * 100 , 2) . "%";
                             }else{
                                 $tiaojian['lh_bili'][] ='0'.'.00%';
                             }
                         }
                        ////需测试^^^^
                         if(isset($zp_sc))
                         {
                             foreach($zp_sc as $ky => $vy)
                            {
                               $tiaojian['zp_lh'][] = 0;
                              $tiaojian['zp_bili_lh'][] = '0'.'.00%';
                            }
                         }
                        if(isset($tiaojian['lh']) && isset($tiaojian['zp_lh']))
                        {
                            $tj['lh'] = array_merge($tiaojian['lh'],$tiaojian['zp_lh']);
                        }elseif(isset($tiaojian['lh']) && !isset($tiaojian['zp_lh']))
                        {
                            $tj['lh'] = $tiaojian['lh'];
                        }else{
                            $tj['lh'] = $tiaojian['zp_lh'];
                        }

                        //判断比例
                        if(isset($tiaojian['lh_bili']) && isset($tiaojian['zp_bili_lh']))
                        {
                            $tj['lh_bili'] = array_merge($tiaojian['lh_bili'],$tiaojian['zp_bili_lh']);
                        }elseif(isset($tiaojian['lh_bili']) && !isset($tiaojian['zp_bili_lh']))
                        {
                            $tj['lh_bili'] = $tiaojian['lh_bili'];
                        }else{
                            $tj['lh_bili'] = $tiaojian['zp_bili_lh'];
                        }
                        // $tj['lh_bili'] = array_merge($tiaojian['lh_bili'],$tiaojian['zp_bili_lh']);
                    }

                    if($val =='zhongdeng')
                    {
                         foreach ($zy_sc as $ky => $vy)
                         {
                             $zd = $this->Study_Score_Model->get_youxiu("`shijuan_id` = ".$ky." AND `score` Between 60 and 70");
                             //该作业下的总人数
                             $zd_total_pers = $this->Study_Score_Model->get_youxiu_count("`shijuan_id` = ".$ky);
                             if($zd){
                               $tiaojian['zd'][] = $zd;
                             }else{
                               $tiaojian['zd'][]=0;
                             }
                             //求每门作业的优秀比例
                             if($zd_total_pers!=0)
                             {
                                 $tiaojian['zd_bili'][]=round( intval($zd)/intval($zd_total_pers) * 100 , 2) . "%";
                             }else{
                                 $tiaojian['zd_bili'][] ='0'.'.00%';
                             }
                         }
                        ////需测试^^^^
                         if($zp_sc)
                         {
                             foreach($zp_sc as $ky => $vy)
                              {
                                $tiaojian['zp_zd'][] = 0;
                                $tiaojian['zp_bili_zd'][] = '0'.'.00%';
                              }
                         }
                        if(isset($tiaojian['zd'])&& isset($tiaojian['zp_zd']))
                        {
                            $tj['zd'] = array_merge($tiaojian['zd'],$tiaojian['zp_zd']);
                        }elseif(isset($tiaojian['zd'])&& !isset($tiaojian['zp_zd']))
                        {
                            $tj['zd'] = $tiaojian['zd'];
                        }else{
                            $tj['zd'] = $tiaojian['zp_zd'];
                        }
                        //判断比例
                         if(isset($tiaojian['zd_bili'])&& isset($tiaojian['zp_bili_zd']))
                        {
                            $tj['zd_bili'] = array_merge($tiaojian['zd_bili'],$tiaojian['zp_bili_zd']);
                        }elseif(isset($tiaojian['zd_bili'])&& !isset($tiaojian['zp_bili_zd']))
                        {
                            $tj['zd_bili'] = $tiaojian['zd_bili'];
                        }else{
                            $tj['zd_bili'] = $tiaojian['zp_bili_zd'];
                        }

                    }
                    if($val =='jige')
                    {
                         foreach ($zy_sc as $ky => $vy)
                         {
                             $jg = $this->Study_Score_Model->get_youxiu("`shijuan_id` = ".$ky." AND `score` = 60");
                               //该作业下的总人数
                             $jg_total_pers = $this->Study_Score_Model->get_youxiu_count("`shijuan_id` = ".$ky);
                             if($jg){
                               $tiaojian['jg'][] = $jg;
                             }else{
                               $tiaojian['jg'][]=0;
                             }
                             //求每门作业的优秀比例
                             if($jg_total_pers!=0)
                             {
                                 $tiaojian['jg_bili'][]=round( intval($jg)/intval($jg_total_pers) * 100 , 2) . "%";
                             }else{
                                 $tiaojian['jg_bili'][] ='0'.'.00%';
                             }
                         }
                        ////需测试^^^^
                         if(isset($zp_sc))
                         {
                              foreach($zp_sc as $ky => $vy)
                              {
                                $tiaojian['zp_jg'][] = 0;
                                $tiaojian['zp_bili_jg'][] = '0'.'.00%';
                             }
                         }
                       if(isset($tiaojian['jg']) && isset($tiaojian['zp_jg']))
                       {
                           $tj['jg'] = array_merge($tiaojian['jg'],$tiaojian['zp_jg']);
                       }elseif(isset($tiaojian['jg']) && !isset($tiaojian['zp_jg']))
                       {
                            $tj['jg'] = $tiaojian['jg'];
                       }  else {
                           $tj['jg'] = $tiaojian['zp_jg'];
                       }

                       //判断比例
                       if(isset($tiaojian['jg_bili']) && isset($tiaojian['zp_bili_jg']))
                       {
                           $tj['jg_bili'] = array_merge($tiaojian['jg_bili'],$tiaojian['zp_bili_jg']);
                       }elseif(isset($tiaojian['jg_bili']) && !isset($tiaojian['zp_bili_jg']))
                       {
                            $tj['jg_bili'] = $tiaojian['jg_bili'];
                       }  else {
                           $tj['jg_bili'] = $tiaojian['zp_bili_jg'];
                       }

                       // $tj['jg_bili'] = array_merge($tiaojian['jg_bili'],$tiaojian['zp_bili_jg']);
                    }
                    if($val =='bujige')
                    {
                         foreach ($zy_sc as $ky => $vy)
                         {
                             $bjg = $this->Study_Score_Model->get_youxiu("`shijuan_id` = ".$ky." AND `score` < 60");
                                //该作业下的总人数
                             $bjg_total_pers = $this->Study_Score_Model->get_youxiu_count("`shijuan_id` = ".$ky);
                             if($bjg){
                               $tiaojian['bjg'][] = $bjg;
                             }else{
                               $tiaojian['bjg'][]=0;
                             }
                              //求每门作业的优秀比例
                             if($bjg_total_pers!=0)
                             {
                                 $tiaojian['bjg_bili'][]=round( intval($bjg)/intval($bjg_total_pers) * 100 , 2) . "%";
                             }else{
                                 $tiaojian['bjg_bili'][] ='0'.'.00%';
                             }
                         }
                        ////需测试^^^^
                         if(isset($zp_sc))
                         {
                             foreach($zp_sc as $ky => $vy)
                             {
                                $tiaojian['zp_bjg'][] = 0;
                                $tiaojian['zp_bili_bjg'][] = '0'.'.00%';
                             }
                         }
                        if(isset($tiaojian['bjg']) && isset($tiaojian['zp_bjg']))
                        {
                            $tj['bjg'] = array_merge($tiaojian['bjg'],$tiaojian['zp_bjg']);
                        }elseif(isset($tiaojian['bjg']) && !isset($tiaojian['zp_bjg']))
                        {
                            $tj['bjg'] = $tiaojian['bjg'];
                        }else{
                             $tj['bjg'] = $tiaojian['zp_bjg'];
                        }
                        //判断比例
                         if(isset($tiaojian['bjg_bili']) && isset($tiaojian['zp_bili_bjg']))
                        {
                            $tj['bjg_bili'] = array_merge($tiaojian['bjg_bili'],$tiaojian['zp_bili_bjg']);
                        }elseif(isset($tiaojian['bjg_bili']) && !isset($tiaojian['zp_bili_bjg']))
                        {
                            $tj['bjg_bili'] = $tiaojian['bjg_bili'];
                        }else{
                             $tj['bjg_bili'] = $tiaojian['zp_bili_bjg'];
                        }
                        //$tj['bjg_bili'] = array_merge($tiaojian['bjg_bili'],$tiaojian['zp_bili_bjg']);
                    }

                }
            }
            
             foreach($_POST['class'] as $key=>$val)
            {
                $userinfo[] = $this->User_Model->getOne('`id` = '.$val);
            }
           if(isset($userinfo))
           {
               foreach($userinfo as $key=>$val)
               {
                   $user_info[$val['id']] = $val['name'];
               }
           }
            //判断是网页还是excel
          if($_POST['born']=='wangye'){
            if(isset($_POST['type']))
            {
                for($i=0;$i<count($_POST['type']);$i++)
                {
                    $td .= "<td>&nbsp;</td>";
                }
                foreach($_POST['type'] as $key=>$val)
                {
                    if($val == 'zongfen')
                    {
                        $tds .= "<td width='78'>总分</td>";
                    }
                    if($val == 'pingjunfen')
                    {
                        $tds .= "<td width='78'>平均分</td>";
                    }
                    if($val == 'jiaquanzongji')
                    {
                        $tds .= "<td width='78'>加权</td>";
                    }
                }
            }

           
//print_r($tj);

        $result = array(
            'zuoye'     => $zongtm,
            'scores'    => $info_total,
            'tj'        => $tj,
            'tds'       => $tds,//横向题目
            'td'        => $td,  //横向<td>
            'user_info' => $user_info, //用户的姓名列表
            'scor_count' =>$scor_count
        );
       $this->setComponent('chengji_list',$result);
       $this->showTemplate('study_base');
     }else{
        $objPHPExcel = new PHPExcel();
            //  excel 第一行  表头   第一个参数是列 第二个参数是行 ****start
            $objPHPExcel->getProperties()->setTitle( "export" )->setDescription( "none" );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 0, 1, '排名' );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 1, 1, '姓名' );
            foreach($zongtm as $key=>$val)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $key+2, 1, $val );
            }
            //列出个人的统计条件
            if(isset($_POST['type']))
            {
                foreach($_POST['type'] as $key=>$val)
                {
                  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( count($zongtm)+2+$key, 1, $this->per_type[$val] );  
                }
            }
           //excel 第一行  完毕 *********end
            //循环输出
            $i = 0;
            foreach ( $info_total as $key => $val )
            {
                 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 0, $i+2 , $i+1 );
                 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 1, $i+2 , $user_info[$key] );
                foreach ( $val['score'] as $k=>$v ){    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $k+2, $i + 2, $v );
                }
                //是否存在总分
                if(isset ($val["total"]))
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( count($val['score'])+2, $i + 2, $val["total"] );
                //是否存在平均分
                 if(isset ($val["avg"])){
                     if(isset($val['total'])){
                          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( count($val['score'])+3, $i + 2, $val["avg"] );
                     }else{
                          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( count($val['score'])+2, $i + 2, $val["avg"] );
                     }                
                 }
                 //是否存在权重
                 if(isset ($val["jaquan"]))
                 {
                     if(isset($val['total']) && isset($val['avg'])){
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( count($val['jiaquan'])+4, $i + 2, $val["jiaquan"] ); 
                     }elseif((isset($val['total']) && !isset($val['avg'])) || (!isset($val['total']) && isset($val['avg'])))
                     {
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( count($val['jiaquan'])+3, $i + 2, $val["jiaquan"] ); 
                     }
                      else
                     {
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( count($val['jiaquan'])+2, $i + 2, $val["jiaquan"] ); 
                     }
                 }
                $i++;
            }
            //合并A单元格
            if($_POST['score'])
            {
               // $objPHPExcel->getActiveSheet()->mergeCells('A'.(count($info_total)+2).":E".count($_POST['score'])+(count($info_total)+2));
                //if
            }
            

        $objPHPExcel->setActiveSheetIndex( 0 );
        $objWriter = IOFactory::createWriter( $objPHPExcel, 'Excel5' );
        header( 'Content-Type: application/vnd.ms-excel' );
        header( 'Content-Disposition: attachment;filename="Products_' . date( 'dMy' ) . '.xls"' );
        header( 'Cache-Control: max-age=0' );
        $objWriter->save( 'php://output' );
     }
    }

    /**
     *获取作业
     */
    function get_select_zy()
    {
        $data = $this->input->post('id');
        foreach($data as $key=>$val)
        {
            $list[] = $this->Study_Score_Model->get_zy("`id` =".$val);
        }
        $this->AJAXSuccess($list);
    }
}
?>
