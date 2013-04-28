<?php
set_time_limit(0);
ini_set('post_max_size','1024M');
ini_set('upload_max_filesize','1024M');
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class swfupload extends CI_Controller
{
    public $docroot = "";

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('Util');
        $this->docroot = $_SERVER['DOCUMENT_ROOT'];
    }

    public function uploadform()
    {
        $fileid  = Util::getPar('fileid');
        $fileinfo  = Util::getPar('fileinfo');
        $this->load->view( '/swfupload/upload',array("fileid"=>$fileid,'fileinfo'=>$fileinfo));
    }

    public function uploadfileform()
    {
        //返回的参数
        $return=array();
        $updir = "./upload/"; //上传目录
        $renamed = "1"; //是否重命名1表示重命名0表示用原来的文件名
        $overwrite = "1"; //是否覆盖1表示覆盖0表示不覆盖
        if ( isset( $_FILES[ "Filedata" ] ) && is_uploaded_file( $_FILES[ "Filedata" ][ "tmp_name" ] ) && $_FILES[ "Filedata" ][ "error" ] == 0 )
        {
            //上传文件赋值给$upload_file
            $upload_file = $_FILES[ "Filedata" ];
            //获取文件类型
            $file_info = pathinfo( $upload_file[ "name" ] );
            //获取文件扩展名
            $file_ext = $file_info[ "extension" ];
            //设置路径方式
            $m_dir = date( "Y-m-d" ). "/";
            //设置上传的路径
            $upload_path = $updir . $m_dir;
            //建立文件夹
            Util::makeDir($upload_path);
            //需要重命名的
            if ( $renamed )
            {
                $attr = array(
                    'doc','xls','xlsx','docx'
                );
                list($usec, $sec) = explode( " ", microtime() );
                if(in_array($file_ext, $attr)){
                    $upload_file[ 'name' ] = substr( $usec, 2 ) . '.' . $file_ext.'.pdf';
                }else{
                    $upload_file[ 'name' ] = substr( $usec, 2 ) . '.' . $file_ext;
                }
                //unset($usec);
                unset( $sec );
            }
            //设置默认服务端文件名
            $upload_file[ 'filename' ] = $upload_path . $upload_file[ 'name' ];


            //检查文件是否存在
            if ( file_exists( $upload_file[ 'filename' ] ) )
            {
                if ( $overwrite )
                {
                    @unlink( $upload_file[ 'filename' ] );
                }
                else
                {
                    $j = 0;
                    do
                    {
                        $j++;
                        $temp_file = str_replace( '.' . $file_ext, '(' . $j . ').' . $file_ext, $upload_file[ 'filename' ] );
                    }
                    while ( file_exists( $temp_file ) );
                    $upload_file[ 'filename' ] = $temp_file;
                    unset( $temp_file );
                    unset( $j );
                }
            }


            if ( @move_uploaded_file( $upload_file[ "tmp_name" ], $upload_file[ "filename" ] ) )
            {
                   //转换FLV
                if( ($file_ext == 'mp3' || $file_ext == 'mp4' || $file_ext == 'avi' || $file_ext == 'rm' || $file_ext == 'rmvb' || $file_ext == 'mov' || $file_ext == 'mp4' || $file_ext == '3gp' || $file_ext == 'wma')){
                    $cmd = $this->docroot."/application/libraries/exec/ffmpeg.exe -i ".$this->docroot.substr($upload_file["filename"], 1)." -ab 56 -ar 22050 -b 500 -r 15 -s 320x240 ".$this->docroot.substr($upload_file["filename"], 1,strripos( $upload_file["filename"], '.' )-1).".flv";
                    exec($cmd);
                    $return['flvpath'] = substr($upload_file["filename"], 1,strripos( $upload_file["filename"], '.' )-1).".flv";
                }
                
                
                //转换FLASH
                if( ($file_ext == 'doc' || $file_ext == 'docx' || $file_ext == 'pdf' || $file_ext == 'xls' || $file_ext == 'xlsx')){                                 
                   // $command = $this->docroot."/application/libraries/exec/flashpaper/FlashPrinter.exe ".$this->docroot.substr($upload_file["filename"], 1)." -o  ".$this->docroot.substr($upload_file["filename"], 1,strripos( $upload_file["filename"], '.' )-1).".swf";
                  //  exec($command);
                    $return['swfpath'] = substr($upload_file["filename"], 1,strripos( $upload_file["filename"], '.' )-1).".pdf";
                }
                
                $return['file_type']=substr($upload_file["name"], stripos($upload_file["name"],'.')+1);
                $return['file_size']=$upload_file["size"];
                echo "FILEURL:".$upload_file['filename']."&".serialize($return);
            }
            else
            {
                echo '上传失败';
            }
        }
        else
        {
            echo '请选择上传的文件';
        }
    }

}