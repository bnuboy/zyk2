<?php
if ( !defined( 'BASEPATH' ) )
  exit( 'No direct script access allowed' );

class convertfile
{
  
  public function __construct( $params = array() )
  {

  }

  //资源加工
  function thread( $id )
  {
    //$CI = & get_instance();
    //$CI->load->model('resourcemodel');
    //异步调用产生预览文件程序
    $current_host = $_SERVER[ 'HTTP_HOST' ]; //获取当前域名
    $get_param = '/convertfile/index?resource_id=' . $id;
    $fp = fsockopen( $current_host, 80, $errno, $errstr, 30 );
    if ( !$fp )
    {
      //echo "$errstr ($errno)<br />\n";
    }
    else
    {
      $out = "GET " . $get_param . "  / HTTP/1.1\r\n";
      $out .= "Host: " . $current_host . "\r\n";
      $out .= "Connection: Close\r\n\r\n";
      fwrite( $fp, $out );
      fclose( $fp );
    }
  }

}
