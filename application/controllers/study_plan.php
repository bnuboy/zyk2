<?php
include_once '_studyController.php';

class study_plan extends StudyController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model( 'Study_Plan_Model' );
        $this->load->library( 'Form_validation' );
        $this->load->model("Study_Coursecontent_Model");
        $this->load->model("Study_Teachinfo_Model");
        $this->load->model("Study_Product_Set_Model");
        $this->load->model("Study_Product_Model");
        $this->load->model("Study_Product_Score_Model");
        $this->load->model("Study_Product_Group_Model");
        $this->load->model("Study_Class_Join_User_Model");
        $this->load->model("Study_MyTest_Model");
        $this->load->model("Study_HomeWork_Model");
        $this->load->model("Study_Course_Class_Model");
        $this->load->model("Study_Class_Join_User_Model");
        $this->load->model("Study_Select_Course_Model");
        $this->load->model("User_Model");
        $this->load->helper( 'form' );
        $this->load->helper( 'Util' );
    }

    /*
     *   列表
     *  $mun 右侧标题
     *  $infos  小节信息,
     *  $user_part 用户角色
     */

    function index( $id=null )
    {
        //构造参数
        $param="";
        $menu=array();
        $mun=array();
        $infos=array();
        //验证用户权限
        if($this->user['type']=="teacher"){
            $user_type='10003';
        }else{
        $user_part= $this->Study_Select_Course_Model->getOne('`user_id` = '.$this->user['id']." AND `course_id` = ".$this->course['id'],'course_part_id');
        if($user_part['course_part_id']!="10003")$param=" And `power` = '1'";
        }

        $menus = $this->Study_Plan_Model->getAll( "`cid` = 0 And `course_id` = ".$this->course["id"].$param, '*', 'order_no asc' );
        if(!empty($menus)){
        //构造查询条件
        $where=array();
        $param="";
        if ( !isset( $id ) )
            $id = $menus[ 0 ][ 'id' ];
        $where[] = 'id = "' . $id .'"';
        $where[]=' cid = 0';
       
        $codition=implode(' AND ', $where);
        //构造返回数据
        $mun = $this->Study_Plan_Model->getOne( $codition, 'id,title',"id asc" );
        if(!empty($_GET['type'])){$param=" AND endtime <= '".date("Y-m-d")."' AND starttime <= '".date("Y-m-d")."'";}
        $infos = $this->Study_Plan_Model->getAll( 'cid = "' . $mun[ 'id' ] . '"'.$param );
        foreach($infos as $key=>$val ){
        switch($val['relevance_type']){
            case $val['relevance_type']='1' : $infos[$key]['relevance']=$this->Study_Teachinfo_Model->getAll("`id` in (".$val['relevance_id'].")","id,name");break;
            case $val['relevance_type']='2' : $infos[$key]['relevance']=$this->Study_HomeWork_Model->getAll("`id` in (".$val['relevance_id'].")","id,title,type_id");break;
            case $val['relevance_type']='3' : $infos[$key]['relevance']=$this->Study_MyTest_Model->getAll("`id` in (".$val['relevance_id'].")","id,title");break;
            case $val['relevance_type']='4' : $infos[$key]['relevance']="";break;
            case $val['relevance_type']='6' : $infos[$key]['relevance']=$this->Study_Coursecontent_Model->getAll("`id` in (".$val['relevance_id'].")","id,title");break;
        }
        }
        }
        $result = array(
            "menus" => $menus,
            "mun" => $mun,
            "infos" => $infos,
            "id" => $id
        );
        $this->setComponent( 'study_plan', $result );
        $this->showTemplate( 'study_plan_base' );
    }

        /*
     * 上移下移
     */
    function move($id,$type){
        //构造条件
        $plan_info=$this->Study_Plan_Model->getOne("`id` = " .$id,"`order_no`, cid");
        if($type=='up'){
            $prev=$this->Study_Plan_Model->getOne("`order_no` <= '".$plan_info['order_no']."' AND `cid` = '".$plan_info['cid']."'", 'id,order_no', 'order_no asc' );
            $data = array( 'order_no' => $prev['order_no']-1 );
            $this->Study_Plan_Model->update($data, "`id` = '".$id."'");
        }else{
            $next=$this->Study_Plan_Model->getOne("`order_no` >'".$plan_info['order_no']."' AND `cid` = '".$plan_info['cid']."'",'id,order_no','order_no asc' );
            if($next && $next['order_no']!=0){
            $data = array( 'order_no' => $next['order_no']+1 );
            $this->Study_Plan_Model->update($data, "`id` = '".$id."'");
            }
        }
       Util::redirect('/study_plan/index/'.$id);
    }

    /*
     *  添加目录
     */

    function addfolder()
    {
        if ( $_POST )
        {
            $data = $_POST[ 'data' ];
            $id = $data[ 'id' ];
            if ( !empty( $id ) )
            {
                $where = '`id` = "' . $id . '"';
                $this->Study_Plan_Model->update( $data, $where );
                Util::redirect( '/study_plan/index', '编辑成功!' );
            }
            else
            {
                unset( $data[ 'id' ] );
                if ( strtotime( $data[ 'starttime' ] ) > strtotime( $data[ 'endtime' ] ) )
                {
                    $this->fail( '开始跟结束时间有误' );
                }
                $data['course_id']=  $this->course['id'];
                $newid = $this->Study_Plan_Model->insert( $data );
                Util::redirect( '/study_plan/index', '添加成功!' );
            }
        }
        else
        {
           //显示列表
           $param="";
           if($this->user['type']=="teacher"){
              $user_type='10003';
            }else{
                $user_part= $this->Study_Select_Course_Model->getOne('`user_id` = '.$this->user['id']." AND `course_id` = ".$this->course['id'],'course_part_id');
                if($user_part['course_part_id']!="10003")$param=" And `power` = '1'";
            }
            $menus = $this->Study_Plan_Model->getAll( "`cid` = 0 And `course_id` = ".$this->course["id"].$param, '*', 'id asc' );
            $info = array();
            if ( !empty( $_GET[ 'id' ] ) )
            {
                $where = '`id` = "' . $_GET[ 'id' ] . '"';
                $info = $this->Study_Plan_Model->getOne( $where );
            }
            //构造返回数据
            $result = array(
                'info' => $info,
                'menus' => $menus
            );
            $this->setComponent( 'addfolder', $result );
            $this->showTemplate( 'study_plan_base' );
        }
    }

    /*
     *  添加教学单元
     */

    function addunit()
    {
        //构造判断条件
        $cid = empty( $_GET[ 'cid' ] ) ? '' : $_GET[ 'cid' ];
        if ( $_POST )
        {
            $data = $_POST[ 'data' ];
            $id = $data[ 'id' ];
            if ( !empty( $id ) )
            {
                $where = '`id` = "' . $id . '"';
                if($data['relevance_type']==""){$data['relevance_type']=null;$data['relevance_id']=null;}
                //修改作品设置
                if($_POST['param']){
                    $set=$this->Study_Product_Set_Model->getOne("`plan_id` = ".$id);
                    $param=$_POST['param'];
                    if($set){
                        $this->Study_Product_Set_Model->update($param,"`plan_id` = ".$id);
                    }else{
                        $param['plan_id']=$id;
                        $this->Study_Product_Set_Model->insert($param);
                    }
                }
                //修改分组
                if($_POST['group']){
                    $group_str=substr($_POST['group'], 0, -1) ;
                    $group=explode(':', $group_str);
                    foreach($group as $val){
                       $team_str=substr($val, 0, -1);
                       $team_stu=explode('.', $team_str);
                       $field=array('0'=>'groupname','1'=>'sid');
                       if(count($team_stu)<=1){$field=array("0"=>"groupname");}
                       $team=array_combine($field, $team_stu);
                       $group_id[]=$this->Study_Product_Group_Model->insert($team);
                    }
                    $data['relevance_id']=implode(',',$group_id);
                } 
                $this->Study_Plan_Model->update( $data, $where );
                Util::redirect( '/study_plan/index/'.$cid, '编辑成功!' );
            }
            else
            {
                unset( $data[ 'id' ] );//print_r($data);exit;
                if($data['relevance_type']==""){unset($data['relevance_type']);}
                if ( !empty( $cid ) )
                {
                    $data[ 'cid' ] = $cid;
                }else{
                    Util::redirect( '/study_plan/index/', '请先添加章节!' );
                }
                //插入组id
               if($_POST['group']){
                    $group_str=substr($_POST['group'], 0, -1) ;
                    $group=explode(':', $group_str);
                    foreach($group as $val){
                       $team_str=substr($val, 0, -1);
                       $team_stu=explode('.', $team_str);
                       $field=array('0'=>'groupname','1'=>'sid');
                       if(count($team_stu)<=1){$field=array("0"=>"groupname");}
                       $team=array_combine($field, $team_stu);
                       $group_id[]=$this->Study_Product_Group_Model->insert($team);
                    }
                    $data['relevance_id']=implode(',',$group_id);
                }
                $data['course_id']=  $this->course['id'];
                $newid = $this->Study_Plan_Model->insert( $data );
               if($_POST['param']){
                    $param=$_POST['param'];
                    $param['plan_id']=$newid;
                    $this->Study_Product_Set_Model->insert($param);
                }

                Util::redirect( '/study_plan/index/'.$cid, '添加成功!' );
            }
        }
        else
        {
           $param="";
           if($this->user['type']=="teacher"){
              $user_type='10003';
            }else{
                $user_part= $this->Study_Select_Course_Model->getOne('`user_id` = '.$this->user['id']." AND `course_id` = ".$this->course['id'],'course_part_id');
                if($user_part['course_part_id']!="10003")$param=" And `power` = '1'";
            }
            $menus = $this->Study_Plan_Model->getAll( "`cid` = 0 And `course_id` = ".$this->course["id"].$param, '*', 'id asc' );
            $info = array();
            if ( !empty( $_GET[ 'id' ] ) )
            {
                $where = '`id` = "' . $_GET[ 'id' ] . '"';
                $info = $this->Study_Plan_Model->getOne( $where );
                if($info['relevance_type']=='5'){
                    $info['relevance']=$this->Study_Product_Set_Model->getOne('`plan_id` = '.$_GET['id']);
                }
            }
            $result = array(
                'info'  => $info,
                'menus' => $menus,
                'id'    => $cid
            );
            $this->setComponent( 'addunit', $result );
            $this->showTemplate( 'study_plan_base' );
        }
    }

    /*
     * 目录下载
     */

    function updown()
    {
        $this->load->helper( 'download' );
        $munid = empty( $_GET[ 'munid' ] ) ? '' : $_GET[ 'munid' ];
        if ( empty( $munid ) )
        {
            Util::redirect( '/study_plan/index', '请选择下载方式!' );
        }
        $datetime = date( 'Y-m-d' );
        $muns = array();
        if ( $munid == 1 )
        {
            $where = 'cid = 0 AND "' . $datetime . '" >= `starttime` AND `endtime` >= "' . $datetime . '"';
            $validmuns = $this->Study_Plan_Model->getAll( $where );
            if ( !empty( $validmuns ) )
            {
                $content = '';
                foreach ( $validmuns as $key => $v )
                {
                    $content .= $v[ 'starttime' ] . '--' . $v[ 'endtime' ] . "\n";
                    $content .= $v[ 'title' ] . "\n";
                    $notie = $this->Study_Plan_Model->getAll( 'cid = "' . $v[ 'id' ] . '"' );
                    foreach ( $notie as $key => $n )
                    {
                        $content .= "\t" . $n[ 'title' ] . "\n";
                        $content .= "\t\t" . $n[ 'content' ] . "\n";
                    }
                }
                $of = fopen( 'validmuns.doc', 'w' ); //创建并打开
                if ( $of )
                {
                    fwrite( $of, $content ); //把执行文件的结果写入txt文件
                }
                fclose( $of );
                force_download( 'validmuns.doc', $content );
            }
            else
            {
                Util::redirect( '/study_plan/index', '当前没有可下载的有效目录' );
            }
        }
        else if ( $munid == 2 )
        {
            $where = 'cid = 0 ';
            $allmuns = $this->Study_Plan_Model->getAll( $where );
            $content = '';
            foreach ( $allmuns as $key => $v )
            {
                $content .= $v[ 'starttime' ] . '--' . $v[ 'endtime' ] . "\n";
                $content .= $v[ 'title' ] . "\n";
                $notie = $this->Study_Plan_Model->getAll( 'cid = "' . $v[ 'id' ] . '"' );
                foreach ( $notie as $key => $n )
                {
                    $content .= "\t" . $n[ 'title' ] . "\n";
                    $content .= "\t\t" . $n[ 'content' ] . "\n";
                }
            }
            $of = fopen( 'allmuns.doc', 'w' ); //创建并打开
            if ( $of )
            {
                fwrite( $of, $content ); //把执行文件的结果写入txt文件
            }
            fclose( $of );
            force_download( 'allmuns.doc', $content );
        }
    }

    /*
     * 删除目录
     */

    function delmun()
    {
        $id = $_GET[ 'id' ];
        $nuits = $this->Study_Plan_Model->getAll( 'cid = "' . $id . '"', 'id' );
        $where = 'cid = "' . $id . '" or id = "' . $id . '"';
        $this->Study_Plan_Model->delete( $where );
        Util::redirect( '/study_plan/index', '删除成功!' );
    }

    /*
     * 删除教学单元
     */

    function delunit()
    {
        $id = $_GET[ 'id' ];
        $where=array();
        $unit=$this->Study_Plan_Model->getAll('`cid` = '.$id,"id");
        foreach($unit as $val){
            $where[]=$val['id'];
        }
        $where []= $id;
        $condition=implode(',', $where);
        //定位
        $pages=$this->Study_Plan_Model->getParents($id);
        $page=array_pop($pages);
        $page_id=$page['id'];
        $this->Study_Plan_Model->delete( "`id` in (".$condition.")" );
        Util::redirect( '/study_plan/index/'.$page_id, '删除成功!' );
    }

    /*
     * 关联教学资料
     */

    function course_resource(){
        $relevance="";
        if($_GET['id']){
            $relevance_info=$this->Study_Plan_Model->getOne('`id` = '.$_GET['id'],'relevance_id');
            $relevance=explode(",", $relevance_info['relevance_id']);
        }
        //构造数据
        $list = $this->Study_Teachinfo_Model->getAll('`id` > 0','id,name','id desc');
        //构造返回数据
        $result = array(
            'list'      => $list,
            "relevance" => $relevance
        );
        $this->setComponent( 'course_resource' ,$result);
        $this->showTemplate( 'base' );
    }

    /*
     * 关联作业
     */

     function homework(){
        $relevance="";
        if($_GET['id']){
            $relevance_info=$this->Study_Plan_Model->getOne('`id` = '.$_GET['id'],'relevance_id');
            $relevance=explode(",", $relevance_info['relevance_id']);
        }
        //构造数据
        $list = $this->Study_HomeWork_Model->getAll('`id` > 0','id,title');
        //构造返回数据
       $result = array(
            'list'      => $list,
            'relevance' => $relevance
        );
        $this->setComponent( 'homework' ,$result);
        $this->showTemplate( 'base' );
    }

    /*
     * 关联 即时讨论
     */
    function webchat($id){
         $param="";
         if($this->user['type']=="teacher"){
            $user_type='10003';
            }else{
            $user_part= $this->Study_Select_Course_Model->getOne('`user_id` = '.$this->user['id']." AND `course_id` = ".$this->course['id'],'course_part_id');
            if($user_part['course_part_id']!="10003")$param=" And `power` = '1'";
           }
        $menus = $this->Study_Plan_Model->getAll( "`cid` = 0 And `course_id` = ".$this->course["id"].$param, '*', 'id asc' );
        $plan_info= $this->Study_Plan_Model->getOne("`id` = ".$id,'content');
        $this->adduserlog($id);
        $result=array(
            'menus'     => $menus,
            'id'        => $id,
            'plan_info' =>$plan_info
        );
        $this->setComponent( 'webchat' ,$result);
        $this->showTemplate( 'study_plan_base' );
    }
    //插入用户记录
    function adduserlog($id){
        $dir = '/upload/webchart/' . date( 'Y' ) . '/' . date( 'md' ) . '/';
        $path = $_SERVER[ 'DOCUMENT_ROOT' ] . $dir;
        @mkdir( $path, 0777, true );
        $user_content=date("H:i:s",time())."@".$this->user['name']."& \r\n";
        file_put_contents($path.$id."_log.txt",$user_content,FILE_APPEND);
    }
    //发言
    function addchart(){
          $this->adduserlog($_POST['id']);
          $dir = '/upload/webchart/' . date( 'Y' ) . '/' . date( 'md' ) . '/';
          $path = $_SERVER[ 'DOCUMENT_ROOT' ] . $dir;
          @mkdir( $path, 0777, true );
          $content=$_POST['time']."@".$this->user['name']."@".$_POST['content']."& \r\n";
          file_put_contents($path.$_POST['id'].".txt",$content,FILE_APPEND);
          $_POST['user']=  $this->user['name'];
          $return=$_POST;
          $this->AJAXSuccess($return);
    }
    /*
     * 获取 所有已发言
     */
    function getchart(){
          $id=$_POST['id'];
          $dir = '/upload/webchart/' . date( 'Y' ) . '/' . date( 'md' ) . '/';
          $path = $_SERVER[ 'DOCUMENT_ROOT' ] . $dir;
          $data=preg_replace('/((\s)*(\n)+(\s)*)/i','',file_get_contents($path.$id.'.txt'));
          $contents=explode('&',$data);
          foreach($contents as $key=>$val){
             if($val=='')unset($contents[$key]);
          }
          foreach($contents as $key=>$val){
             $params[]=explode("@",$val);
          }
          $this->AJAXSuccess($params);
    }
    
    /*
     * 每隔3秒读取最新的数据
     */
    function readnew(){
          //初始化数据
          $id=$_POST['id'];
          $dir = '/upload/webchart/' . date( 'Y' ) . '/' . date( 'md' ) . '/';
          $path = $_SERVER[ 'DOCUMENT_ROOT' ] . $dir;
          //online文件上一次读取的时间
          $file_read_time=time()-3;
          //文件修改时间和读时间比较，大于则无更新，不读；小于则有更新，读。
          if ($file_read_time>filemtime($path.$id.'.txt')) {
              $this->AJAXFail();
          }else{
          $data=preg_replace('/((\s)*(\n)+(\s)*)/i','',file_get_contents($path.$id.'.txt'));
          $contents=explode('&',$data);
          foreach($contents as $key=>$val){
             if($val=='')unset($contents[$key]);
          }
          foreach($contents as $key=>$val){
             $params[]=explode("@",$val);
          }
          $count=count($params)-1;
          $return=$params[$count];
          if($return['1']==$this->user['name']){
                $this->AJAXFail();
          }
          $this->AJAXSuccess($return);
          }
    }
    /*
     * 用户列表
     */
    function getuser(){
        $id=$_POST['id'];
        $dir = '/upload/webchart/' . date( 'Y' ) . '/' . date( 'md' ) . '/';
        $path = $_SERVER[ 'DOCUMENT_ROOT' ] . $dir;
        $data=preg_replace('/((\s)*(\n)+(\s)*)/i','',file_get_contents($path.$id.'_log.txt'));
        $contents=explode('&',$data);
        foreach($contents as $key=>$val){
            if($val=='')unset($contents[$key]);
          }
        foreach($contents as $key=>$val){
            $params[]=explode("@",$val);
          }
        foreach($params as $param){
              $return[$param[0]]=$param['1'];
          }
       $return=array_reverse($return);
       $return=array_unique($return);
       foreach($return as $k=>$v){
           $time=abs(strtotime(date("H:i:s",time()))-strtotime($k));
           $time_diff=str_pad(floor($time%3600/60),2,0,STR_PAD_LEFT);
           if($time_diff>=1){
               unset($return[$k]);
           }
       }
      $count=count($return);
      $result=array(
           '0' =>$return,
           '1' =>$count
      );
      $this->AJAXSuccess($result);
    }



    /*
     * 关联自测 self testing
     */

    function selftesting(){
        $relevance="";
        if($_GET['id']){
            $relevance_info=$this->Study_Plan_Model->getOne('`id` = '.$_GET['id'],'relevance_id');
            $relevance=explode(",", $relevance_info['relevance_id']);
        }
        //构造数据
        $list  = $this->Study_MyTest_Model->getAll('`id` > 0','id,title');
        //构造返回数据
        $result = array(
            'list'      => $list,
            'relevance' => $relevance
        );
        $this->setComponent( 'selftesting' ,$result);
        $this->showTemplate( 'base' );
    }

    /*
     * 关联课程内容
     */
    function course_content(){
        //初始化数据
        $relevance="";
        if($_GET['id']){
            $relevance_info=$this->Study_Plan_Model->getOne('`id` = '.$_GET['id'],'relevance_id');
            $relevance=explode(",", $relevance_info['relevance_id']);
        }
        //构造数据
        $list = $this->Study_Coursecontent_Model->getAll();
        //构造返回数据
        $result = array(
            "list"      => $list,
            "relevance" => $relevance
        );
        $this->setComponent( 'course_content' ,$result);
        $this->showTemplate( 'base' );
    }

    /*
     * 上传作品
     */
    
    function upproduct($plan_id){
        $user_type=  $this->Study_Select_Course_Model->getOne("`user_id` = " .$this->user['id']);
        if($user_type['course_part_id']=="10003" || $this->user['type']=="teacher"){Util::redirect( '/study_plan/index/', '教师不可上传作品!' );}
        $plan=$this->Study_Plan_Model->getOne("`id` = " .$plan_id);
        if(!empty($plan['relevance_id'])){
            $team=$this->Study_Product_Group_Model->getAll('`id` in ('.$plan["relevance_id"].")");
            foreach($team as $val){
                $sid=explode(',',$val['sid']);
                if(in_array($this->user['id'],$sid)){
                 $product=$this->Study_Product_Model->getALL('`plan_id` = '.$plan_id." AND `user_id` in (" .$val['sid'].")" );
                if(!empty($product)){
                        Util::redirect( '/study_plan/index/', '已有人上传作品!' );
                  }
                }
            }
        }
        if($_POST){
            $data=$_POST['data'];
            $data['user_id']=$this->user['id'];
            $data['up_time']=date("Y-m-d H:i:s",  time());
            $this->Study_Product_Model->insert($data);
            Util::redirect( '/study_plan/index', '上传成功!' );
        }else{
        //构造数据
        $menus = $this->Study_Plan_Model->getAll( "cid = 0", '*', 'id asc' );
        //构造返回数据
        $result=array(
             'menus'   => $menus,
             'plan_id' => $plan_id
        );
        $this->setComponent( 'upproduct',$result);
        $this->showTemplate( 'study_plan_base' );
       }
    }

    /*
     * 作品列表
     * $product_set 作品设置
     * $count  学生互评总分 老师评分
     * $menus  左侧菜单
     */
    function productlist($id){
        //构造条件
        $where="`plan_id` = ".$id;
        if(!empty($_GET['name'])){
            $where.=" And `name` like '%" .$_GET['name']."%'";
        }
        //构造数据
        $menus = $this->Study_Plan_Model->getAll( "cid = 0", '*', 'id asc' );
        $list=$this->Study_Product_Model->getALl($where);
        $product_set=$this->Study_Product_Set_Model->getOne('`plan_id` = '.$id);
        foreach($list as $key=>$val){
            $list[$key]['username']=$this->User_Model->getOne('`id` = ' .$val['user_id'],'name');
            $list[$key]['teascore']=$this->Study_Product_Score_Model->teaCommont(array('product_id'=>$val['id']));
            $list[$key]['stuscore']=0;
            if($product_set['type']!='2'){
            $list[$key]['stuscore']=$this->Study_Product_Score_Model->stuCommont(array('product_id'=>$val['id']));
            }
            $list[$key]['sumscore']=($list[$key]['teascore']*((100-$product_set['stu_weight'])/100)+$list[$key]['stuscore']*$product_set['stu_weight']/100)/5*$product_set['score'];
        }
        $result=array(
             'list'   => $list,
             'menus'  => $menus,
             'id'     => $id,
             'get'    => $_GET
        );
        $this->setComponent( 'productlist',$result);
        $this->showTemplate( 'study_plan_base' );
    }
    /*
     * 批阅作品
     * @param array $count 学生老师评分
     * @param int sumcount 总评分
     * @param int $product_set 计划对作品的设置
     */
    function product_view($id){
        //左侧菜单
        $menus = $this->Study_Plan_Model->getAll( "cid = 0", '*', 'id asc' );
        //修改 作品状态为批阅
        $this->Study_Product_Model->update(array("status"=>'2'),"`id` = ".$id);
        //作品信息
        $product=$this->Study_Product_Model->getOne('`id` = '.$id);
        //作品评价
        $comment=$this->Study_Product_Score_Model->getALL("`product_id` = " .$id);
        $product_set=$this->Study_Product_Set_Model->getOne('`plan_id` = '.$product['plan_id']);
        //评分
        $teascore=$this->Study_Product_Score_Model->teaCommont(array('product_id'=>$id));
        $stuscore=0;
        if($product_set['type']!='2'){
            $stuscore=$this->Study_Product_Score_Model->stuCommont(array('product_id'=>$id));
         }
        $sumcount=($teascore*((100-$product_set['stu_weight'])/100)+$stuscore*$product_set['stu_weight']/100)/5*$product_set['score'];
        $user_type=$this->Study_Class_Join_User_Model->getOne('`user_id` = '.$this->user['id'],'part_id');
        foreach($comment as $key=>$val){
            $comment[$key]['user']=$this->User_Model->getOne('`id` = ' .$val['user_id'],'name,face');
        }
        $result=array(
             'menus'        => $menus,
             'product'      => $product,
             'comment'      => $comment,
             'teascore'     => $teascore,
             'stuscore'     => $stuscore,
             'sumcount'     => $sumcount,
             'product_set'  => $product_set,
             'user_type'    => $user_type
        );
        $this->setComponent( 'productview',$result);
        $this->showTemplate( 'study_plan_base' );
    }
    /*
     * 作品评价
     */

    function product_comment_addup($id){
        if($_POST){
            //一个人只能评一次分
            $product=$this->Study_Product_Score_Model->getOne('`user_id` = '.$this->user['id']);
            if(!empty($product)){
                $_POST['score']=$product['score'];
            }
            
            $data=array(
                'product_id'   => $id,
                'user_id'      => $this->user['id'],
                'comment_time' => date("Y-m-d H:i:s",  time()),
                'content'      =>$_POST['content'],
                'score'        => $_POST['score']
            );
            $this->Study_Product_Score_Model->insert($data);
            $this->AJAXSuccess( '' );
        }
    }

    /*
     * 分组
     */

    function group(){
        $course_id=$this->course["id"];
        //构造 学生列表
        $student=$this->Study_Select_Course_Model->getAll("`course_id` = ".$course_id." AND `course_part_id` ='10002'",'user_id');
        if(empty($student)){
            echo "<script>alert('还没有导入学生'); parent.$('.iframe').colorbox.close();</script>";die();
        }
        foreach($student as $value){
            $students[]=$value['user_id'];
        }
        $student_id=implode(',', $students);
        $student_info=$this->User_Model->getAll("`id` in (".$student_id.")");
        $result=array(
            'student_info'  => $student_info,
        );
        $this->setComponent( 'producgroup',$result);
        $this->showTemplate( 'base' );
    }

   function adddir(){
           $group_id='';
            if($_GET){
                $group_id=$_GET['id'];
            }
            $result=array(
                'group_id' => $group_id
            );
            $this->setComponent( 'adddir',$result);
            $this->showTemplate( 'base' );
    }

}
?>
