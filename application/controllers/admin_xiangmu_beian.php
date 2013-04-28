<?php
include_once('_adminController.php');
class admin_xiangmu_beian extends AdminController{
	function __construct(){
		parent::__construct();

	}
	public function index(){
		$this->setComponent('edit');
		$this->showTemplate('admin_base');
	}
	public function edit(){
		$this->setComponent('edit');
		$this->showTemplate('admin_base');
	}
	public function post(){
		if(isset($_FILES['file_path'])){
             $error = FALSE;
             if ($_FILES["file_path"]["error"] > 0) {
                $error = TRUE;
                //$errormsg[] = "上传的excel文件错误!";
                Util::redirect('/admin_resource_leadin/index', '上传的excel文件错误!');
             }
             //判断扩展名
             $fileext = Util::get_extension($_FILES['file_path']['name']);
             $fileext = strtolower($fileext);
             if(!in_array($fileext, array('xls'))){
                $error = TRUE;
               // $errormsg[] = "文件扩展名错误,只能导入EXCEL文件!!";
                Util::redirect('/admin_resource_leadin/index', '文件扩展名错误,只能导入EXCEL文件!!');
             }
             //判断大小
             if (Util::byteChange($_FILES['file_path']['size'], 'MB') > 5){
                $error = TRUE;
                //$errormsg[] = "文件大小不能超过5MB！";
                Util::redirect('/admin_resource_leadin/index', '文件大小不能超过5MB!');
            }
            if(!$error){
                //处理数据
                $excelFile = $_FILES["file_path"]["tmp_name"];
                $this->load->helper('Excel');
                $datas = Excel::getValues($excelFile, 'Excel5', 0, 1);
               
                if(!empty($datas)){
                    $keys=array_flip($datas[0]);
                    unset($datas[0]);
                    foreach($datas as $k => $v){
                           //判断资源是否存在
                           if(!empty($v[$keys['资源名称']])){
                               $resource_info=$this->Resource_Info_Model->getOne("`name` ='".$v[$keys['资源名称']]."'",'id');
                               if($resource_info){Util::redirect('/admin_resource_leadin/index', '资源已存在！'); }
                           }else{
                               Util::redirect('/admin_resource_leadin/index', '资源名称不能为空！'); 
                           }
                           //判断院系是否存在,不存在：新建，存在，不新建   资源库id  $reid   
                            if(isset($v[$keys['所属专业']])){
                                 $organization=$this->School_Organization_Model->getOne("`name` like'".$v[$keys['所属专业']]."%'",'id');
                                
                                 if($organization){
                                     $org_id=$organization['id'];
                                  }else{
                                     $ordata=array(
                                         'f_id'        =>'0',
                                         'name'        =>$v[$keys['所属专业']],
                                         'description' =>'缺省',
                                         'code'        =>'0000',
                                         'enabled'     =>'y',
                                         'level'       =>'1',
                                         'img'         =>'',
                                         'created'     =>date('Y-m-d H:i:s',  time()),
                                     );
                                    $org_id=$this->School_Organization_Model->insert($ordata);
                                 }
                                 if(isset($org_id)){
                                    $resource_id=$this->Resource_Library_Model->getOne("`organization_id` = '".$org_id."'");
                                     if(empty($resource_id)){
                                         $redata=array(
                                             "name"            => $v[$keys['所属专业']],
                                             "organization_id" => $org_id,
                                             "img"             => '/resource/images/moren.png',
                                             "description"     => '缺省',
                                             "created"         => date('Y-m-d H:i:s',  time()),
                                             "keywords"        => "缺省"
                                         );
                                         $reid=$this->Resource_Library_Model->insert($redata);
                                 }else{
                                     $reid=$resource_id['id'];
                                 }
                            }
                            }
                            //资源分类
                            if(isset($v[$keys['媒体类型']])){
                                $re_cat=$this->Resource_Cat_Model->getOne("`name` = '媒体类型' AND `f_id`='0' AND `library_id` = '".$reid."'",'id');
                                if($re_cat){
                                    $re_id=$re_cat['id'];

                                }else{
                                    $catdata=array(
                                        'name'       =>'媒体类型',
                                        'f_id'       =>'0',
                                        'library_id' =>$reid,
                                        'created'    => date('Y-m-d H:i:s',  time())
                                    );
                                    $new_cat=$this->Resource_Cat_Model->insert($catdata);
                                    if($new_cat){
                                         $re_id=$new_cat;
                                    }else{
                                        Util::redirect('/admin_resource_leadin/index', '顶级分类创建失败！'); 
                                    }
                                }
                               $cats=$this->Resource_Cat_Model->getOne("`name` = '".$v[$keys['媒体类型']]."' AND `f_id`='".$re_id."'",'id');
                               if($cats){
                                    $cat_id=$cats['id'];
                                    }else{
                                        $little_cat=array(
                                            'name' =>$v[$keys['媒体类型']],'f_id'=>$re_id,'library_id'=>$reid,'created'=> date('Y-m-d H:i:s',  time())
                                            );  
                                        $cat_id=$this->Resource_Cat_Model->insert($little_cat);
                                    }  
                            }
                            if(isset($reid) && isset($cat_id)){
                                $resource = array(
                                    "name"  =>$v[$keys['资源名称']],                          //资源名称
                                    "author" => $v[$keys['作者']],                        //作者
                                    "copyright"=>$v[$keys['版权所有人']],                       //版权
                                    "meta_keywords"=>$v[$keys['关键词']],                   //关键词
                                    "library_id" =>$reid,                                     //资源库id  专业id
                                    "target"=>$v[$keys['适用对象']],                          //使用对象
                                    "language" =>$v[$keys['语言']],                       //语言
                                    "created"  =>date('Y-m-d H:i:s',  time()),                //创建时间
                                    "file_path"=>"/upload/resource001/".$v[$keys['资源文件路径']],//源文件路径
                                    "img"=>"/upload/resource001/".$v[$keys['预览文件路径']],     //预览文件路径
                                    "cat_id"=>$cat_id,                                       //文件分类
                                    "resource_source"=>"导入",                               //资源来源
                                    "status"         =>"succeed",
                                    "user_id"  =>  $this->admin['id']                        //上传人
                                    //"dir"=>                                                //一级目录
                                    //"dir_t"=>                                              //二级目录
                                );
                            }else{
                                Util::redirect('/admin_resource_leadin/index', '导入数据失败!'); 
                            }
                            $this->Resource_Info_Model->insert($resource);
                    }
                     Util::redirect('/admin_resource_leadin/index', '导入成功！');
                }else{
                    //$errormsg[] = "导入数据为空";
                    Util::redirect('/admin_resource_leadin/index', '导入数据为空!');
                }
            }
        }else {
            $this->setComponent('resource_leadin');
            $this->showTemplate('admin_base');
        }
	}
}

?>