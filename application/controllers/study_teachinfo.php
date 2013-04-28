<?php
include_once '_studyController.php';

class study_teachinfo extends StudyController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model( "Study_Teachinfo_Model" );
        $this->load->model('Resource_Library_Model');
        $this->load->model('Resource_Info_Model');
        $this->load->model('Resource_Cat_Model');
        $this->load->model('Resource_Comment_Model');
        $this->load->model('Study_Course_Model');
    }

    //学习资料列表
    function index($id=0){
        //构造条件
        $where = array();
        $where[]="`cid` =".$id;
        $where[]="`course_id` = ".$this->course['id'];
        if(!empty($_GET['name']))$where[]="`name` like '%".$_GET['name']."%'";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->Study_Teachinfo_Model->getAll($condition, '*', 'id desc' );
        //构造返回数据
        $result =  array(
            'list'   => $list,
            'dir_id' => $id,
            'get'    => $_GET
        );
        $this->setComponent( 'study_teachinfo', $result );
        $this->showTemplate( 'study_base' );
    }

    //添加  编辑目录
    function adddir()
    {
        if ( $_POST ){
            $data = $_POST[ 'data' ];
            if(empty($data['name'])){echo "<script>alert('请填写组名');parent.$('.iframe').colorbox.close();</script>";die();}
            $id = $data[ 'id' ];
            if ( !empty( $id ) ){
                //构造编辑条件
                $where = '`id` = "' . $id . '"';
                $data[ 'update' ] = date( "Y-m-d H:i:s", time() );
                $this->Study_Teachinfo_Model->update( $data, $where );
                echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
            }else{
                //构造插入条件
                unset ($data['id']);
                $data[ 'update' ] = date( "Y-m-d H:i:s", time() );
                $data[ 'user_id' ] = $this->user['id'];
                $data['course_id'] =$this->course['id'];
                $newid = $this->Study_Teachinfo_Model->insert( $data );
                $newdir=$this->Study_Teachinfo_Model->getOne('`id` =' .$newid);
                //构造上传路径
                if($newdir['cid']==0){
                    $updatepath="/upload/teach_file/".$newid."/";
                }else{
                    $predir=$this->Study_Teachinfo_Model->getOne('`id` =' .$newdir['cid']);
                    $updatepath=$predir['upload_url'].$newid."/";
                }
                $this->Study_Teachinfo_Model->update(array("upload_url"=>$updatepath),"`id` = ".$newid);
                Util::makeDir('.'.$updatepath);
                echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
            }
        }else{
            $info = array();
            $dir_info=array();
            //构造数据
            if ( !empty( $_GET[ 'id' ] ) ){
                $where = '`id` = "' . $_GET[ 'id' ] . '"';
                $info = $this->Study_Teachinfo_Model->getOne( $where );
            }else if(!empty($_GET['dir_id'])){
                $where='`id` = "' . $_GET[ 'dir_id' ] . '"';
                $dir_info = $this->Study_Teachinfo_Model->getOne( $where );
            }

            //构造返回函数
            $result = array(
                  'info'     => $info,
                  'dir_info' =>$dir_info
            );
            $this->setComponent( 'adddir', $result );
            $this->showTemplate( 'base' );
        }
    }

    /*
    * 上传资料
    */

    function uploadinfo($cid = 0)
    {
        $dir=array();
        $dir=$this->Study_Teachinfo_Model->getOne("`id` = " .$cid);
        $result=array(
            'cid'=>$cid,
            'dir'=>$dir
        );
        $this->setComponent( 'uploadinfo' , $result);
        $this->showTemplate( 'base' );
    }

    function upfile($cid)
    {
       //构造数据
       if(empty($_POST['param'])){echo "<script>alert('请选择上传资料');parent.$('.iframe').colorbox.close();</script>";die();}
       $upload_url=$_POST['param'];
       $data=unserialize($_POST['allparam']);
        //构造插入数据
        $param = array(
            'cid'        => $cid,
            'name'       => $data["realname"],
            'course_id'  => $this->course['id'],
            'type'       => $data["file_type"],
            'status'     => "file",
            'update'     => date( "Y-m-d H:i:s", time() ),
            'size'       => $data[ 'file_size' ],
            'user_id'    => $this->user['id'],
            'upload_url' => $upload_url
        );
        $this->Study_Teachinfo_Model->insert( $param );
        echo "<script>parent.$('.iframe').colorbox.close();parent.location.reload();</script>";
    }

    /*
     * 下载文件
     */

    function uploadfile($id){
        $this->load->helper('download');
        $this->load->library('zip');
        //获取要下载的文件夹或文件
        $file=$this->Study_Teachinfo_Model->getOne('`id` = '.$id);

        if($file['status']=='file'){
           $data = file_get_contents(".".$file['upload_url']);
           $this->Study_Teachinfo_Model->update_down(array(),'`id` = '.$file['id']);
           force_download($file['name'], $data);
        }else if($file['status']=='dir'){
             $this->zip->read_dir(".".$file['upload_url']);
             $this->Study_Teachinfo_Model->update_down(array(),'`id` = '.$file['id']);
             $this->zip->download($file['name'].".zip");
        }

    }

    /*
     * 删除
     */

    function delete(){
        if($_POST){
            $deletes_id="";
            foreach($_POST['item_id'] as $value){
                $file=$this->Study_Teachinfo_Model->getOne("`cid` = ".$value);
                if($file){
                     Util::redirect('/study_teachinfo/index',"文件有子文件不可删除!");
                }else{
                    $deletes_id.=$value.",";
                }
            }
           $delete_id=substr($deletes_id,0,strlen($deletes_id)-1);
           $this->Study_Teachinfo_Model->delete("`id` in (".$delete_id.")");
           Util::redirect('/study_teachinfo/index',"删除成功!");
        }

    }


    /*
     * 资源列表
     */
    function resourcestore($library_id = 0, $cat_id = 0){
        $this->load->helper("pagestyleclass_helper");
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        //构造条件
        $course=$this->course['id'];
        $where = array();
        $where[] = "`status` = 'succeed'";
        if(!empty($_GET['name']))$where[]=" `name` like '%".$_GET['name']."%'";
        if(!empty($_GET['cat_id']))$where[] = "(`cat_id` = '".$cat_id."' OR `cat_id` like '".$cat_id.",%' OR `cat_id` like '%,".$cat_id."' OR `cat_id` like '%,".$cat_id.",%')";
        $resource=$this->Study_Course_Model->getOne("`id` = ".$course,'resource_id');
        $where[]="`library_id` = ".$resource['resource_id'];
        $condition = implode(' AND ', $where);
        //构造数据    资源分类  资源列表
        $cat_list=$this->Resource_Cat_Model->getTrees("`library_id` = ".$resource['resource_id'], 'id, f_id, name');
        $list = $this->Resource_Info_Model->getAll($condition, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->Resource_Info_Model->getCount( $condition );
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showWeb_1();
        $result = array(
            'cat_list'       => $cat_list,
            'list'           => $list,
            'count'          => $count,
            'pagination'     => $pagination,
            'pagesize'       => $pagesize,
            'PB_page'        => $PB_page,
            'get'            => $_GET
        );
        $this->setComponent( 'resourcestore',$result);
        $this->showTemplate( 'study_base' );
    }

    /*
     * 添加资源
     */
    
    function resourcestore_add(){
          if($_POST){
            $data = $_POST['data'];
            $id = $data['id'];
            if(!empty($_POST['filepathinfo'])){
                $fileinfo = unserialize($_POST['filepathinfo']);
                if(isset($fileinfo['swfpath']))  $data['swf_path'] = $fileinfo['swfpath'];
                if(isset($fileinfo['flvpath'])) {
                    $data['file_path'] = $fileinfo['flvpath'];
                    $data['swf_path']  = '';
                }
                if(isset($fileinfo['file_type']))  $data['file_type'] = $fileinfo['file_type'];
                if(isset($fileinfo['file_size']))  $data['file_size'] = $fileinfo['file_size'];
            }
            if(!empty($id)){
                $this->Resource_Info_Model->update($data, "id = " . $id);
            }else{
                unset($data['id']);
                $data['created'] = date('Y-m-d H:i:s', time());
                $this->Resource_Info_Model->insert($data);
            }
            Util::redirect('/study_teachinfo/resourcestore');
         }
        $data = '';
        if(!empty($_GET['id'])){
            $data = $this->Resource_Info_Model->getOne("`id` = '".$_GET['id']."'");
        }
        //资源库
        $librarys = $this->Resource_Library_Model->getAll();
        $this->setComponent( 'resourcestore_add', array('data' => $data, 'librarys' => $librarys) );
        $this->showTemplate( 'study_base' );
    }

    /*
     * 资源详细
     */

    function resourcestore_view( $id ){
        //构造数据
        $resource = $this->Resource_Info_Model->getOne("`id` = '".$id."'");
        //构造返回函数
        $result=array(
            'resource' => $resource
        );
        $this->setComponent( 'resourcestore_view',$result );
        $this->showTemplate( 'study_base' );
    }

}
?>
