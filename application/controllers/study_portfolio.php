<?php
include_once '_studyController.php';

class Study_Portfolio extends StudyController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model( 'Study_Portfolio_Model' );
        $this->load->model( 'Study_Class_Doirss_Model' );
        $this->load->model( "User_Login_Log_Model" );
        $this->load->model( "Study_Course_Log_Model" );
        $this->load->model("Study_Coursecontent_Model");
        $this->load->model( "User_Model" );
        $this->load->model( "Study_Question_Model" );
        $this->load->model( "Study_Course_Class_Model" );
        $this->load->model( "Study_Class_Join_User_Model" );
        $this->load->model("Study_HomeWork_Model");
        $this->load->model("Study_MyTest_Model");
        $this->load->model("Study_Select_Course_Model");
    }

    /*
     * 教师角色 学生档案列表
     * param array  $home_id  作业id
     * param array  $mytest   自测
     */

    function index( $start=0 )
    {
        //班级列表  构造查询条件
        $where=array();
        $home_id=array();
        $content=array();
        $students=array();
        $course_id = $this->course['id'];
        $class = $this->Study_Course_Class_Model->getAll( "`course_id` =" . $course_id, '*', 'id asc' );
        //构造条件
        if(!empty($_GET['class_id']))$where[] = "`class_id` =" . $_GET[ 'class_id' ];
        $condition=implode(' And ', $where);
        //构造数据
        $students= $this->Study_Select_Course_Model->getAll(" `course_id` = ".$this->course['id']." AND `course_part_id` = '10002' AND `status`= 'audit'");
        $mytest=  $this->Study_MyTest_Model->getALL("`course_id` = " .$course_id,'id');
        if($mytest){
        foreach($mytest as $v){
            $test[]=$v['id'];
        }
        $test_id=implode(',', $test);
        }
        $homework=$this->Study_HomeWork_Model->getAll("`course_id` = " .$course_id,'id');
        if($homework){
        foreach($homework as $val){
            $home_work[]=$val["id"];
        }
        $home_id=implode(',', $home_work);
        }
        foreach ( $students as $key => $value )
        {
            $students[ $key ][ 'time' ] = $this->Study_Class_Doirss_Model->getTime( "`user_id` = " . $value[ 'user_id' ] );
            $students[ $key ][ 'user' ] = $this->User_Model->getOne( "`id` = " . $value[ 'user_id' ], "id,name,student_id" );
            if(!empty ($home_id))$students[$key]['homework'] = $this->Study_HomeWork_Model->CountHomeworkLog('`user_id` = ' .$value['user_id']." AND `shijuan_id` in(".$home_id.")");
            $students[ $key ][ 'question_count' ] = $this->Study_Question_Model->getCount( '`quser_id` =' . $value[ 'user_id' ] );
            $students[ $key ][ 'answer_count' ] = $this->Study_Question_Model->get_answer_count( '`auser_id` =' . $value[ 'user_id' ] );
            if(!empty($mytest))$students[$key]['counttest']=$this->Study_MyTest_Model->CountTest("`id` = " . $value[ 'user_id' ]." AND `zice_id` in(".$test_id.")");
        }
        $results = array(
            "students" => $students,
            "class" => $class,
            "get" => $_GET
        );
        $this->setComponent( 'study_portfolio', $results );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 教师角色 登录记录
     */

    function cartogram( $id )
    {
        //参数初始化
        $start_time = !empty( $_GET[ 'start_time' ] ) ? $_GET[ 'start_time' ] : '';
        $end_time = !empty( $_GET[ 'end_time' ] ) ? $_GET[ 'end_time' ] : '';
        //构造查询条件
        $where = array();
        $where[] ='`user_id` = '. $id;
        $student = $this->User_Model->getOne( "`id` = " . $id );
        if ( !empty( $start_time ) ) $where[] = "`login_time` >= '".$_GET[ 'start_time' ]."'";
        if ( !empty( $end_time ) ) $where[] = "`login_time` <= '". $_GET[ 'end_time' ]."'";
        $condition = implode(' AND ', $where);
        //班级信息 构造数据
        $class_id = $this->Study_Select_Course_Model->getOne( "`user_id`=" .$id,"course_class_id" );
        $class = $this->Study_Course_Class_Model->getOne( "`id` =" . $class_id[ 'course_class_id' ] );
        $log = $this->User_Login_Log_Model->getAll( $condition );
        $count = $this->User_Login_Log_Model->getCount( $condition );
        //计算一共的时间长
        $timeCount = $this->User_Login_Log_Model->getTimeCount( $condition );

        //构造返回数据
        $results = array(
            "log"       => $log,
            'count'     => $count,
            "timecount" => $timeCount,
            "student"   => $student,
            'class'     => $class,
            "get"       => $_GET
            );
        
        $this->setComponent( 'study_cartogram', $results );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 教师角色 学习日志
     */

    function learninglog( $id )
    {
        $where = "`user_id` =" . $id;
        $student = $this->User_Model->getOne( "`id` = " . $id );
        //班级信息   构造数据
        $class_id = $this->Study_Select_Course_Model->getOne( "`user_id`=" .$id,"course_class_id" );
        $class = $this->Study_Course_Class_Model->getOne( "`id` =" . $class_id[ 'course_class_id' ] );
        //学习记录
        $list = $this->Study_Course_Log_Model->getAll( $where, '*', 'id desc' );
        $study_counts = array();
        $study_times = array();
        foreach ( $list as $key => $value )
        {
            $list[ $key ][ 'content' ] = $this->Study_Coursecontent_Model->getOne( "`id` =" . $value[ 'content_id' ] );
            $study_counts[ ] = $value[ 'read_num' ];
            $study_times[ ] = $value[ 'study_time' ];
        }
        $count = $this->Study_Course_Log_Model->getCount( $where );
        //学习次数
        $study_count = array_sum( $study_counts );
        //学习时长
        $study_time = array_sum( $study_times );
        //构造返回数据
        $results = array(
            "list"        => $list,
            "study_count" => $study_count,
            "study_time"  => $study_time,
            'student'        => $student,
            'class'       => $class
        );
        $this->setComponent( 'learninglog', $results );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 教师角色 作业统计
     */

    function jobcount( $id )
    {
        if ( isset( $id ) )
        {
            //参数初始化
            $sum=0;
            $good_work=0;
            $agv=0;
            $data[ 'user' ] = $id;
            $student = $this->User_Model->getOne( array('id' => $id) );
            $where = "`user_id` =" . $this->user[ 'id' ];
            //构造数据
            $list=$this->Study_HomeWork_Model->selectHomeworkLog($where,'gz_study_shijuan.title,gz_study_jiaojuan.*','created desc');
            $count=$this->Study_HomeWork_Model->CountHomeworkLog($where);
            foreach($list as $val){
            $sum+=$val['score'];
            if($val['good_work']=='n'){$good_work+=1;}
            }
            if($sum!='0'&&$count!='0'){
              $agv=$sum/$count;
            }
        }
        $results = array(
            'student'    => $student,
            'list'       => $list,
            'count'      => $count,
            'sum'        => $sum,
            'good_work'  => $good_work,
            'agv'        => $agv
            );
        $this->setComponent( 'jobcount', $results );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 导出excel格式文件
     */

    function loadfile()
    {
        $this->load->library( 'phpexcel/PHPExcel' );
        $this->load->library( 'phpexcel/PHPExcel/IOFactory' );

        //班级列表  构造查询条件
        $course_id = $this->course['id'];
        $students=array();
        $class = $this->Study_Course_Class_Model->getAll( "`course_id` =" . $course_id, '*', 'id asc' );
        //构造数据
        $students= $this->Study_Select_Course_Model->getAll(" `course_id` = ".$this->course['id']." AND `course_part_id` = '10002' AND `status`= 'audit'","user_id");
        if(!empty($students)){
            $mytest=  $this->Study_MyTest_Model->getALL("`course_id` = " .$course_id,'id');
            if($mytest){
            foreach($mytest as $v){
                $test[]=$v['id'];
            }
            $test_id=implode(',', $test);
            }
            $homework=$this->Study_HomeWork_Model->getAll("`course_id` = " .$course_id,'id');
            if($homework){
            foreach($homework as $val){
                $home_work[]=$val["id"];
            }
            $home_id=implode(',', $home_work);
            }
        //处理数组 构造数据
            foreach ( $students as $key => $value ){
                $user = $this->User_Model->getOne( array('id' => $value[ 'user_id' ]) );
                $students[ $key ][ 'user' ] = $user["name"];
                $students[ $key ][ 'student_id' ] = $user["student_id"];
                $time = $this->Study_Class_Doirss_Model->getTime( "`user_id` = " . $value[ 'user_id' ] );
                if(isset($time)){$time="0";}
                $students[ $key ][ 'time' ] = $time[ 'timecount' ];
                $question_count = $this->Study_Question_Model->getCount( '`quser_id` =' . $value[ 'user_id' ] );
                $answer_count = $this->Study_Question_Model->get_answer_count( '`auser_id` =' . $value[ 'user_id' ] );
                $students[ $key ][ 'question' ] = $question_count . "/" . $answer_count;
                unset( $students[ $key ][ 'user_id' ] );
                if(!empty ($home_id))$students[$key]['homework'] = $this->Study_HomeWork_Model->CountHomeworkLog('`user_id` = ' .$value['user_id']." AND `shijuan_id` in(".$home_id.")");
                if(!empty ($test_id))$students[$key]['counttest']=$this->Study_MyTest_Model->CountTest("`id` = " . $value[ 'user_id' ]." AND `zice_id` in(".$test_id.")");
            }
            }else{
                 Util::redirect( '/study_portfolio/index', '没有数据' );
            }
            $objPHPExcel = new PHPExcel();
            //  excel 第一行  表头   第一个参数是列 第二个参数是行
            $objPHPExcel->getProperties()->setTitle( "export" )->setDescription( "none" );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 0, 1, '姓名' );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 1, 1, '学号' );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, 1, '学习时长' );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 3, 1, '提问/回答' );
            if(!empty ($home_id))$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 4, 1, '作业次数' );
            if(!empty ($test_id))$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 5, 1, '自测次数' );
            //循环输出
            foreach ( $students as $k => $v ){
                $i = -1;
                foreach ( $v as $item ){
                    $i++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $i, $k + 2, $item );
                }
            }

        $objPHPExcel->setActiveSheetIndex( 0 );
        $objWriter = IOFactory::createWriter( $objPHPExcel, 'Excel5' );
        header( 'Content-Type: application/vnd.ms-excel' );
        header( 'Content-Disposition: attachment;filename="Products_' . date( 'dMy' ) . '.xls"' );
        header( 'Cache-Control: max-age=0' );
        $objWriter->save( 'php://output' );
    }

}
?>
