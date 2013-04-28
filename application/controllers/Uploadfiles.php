<?php
//header("Content-type: text/html; charset=utf8");
set_time_limit(0);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uploadfiles extends CI_Controller {

    public $docroot = "";

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('Util');
        $this->docroot = $_SERVER['DOCUMENT_ROOT'];
    }

    /*
     * 上传文件
     */
    public function saveuploadfile(){
        $fileid             = Util::getPar('fileid');
        $fileinfoid         = Util::getPar('fileinfoid');
        $allowed_extensions = Util::getPar('allowed_extensions');
        $source             = Util::getPar('source');
        $uppath             = Util::getPar('uppath');
        $overwrite          = Util::getPar('overwrite');
        $encrypt_name       = Util::getPar('encrypt_name');
        $chagetoswf         = Util::getPar('chagetoswf');
        $chagetoflv         = Util::getPar('chagetoflv');
        

        if(strtolower($overwrite) == 'true'){
            $overwrite = true;
        }else{
            $overwrite = false;
        }
        if(strtolower($encrypt_name) == 'true'){
            $encrypt_name = true;
        }else{
            $encrypt_name = false;
        }
        $iserror            = false;
		      $result = array();

        //判断参数                    
        if(!isset($_FILES['userfile']['size']) || !isset($_FILES['userfile']['name'])){
                $result['error'] = 1;
                $result['error_content'] = "<img src='/resource/style/images/error.png'><span style='color:red;'>上传失败！</span>";
                $iserror = true;
        }

        //判断文件名是否合法
        if(count(explode('.', $_FILES['userfile']['name'])) >= 3){
                $result['error'] = 1;
                $result['error_content'] = "<img src='/resource/style/images/error.png'><span style='color:red;'>文件命名不合法！</span>";
                $iserror = true;
        }

        //取扩展名
        $fileext = Util::get_extension($_FILES['userfile']['name']);
        $fileext = strtolower($fileext);

        //判断大小
        if(Util::byteChange($_FILES['userfile']['size'], 'MB') > 1024){
                $result['error'] = 1;
                $result['error_content'] = "<img src='/resource/style/images/error.png'><span style='color:red;'>文件大小不能超过1G！</span>";
                $iserror = true;
        }

        //判断扩展名
        if(!empty($allowed_extensions)){
            $extensions = explode('|', $allowed_extensions);
            if(!in_array($fileext, $extensions)){
                $result['error'] = 1;
                $result['error_content'] = "<img src='/resource/style/images/error.png'><span style='color:red;'>只能上传扩展名为".$allowed_extensions."的文件</span>";
                $iserror = true;
            }
        }

        $_uppath = '/upload/'.date('Y-m-d').'/';
        if(!empty($uppath)){
            $uploadpath = $uppath;
        }else{
            $uploadpath = $_uppath;
        }
        $config['upload_path']   = '.'.$uploadpath;
        Util::makeDir($config['upload_path']);
        //$config['allowed_types'] = $allowed_types;
        $config['max_size']      = '0';  //0为不限制
        $config['remove_spaces'] = TRUE; //文件名中的空格将被替换为下划线
        $config['overwrite']     = $overwrite;   //是否覆盖
        $config['encrypt_name']  = $encrypt_name;    //是否重命名
        $this->load->library('upload', $config);
        if(!$iserror){
            if ( ! $this->upload->do_upload()){
                $result['error'] = $this->upload->display_errors();
				            $result['error_content'] = "<img src='/resource/style/images/error.png'><span style='color:red;'>上传失败！</span>";
            }else{
                $result['data'] = $this->upload->data();
                $result['data']['realname']=$_FILES['userfile']['name'];
                $result['filepath'] = $uploadpath.$result['data']['file_name'];
                $result['swfpath'] = '';
                 
                //转换FLV
                if(!empty($chagetoflv) && ($fileext == 'mp3' || $fileext == 'mp4' || $fileext == 'avi' || $fileext == 'rm' || $fileext == 'rmvb' || $fileext == 'mov' || $fileext == 'mp4' || $fileext == '3gp' || $fileext == 'wma')){
                    $cmd = $this->docroot."/application/libraries/exec/ffmpeg.exe -i ".$this->docroot.$result['filepath']." -ab 56 -ar 22050 -b 500 -r 15 -s 320x240 ".$this->docroot.$result['filepath'].".flv";  
                    exec($cmd); 
                    $result['data']['flvpath'] = $uploadpath.$result['data']['file_name'].".flv";
                }
                
                /*
                //转换FLASH
                if(!empty($chagetoswf) && ($fileext == 'doc' || $fileext == 'docx' || $fileext == 'pdf' || $fileext == 'xls' || $fileext == 'xlsx')){
                    //$command = $this->docroot."/application/libraries/exec/flashpaper/FlashPrinter.exe ".$this->docroot.$result['filepath']." -o  ".$this->docroot.$result['filepath'].".swf";
                    $command = $this->docroot."/application/libraries/exec/flashpaper/FlashPrinter.exe -i ".$this->docroot.$result['filepath']."  -ab 64 -ar 16000  ".$this->docroot.$result['filepath'].".swf";
                    exec($command);
                    $result['data']['swfpath'] = $uploadpath.$result['data']['file_name'].".swf";
                }
                */
            }
        }
        $result['fileid']             = $fileid;
        $result['fileinfoid']         = $fileinfoid;
        $result['allowed_extensions'] = $allowed_extensions;
        $result['source']             = $source;
        $result['overwrite']          = $overwrite;
        $result['encrypt_name']       = $encrypt_name;
        $result['uppath']             = $uppath;
	      	$result['chagetoswf']         = $chagetoswf;
	      	$result['chagetoflv']         = $chagetoflv;
        $this->load->view('/uploadfiles/uploadfileform', $result);
    }

     /*
     * 显示上传表单
     */
    public function uploadfileform(){
        $fileid             = Util::getPar('fileid');
        $fileinfoid         = Util::getPar('fileinfoid');
        $defaultvalue       = Util::getPar('defaultvalue');
        $allowed_extensions = Util::getPar('allowed_extensions');
        $source             = Util::getPar('source');
        $overwrite          = Util::getPar('overwrite');
        $encrypt_name       = Util::getPar('encrypt_name');
        $uppath             = Util::getPar('uppath');
		      $chagetoswf         = Util::getPar('chagetoswf');
		      $chagetoflv         = Util::getPar('chagetoflv');
        $result = array(
            'fileid'              =>  $fileid,
            'fileinfoid'          =>  $fileinfoid,
            'allowed_extensions'  =>  $allowed_extensions,
            'defaultvalue'        =>  $defaultvalue,
            'overwrite'           =>  $overwrite,
            'encrypt_name'        =>  $encrypt_name,
            'uppath'              =>  $uppath,
            'source'              =>  $source,
            'chagetoswf'          =>  $chagetoswf,
            'chagetoflv'          =>  $chagetoflv
        );
        $this->load->view('/uploadfiles/uploadfileform', $result);
    }

}