<?php
if ( !defined( 'BASEPATH' ) )
  exit( 'No direct script access allowed' );

class adminpagination
{
  var $base_url = '';
  var $total_rows = 0;
  var $per_page = 10;

  public function __construct( $params = array() )
  {

  }

  function initialize( $params = array() )
  {
    if ( count( $params ) > 0 )
    {
      foreach ( $params as $key => $val )
      {
        if ( isset( $this->$key ) )
        {
          $this->$key = $val;
        }
      }
    }
  }

  function create_links( $param_num = 3 )
  {
    if ( $this->total_rows == 0 || $this->per_page == 0 )
    {
      return '';
    }

    $num_pages = ceil( $this->total_rows / $this->per_page );

    $CI = & get_instance();
    $cur_page = $CI->uri->segment( $param_num );

    $get = $CI->input->get();
   
    if ( $get )
    {
      foreach ( $get as $key => $value )
      {
        $get[ $key ] = $key . "=" . $value;
      }
      $get_url = '?' . implode( '&', $get );
    }
    else
    {
      $get_url = '';
    }

    $cur_page_num = floor( ($cur_page / $this->per_page) + 1 );

    if ( $num_pages == 1 )
    {
      //return '';
    }

    $pre_link_num = 0;
    if ( $cur_page_num > 1 )
      $pre_link_num = ($cur_page_num - 2 ) * $this->per_page;

    $this->base_url = rtrim( $this->base_url, '/' ) . '/';

    $pre_link = $this->base_url . $pre_link_num;

    $next_link_num = ($cur_page_num - 1 ) * $this->per_page;
    if ( $cur_page_num < $num_pages )
      $next_link_num = $cur_page_num * $this->per_page;

    $next_link = $this->base_url . $next_link_num;

    $start_page_link = $this->base_url . '0';
    $end_page_link = $this->base_url . ($num_pages - 1) * $this->per_page;

    $pre_link .= $get_url;
    $next_link .= $get_url;
    $start_page_link .= $get_url;
    $end_page_link .= $get_url;


    $output = '
      <script>
      function jump_page(){
        var page =  $(".page_input:eq(0)").val();
        if( page < 1 || page > ' . $num_pages . ' ){
          return ;2
        }
        location.href="' . $this->base_url . '"+(page - 1) * ' . $this->per_page . '+"' . $get_url . '";
      }
      function pagekeyup(obj){
        $(".page_input").val( $(obj).val() );
      }
      </script>
       <div class="datapkate">
        <div class="datajump">
          <div class="datajumpin"><input class="page_input" onkeyup="pagekeyup(this)" type="text" maxlength="4" value="1"/></div>
          <div class="datajumpbut"><input type="button" onclick="jump_page()" class="jumpcolor" value="转到"/></div>
        </div>
        <div class="pagenext"><a href="' . $next_link . '"><strong>下一页</strong></a></div>
        <div class="pagenum">' . $cur_page_num . '/' . $num_pages . '</div>
        <div class="pageup"><a href="' . $pre_link . '"><strong>上一页</strong></a></div>
        <div class="pagenum"><a href="' . $end_page_link . '" title="末页">末页</a></div>
        <div class="pagenum"><a href="' . $start_page_link . '" title="首页">首页</a></div>
      </div>';

    return $output;
  }

}
