<?php
class PublicController extends CI_Controller {
 
    private $_views;     //保存视图数据
    private $_component; //组件
    public  $user;       //用户


    function __construct() {
        parent::__construct();
        $this->load->helper('Util');
        $this->load->helper('url');
        $this->load->helper('pagestyleclass');
        $this->load->library( 'adminpagination' );
        //判断用户是否登陆
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
        }
    }
    
    /*
    * URL分段名
    */
    function getUrlSectionName($num){
        return $this->uri->segment($num);
    }
    
    /*
    *  返回视图数据赋值到变量,不输出
    */
    function setModule( $view, $data = false ) {
        $this->_views[ $view ] = $this->load->view( "modules/" . $view, $data, true );
    }

    /*
    *  显示视图
    */
    function setComponent( $view, $data = false ) {
        $class_name = strtolower( get_class( $this ) );
        $this->_component = $this->load->view( "components/public/" . $view, $data, true );
    }

    /*
    * 选择视图框架
    */
    function showTemplate( $templates, $title = false, $keywords = false, $description = false ) {
       
        //构造视图框架返回数据
        $result = array(
            'component'   =>  $this->_component,
            'modules'     =>  $this->_views,
            'title'       => $title,
            'keywords'    => $keywords,
            'description' => $description,
            'user'        => $this->user
        );
        $this->load->view( "templates/" . $templates, $result );
    }


}
