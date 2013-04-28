<?php
class ForumController extends CI_Controller {
 
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
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            Util::redirect( '/' );
        }
        $this->user = $_SESSION['user'];
        $this->load->model('Front_Power_Menu_Model');
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
        $this->_component = $this->load->view( "components/forum/" . $view, $data, true );
    }

    /*
    * 选择视图框架
    */
    function showTemplate( $templates, $title = false, $keywords = false, $description = false ) {
        //变量定义
        $topMenu           = '';  //当前顶级菜单
        $currentTopMenuId  = '';  //当前顶级菜单ID
        $currentLeftMenuId = '';  //当前左侧菜单ID
        //当前链接菜单
        $currentMenu = $this->Front_Power_Menu_Model->getOne("`controller` = '".self::getUrlSectionName(1)."' AND `action` = '".self::getUrlSectionName(2)."'");
        if($currentMenu['level'] == 3){
            $currentLeftMenuId = $currentMenu['f_id'];
        }else if($currentMenu['level'] == 2){
            $currentLeftMenuId = $currentMenu['id'];
        
        }
        //当前顶级菜单
        $topMenu = $this->Front_Power_Menu_Model->getTopMenu($currentMenu['id']);
        $currentTopMenuId = $topMenu['id'];
        //所有顶级菜单
        $topMenus = $this->Front_Power_Menu_Model->getAll("`f_id` = 0", "*", "`order` ASC");
        $this->setModule( 'forum_menus', array('topMenus' => $topMenus, 'currentTopMenuId' => $currentTopMenuId, 'user' => $this->user) );
        //左侧导航视图
        $left_menus = $this->Front_Power_Menu_Model->getAll("`f_id` = '".$currentTopMenuId."'", "*", "`order` ASC");
        $this->setModule( 'forum_left', array("left_menus" => $left_menus, "currentLeftMenuId" => $currentLeftMenuId, 'user' => $this->user) );

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


  function AJAXSuccess( $data = '' )
  {
    $ajax_data = new stdClass();
    $ajax_data->status = "ok";
    $ajax_data->data = $data;
    echo json_encode( $ajax_data );
  }

  function AJAXFail( $msg = '' )
  {
    $ajax_data = new stdClass();
    $ajax_data->status = "error";
    $ajax_data->data = $msg;
    echo json_encode( $ajax_data );
  }

  function success( $action = '' )
  {
    redirect( "/" . strtolower( get_class( $this ) ) . "/" . $action );
  }

  function fail( $msg = '' )
  {
    $ouput = "<script>";
    $ouput .= "alert('" . $msg . "');";
    $ouput .= "history.back();";
    $ouput .= "</script>";
    echo $ouput;
    die();
  }

}
