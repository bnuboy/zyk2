<?php
/*
 * 代码编写者：温晓军 
 * 公司：颐达合创
 * 代码首次编写日期：2012-07-21 
 */

include_once '_studyController.php';

class study_class_doirss extends StudyController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model( "Study_Class_Doirss_Model" );
        $this->load->model( "Study_Course_Log_Model" );
        $this->load->model( "Study_Coursecontent_Model" );
        $this->load->model( "User_Model" );
        $this->load->model( "User_Login_Log_Model" );
        $this->load->library( 'adminpagination' );
    }

    /*
     * 显示学习档案
     */

    function index( $offset='0' )
    {
        //参数初始化
        $limit = 10;
        $start_time = !empty( $_GET[ 'start_time' ] ) ? $_GET[ 'start_time' ] : '';
        $end_time = !empty( $_GET[ 'end_time' ] ) ? $_GET[ 'end_time' ] : '';
        //构造查询条件
        $where = array();
        if ( !empty( $start_time ) )
            $where[] = "login_time >= '".$_GET[ 'start_time' ]."'";
        if ( !empty( $end_time ) )
            $where[] = "login_time <= '" . $_GET[ 'end_time' ]."'";
        $where[] = 'user_id = ' .$this->user[ 'id' ];
        $condition=implode(" AND ", $where);
        //构造数据
        $list = $this->User_Login_Log_Model->getALL( $condition, '*', '`id` DESC', $limit, $offset );
        $count = $this->User_Login_Log_Model->getCount( $condition );
        //计算一共的时间长
        $timeCount = $this->User_Login_Log_Model->getTimeCount( $condition );
        //构造分页
        $config[ 'base_url' ] = base_url() . 'study_class_doirss/index';
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        //构造返回数据
        $result = array(
            'list' => $list,
            'pagination' => $pagination,
            'timecount' => $timeCount,
            'count' => $count,
            'get' => $_GET
        );
        $this->setComponent( 'study_doirss', $result );
        $this->showTemplate( 'study_base' );
    }

    //显示学习记录
    function study_take( $offset=0 )
    {
        //参数初始化
        $limit = 10;
        //构造查询条件
        $where = "`user_id` =" . $this->user[ 'id' ];
        //构造数据
        $list = $this->Study_Course_Log_Model->getAll( $where, '*', 'id desc', $limit, $offset );

        //学习次数  时间长度
        $study_counts = array();
        $study_times = array();
        foreach ( $list as $key => $value )
        {
            $list[ $key ][ 'content' ] = $this->Study_Coursecontent_Model->getOne( "`id` =" . $value[ 'content_id' ] );
            $study_counts[ ] = $value[ 'read_num' ];
            $study_times[ ] = $value[ 'study_time' ];
        }

        $count = $this->Study_Course_Log_Model->getCount( $where );
        $study_count = array_sum( $study_counts );
        $study_time = array_sum( $study_times );

        //构造分页
        $config[ 'base_url' ] = base_url() . 'study_class_doirss/study_take';
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;

        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();

        //构造返回数据
        $result = array(
            "list" => $list,
            "pagination" => $pagination,
            "study_count" => $study_count,
            "study_time" => $study_time
        );

        $this->setComponent( 'study_take', $result );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 显示作业
     * param int $sum 总成绩
     * param good_work 评为优秀的作品
     */
    function homework_log($offect=0)
    {
        //参数初始化
        $sum=0;
        $good_work=0;
        $agv=0;
        $this->load->model("Study_HomeWork_Model");
        $limit = 10;
        //构造查询条件
        $where = "`user_id` =" . $this->user[ 'id' ];
        //构造数据
        $list=$this->Study_HomeWork_Model->selectHomeworkLog($where,'gz_study_shijuan.title,gz_study_jiaojuan.*','created desc',$limit,$offect);
        $count=$this->Study_HomeWork_Model->CountHomeworkLog($where);
        foreach($list as $val){
            $sum+=$val['score'];
            if($val['good_work']=='n'){$good_work+=1;}
        }
        if($sum!='0'&&$count!='0'){
        $agv=$sum/$count;
        }
        //构造分页
        $config[ 'base_url' ] = base_url() . 'study_class_doirss/homework_log';
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;

        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        //构造返回数据
        $result = array(
            "list"       => $list,
            "pagination" => $pagination,
            'count'      => $count,
            'sum'        => $sum,
            'good_work'  => $good_work,
            'agv'        => $agv
        );
        $this->setComponent( 'study_homework_log' ,$result);
        $this->showTemplate( 'study_base' );
    }

    /*
     * 显示作品
     * $tea_stu_score 老师和学生的评分
     * $sum  总成绩
     */
    function products_log($offect=0)
    {
        $this->load->model("Study_Product_Model");
        $this->load->model("Study_Product_Score_Model");
        $this->load->model("Study_Product_Set_Model");
        //构造条件
        $limit = 10;
        $agv=0;
        $where="`user_id` = ".$this->user['id'] ." AND `status` = 2";
        //构造数据
        $list=  $this->Study_Product_Model->getAll($where,"id,name,up_time,plan_id",'up_time desc',$limit,$offect);
        $count=  $this->Study_Product_Model->getCount($where);
        $sum=0;
        foreach($list as $key=>$val){
            $product_set=$this->Study_Product_Set_Model->getOne('`plan_id` = '.$val['plan_id']);
            $list[$key]['teascore']=$this->Study_Product_Score_Model->teaCommont(array('product_id'=>$val['id']));
            $list[$key]['stuscore']=0;
            if($product_set['type']!='2'){
            $list[$key]['stuscore']=$this->Study_Product_Score_Model->stuCommont(array('product_id'=>$val['id']));
            }
            $list[$key]['sumscore']=($list[$key]['teascore']*((100-$product_set['stu_weight'])/100)+$list[$key]['stuscore']*$product_set['stu_weight']/100)/5*$product_set['score'];
            $sum+=$list[$key]['sumscore'];
        }
        if($sum!='0'&&$count!='0'){
        $agv=$sum/$count;
        }
        //构造分页
        $config[ 'base_url' ] = base_url() . 'study_class_doirss/products_log';
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;

        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        //构造返回数据
        $result=array(
            "list"       => $list,
            'count'      => $count,
            'pagination' => $pagination,
            'sum'        => $sum,
            'agv'       =>$agv
        );
        $this->setComponent( 'products_log',$result );
        $this->showTemplate( 'study_base' );
    }

}
?>