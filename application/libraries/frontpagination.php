<?php
if ( !defined( 'BASEPATH' ) )
  exit( 'No direct script access allowed' );

class frontpagination {
  var $base_url = '';
  var $total_rows = 0;
  var $per_page = 10;

  public function __construct( $params = array() ) {

  }

  function initialize( $params = array() ) {
    if ( count( $params ) > 0 ) {
      foreach ( $params as $key => $val ) {
        if ( isset( $this->$key ) ) {
          $this->$key = $val;
        }
      }
    }
  }

  function create_links( $param_num = 5 ) {
    if ( $this->total_rows == 0 || $this->per_page == 0 ) {
      return '';
    }

    /*
    * $num_pages ：总的页数
    * $this->per_page: 每页显示的条数
    */
    $num_pages = ceil( $this->total_rows / $this->per_page );

    $CI = & get_instance();
    $cur_page = $CI->uri->segment( $param_num );

    $get = $CI->input->get();

    if ( $get ) {
      foreach ( $get as $key => $value ) {
        $get[ $key ] = $key . "=" . $value;
      }
      $get_url = '?' . implode( '&', $get );
    }
    else {
      $get_url = '';
    }

    /*
     * $cur_page_num :当前页
    */
    $cur_page_num = floor( ($cur_page / $this->per_page) + 1 );

    if ( $num_pages == 1 ) {
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

    $pre_link .= $get_url;
    $next_link .= $get_url;

    $link="";
    /*
     *$view_num_page : 每页显示的页码数
     */
    $view_num_page = 5;

    /*
     *$tmp_current_block_page = floor( ($cur_page_num - 1) / $view_num_page ) * $view_num_page;
     * 另一种方法
    */

    /*
     * $middle_page :每页的页码数 中间的默认被选中
     */
    $middle_page = ceil( $view_num_page / 2 );
    $tmp_current_block_page = $cur_page_num - $middle_page;
    if( $tmp_current_block_page < 0 ) {
      $tmp_current_block_page = 0;
    }else if( $num_pages - $cur_page_num <  $middle_page) {
      $tmp_current_block_page -= $middle_page - ($num_pages - $cur_page_num) - 1;
    }

    //循环页码
    for($i = 1;$i<=$view_num_page;$i++) {
      $current_view_page = $tmp_current_block_page + $i;
      if( $current_view_page < 1 )
        continue;
      if( $current_view_page > $num_pages )
        break;
      //$cur_style = $cur_page_num == $current_view_page ? 'class=hver' : '';
      $start = ($current_view_page - 1 )* $this->per_page;
      if( $cur_page_num == $current_view_page ){
        $link.='<strong>'.$current_view_page.'</strong>';
      }else{
        $link.='<a href="'.$this->base_url.$start.'">'.$current_view_page.'</a>';
      }
    }
    $out=array();
    $out['current']=$cur_page_num.'/'.$num_pages;
    $out['link'] ='
      <a class="prev" href="'.$pre_link.'">上一页</a>
       '.$link.'
      <a class="nxt"  href="'.$next_link.'">下一页</a>';

    return $out;
  }

}
