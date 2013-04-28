<?php
/*
 * 代码编写者：温晓军
 * 公司：颐达合创
 * 代码首次编写日期：2012-07-23
 */

include_once '_studyController.php';

class study_course_resource extends StudyController{

    function __construct(){
        parent::__construct();
        $this->load->library( 'adminpagination' );
        $this->load->model("Study_Course_Rescource_Model");
        $this->load->model("Study_Course_Model");
        $this->load->helper('file');
    }

    /*
     * 课程资源列表
     */

    function index(){
        $course_id=$this->course['id'];
        //构造条件
        $where = array();
        $where[]="`status` =2";
        $where[]="`course_id` = ".$course_id;
        if(!empty($_GET['name']))$where[]="`name` like '%".$_GET['name']."%'";
        $condition = implode(' AND ', $where);
        //构造数据
        $list=  $this->Study_Course_Rescource_Model->getAll($condition,"*","id desc");
        $result=array(
            "list"      => $list,
            "course_id" => $course_id,
            'get'       => $_GET
        );
        $this->setComponent( 'study_course_resource', $result);
        $this->showTemplate( 'study_base' );
    }
    
    /*
     * 其他课程资源
     */
    function anthorcourse(){
        //构造条件
        $course_id=$this->course['id'];
        $where = array();
        $where[]="`status` =1";
        $where[]="`course_id` = ".$course_id;
        $condition = implode(' AND ', $where);
        //构造数据
        $list=  $this->Study_Course_Rescource_Model->getAll($condition,"*","id desc");
        foreach($list as $key=>$val){
            $list[$key]['course_name']=$this->Study_Course_Model->getOne("`id` = " .$val['course_id']);
        }
        //构造返回数据
        $result=array(
            "list"      => $list
        );
        $this->setComponent( 'study_anthorcourse', $result);
        $this->showTemplate( 'study_base' );
    }

    /*
     * 共享资源
     */
    function upfile($course_id=''){
        if($_POST){
            if($_POST['param']){
            //初始化数据
            $file_path=$_POST["param"];
            $params=unserialize($_POST["allparam"]);
            $data=array(
                'status'    => "1",
                'name'      => $params['file_name'],
                'type'      => $params['file_type'],
                'file_size' => $params['file_size'],
                'load_time'    => date( "Y-m-d H:i:s", time() ),
                'file_path' => $file_path,
                'course_id' => $_POST['course_id']
            );
            $this->Study_Course_Rescource_Model->insert($data);
            Util::redirect('/study_course_resource/anthorcourse',"上传成功!");
            }else{
            Util::redirect('/study_course_resource/upfile/'.$course_id,"请选择上传资料!");
            }
        }
        $result=array(
            "course_id" => $course_id
        );
        $this->setComponent( 'course_resource_upfile',$result);
        $this->showTemplate( 'study_base' );
    }

    /*
     * 导出课程资源
     */
    function exportfile($course_id =''){
        if($_POST){
            //构造数据
            foreach($_POST['item_id'] as $value){
                if($value=="1"){
                    $data['notice']=$this->Study_Course_Rescource_Model->getALLData("gz_study_coursenotice");
                }else if($value=="2"){
                    $data['class']=$this->Study_Course_Rescource_Model->getALLData("gz_study_course_class");
                    $data['user_class']=$this->Study_Course_Rescource_Model->getALLData("gz_study_class_join_user");
                }else if($value=="3"){
                    $data['line_quertion']=$this->Study_Course_Rescource_Model->getALLData("gz_study_line_question");
                    $data['line_answer']=$this->Study_Course_Rescource_Model->getALLData("gz_study_line_answer");
                }else if($value=="4"){
                    $data['content']=$this->Study_Course_Rescource_Model->getALLData("gz_study_coursecontent");
                }else if($value=="5"){
                    $data['teachinfo']=$this->Study_Course_Rescource_Model->getALLData("gz_study_teachinfo");
                }  
            }
          $data['course_info']=$this->Study_Course_Rescource_Model->getAllData("gz_study_course");
          //生成xls
          $path=$this->phpexcel($data,$_POST['name']);
          //压缩xls
          $url =  'upload/load_course_file/' . date( 'Y' )."/";
          $this->load->library('zip');
          $this->zip->read_dir($path,FALSE);
          $this->zip->archive($url.$_POST['name'].'.zip');
          delete_files($path,true);
          //插入数据
          $size=get_file_info($url.$_POST['name'].'.zip',"size");
          $param=array(
               'status'    => "2",
               'name'      => $_POST['name'],
               'type'      => ".zip",
               'file_size' => $size['size'],
               'update'    => date( "Y-m-d H:i:s", time() ),
               'file_path' => $url.$_POST['name'].'.zip',
               'course_id' => $_POST['course_id']
          );
          $this->Study_Course_Rescource_Model->insert($param);
          echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
          die();
        }
        //构造数据
        $this->load->model("Front_Power_Menu_Model");
        $list=$this->Front_Power_Menu_Model->getAll("`f_id` = 0");
        $result=array(
            "list"       => $list,
            "course_id" => $course_id
        );
        $this->setComponent( 'course_resource_export',$result);
        $this->showTemplate( 'base' );
    }

    function phpexcel($data,$filename){
        $this->load->library( 'phpexcel/PHPExcel' );
        $this->load->library( 'phpexcel/PHPExcel/IOFactory' );
        foreach($data as $das=>$value){
            $objPHPExcel = new PHPExcel();
            //  excel 第一行  表头   第一个参数是列 第二个参数是行
            $objPHPExcel->getProperties()->setTitle( "export" )->setDescription( "none" );
            foreach($value['title'] as $key=>$val){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $key, 1, $val );
            }
            //循环输出
            foreach ( $value['param'] as $k => $v ){
                $i = -1;
                foreach ( $v as $item ){
                    $i++;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $i, $k + 2, $item );
                }
            }

            $dir = 'upload/load_course_file/' . date( 'Y' ) . '/' . $filename . '/';
            @mkdir( $dir, 0777, true );
            $objPHPExcel->setActiveSheetIndex( 0 );
            $objWriter = IOFactory::createWriter( $objPHPExcel, 'Excel5' );
            $file=$das.".xls";
            $objWriter->save($dir.$file);
         }
          return $dir;
    }

    /*
     * 导入资源
     */
    function importcourse(){
        //构造数据
        $this->load->helper('Excel');
        $zip = new ZipArchive();
        $resource_id=implode(",", $_POST["item_id"]);
        $list=$this->Study_Course_Rescource_Model->getALl("`id` in (".$resource_id.")","file_path");
        foreach($list as $val){
            $return= $zip->open('.'.$val['file_path']);
            if($return){
                if(file_exists(".".$val['file_path'])){
                $url=explode(".",$val['file_path']);
                $re=$zip->extractTo('.'.$url[0]."/");
                if($re){
                        $sql="";
                        $filename=get_filenames('.'.$url[0]."/",true);
                        foreach($filename as $file){
                        $key=basename( $file );
                        $datas=Excel::getValues($file);
                        $cname=substr("`".implode("`,`" , $datas[0])."`",stripos("`".implode("`,`" , $datas[0])."`", ",")+1);
                        $param=$datas[0];
                        unset($datas[0]);
                        $vals="";               
                        foreach($datas as $k => $v){
                            $v=array_combine($param,$v);
                            if($k=="course_id")$v['course_id'] =$this->course['id'];
                            $str="'".implode("','" , $v)."'";
                            $data = substr($str,stripos($str, ",")+1);
                            $vals .= "(".$data.")";
                            if($k < count($datas)) $vals .= ","; 
                        };
                        if(!empty($vals)){
                        if($key=='class.xls'){
                            $sql.="insert into gz_study_course_class(".$cname.") values ".$vals;
                            $sql.=";";
                        }else if($key=='content.xls'){
                            $sql.="insert into gz_study_coursecontent(".$cname.") values ".$vals;
                            $sql.=";";
                        }else if($key=='line_answer.xls'){
                            $sql.="insert into gz_study_line_answer (".$cname.") values ".$vals;
                            $sql.=";";
                        }else if($key=='line_quertion.xls'){
                            $sql.="insert into gz_study_line_question (".$cname.") values ".$vals;
                            $sql.=";";
                        }else if($key=='notice.xls'){
                            $sql.="insert into gz_study_coursenotice (".$cname.") values ".$vals;
                            $sql.=";";
                        }else if($key=='user_class.xls'){
                            $sql.="insert into gz_study_class_join_user (".$cname.") values ".$vals;
                            $sql.=";";
                        }else if($key=='teachinfo.xls'){
                            $sql.="insert into gz_study_teachinfo (".$cname.") values ".$vals;
                            $sql.=";";
                        }
                        }
                        }
                        $this->Study_Course_Rescource_Model->insertAllData($sql);
                         Util::redirect('/study_course_resource',"导入成功!");
                 }
               $zip->close();
            }else{
                 Util::redirect('/study_course_resource',"未找到此资源!");
            }
            }
        }
    }

    /*
     * 删除
     */
    function delete(){
        if($_POST){
            $delete_id=implode(",",$_POST['item_id']);
            $this->Study_Course_Rescource_Model->delete("`id` in (".$delete_id.")");
            Util::redirect('/study_course_resource/index',"删除成功!");
        }
    }

    /*
     * 重命名
     */
    function rename(){
        if($_POST){
            $data["name"]=$_POST[ 'data' ]['name'];
            if(empty($data['name'])){echo "<script>alert('请填写新名字');parent.$('.iframe').colorbox.close();</script>";die();}
            $this->Study_Course_Rescource_Model->update($data,'`id` = '.$_POST[ 'data' ]['id']);
            echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
            die();
        }
        $id=$_GET["id"];
        $data=$this->Study_Course_Rescource_Model->getOne("`id` = ".$id);
        $result=array(
            'data' => $data
        );
        $this->setComponent( 'rename',$result);
        $this->showTemplate( 'base' );
    }
}
?>