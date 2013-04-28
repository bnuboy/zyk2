<?php
class AdminController extends CI_Controller {
 
    private $_views;     //保存视图数据
    private $_component; //组件
    public  $admin;      //管理员
    public  $type;      //院系管理员


    function __construct() {
        parent::__construct();
        $this->load->helper('Util');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('pagestyleclass');
        $this->load->library( 'adminpagination' );
        $this->load->model('Admin_Manager_Model');
        //判断用户是否登陆
        if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
            Util::redirect( '/admin/login' );
        }
        $this->admin = $_SESSION['admin'];
        $this->load->model('Admin_Manager_Menu_Model');
        $manager_group=$this->Admin_Manager_Model->getOne("`user_id` = " .$this->admin['id'],'manager_group_id');
        if($manager_group['manager_group_id']=='5'){$this->type='organization';}
        self::Jurisdiction($manager_group['manager_group_id']);
    }

    function Jurisdiction($power_view){
        $this->load->model("Admin_Manager_Groupmenu_Model");
        $power=array();
        $power_id=array();
        $left=array();
        $menu_id= $this->Admin_Manager_Groupmenu_Model->getAll("`group_id` = " .$power_view,'menu_id','menu_id desc');
        foreach($menu_id as $menu){
            $menu_info = $this->Admin_Manager_Menu_Model->getOne( array('id' => $menu[ "menu_id" ]) );
            if($menu_info["f_id"]=='0')$power_id[]=$menu_info['id'];
            $Classname=$menu_info['controller'];
            $ActionName =$menu_info['action'] ;
            $power[ $Classname ][ ] = $ActionName;
            if($menu_info["f_id"]!='0')$left[$menu_info["f_id"]][]=$menu_info['id'];
        }
        $_SESSION['power_id'] = implode(',', $power_id);
        $_SESSION['left_id']  = $left;
        $menu_url = explode( "/", $this->uri->uri_string() );
        if ( !isset( $power[ $menu_url[ '0' ] ] ) ){
          self::errorPowerMsg();
          die();
        }
        if ( isset( $menu_url[ '1' ] ) && !in_array( $menu_url[ '1' ], $power[ $menu_url[ '0' ] ] ) ){
            self::errorPowerMsg();
            die();
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
        $this->_component = $this->load->view( "components/admin/" . $class_name . "/" . $view, $data, true );
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
        $currentMenu = $this->Admin_Manager_Menu_Model->getOne("`controller` = '".self::getUrlSectionName(1)."' AND `action` = '".self::getUrlSectionName(2)."'");
        if($currentMenu['level'] == 3){
            $currentLeftMenuId = $currentMenu['f_id'];
        }else if($currentMenu['level'] == 2){
            $currentLeftMenuId = $currentMenu['id'];
        }
        //当前顶级菜单
        $topMenu = $this->Admin_Manager_Menu_Model->getTopMenu($currentMenu['id']);
        $currentTopMenuId = $topMenu['id'];
        //所有顶级菜单
        $topMenus = $this->Admin_Manager_Menu_Model->getAll("`f_id` = 0 AND isshow = 0 AND `id` in(".$_SESSION['power_id'].")", "*", "`order` ASC");
        //$topMenus = $this->Admin_Manager_Menu_Model->getAll("`f_id` = 0 AND isshow = 0", "*", "`order` ASC");
        $this->setModule ( 'admin_menus', array("topMenus" => $topMenus, "currentTopMenuId" => $currentTopMenuId, 'admin' => $this->admin) );
        //左侧导航视图
        //角色有权限的左侧菜单
        $left_menu_id=$_SESSION['left_id'][$topMenu['id']];
        $Lid = implode(',', $left_menu_id);
        $left_menus = $this->Admin_Manager_Menu_Model->getAll("`f_id` = '".$currentTopMenuId."' AND isshow = 0 And `id` in (".$Lid.")", "*", "`order` ASC");
        //$left_menus = $this->Admin_Manager_Menu_Model->getAll("`f_id` = '".$currentTopMenuId."' AND isshow = 0 ", "*", "`order` ASC");
        $this->setModule( 'admin_left', array("left_menus" => $left_menus, "currentLeftMenuId" => $currentLeftMenuId, 'admin' => $this->admin) );
        
        //构造视图框架返回数据
        $result = array(
            'component'   => $this->_component,
            'modules'     => $this->_views,
            'title'       => $title,
            'keywords'    => $keywords,
            'description' => $description,
            'admin'       => $this->admin,
        	'type'		  => $_SESSION['admin_type']
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
    redirect( "/" . strtolower( get_class( $this ) ) . "/" . $action.'/index' );
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

  function errorPowerMsg(){
        $beforeurl = $_SERVER['HTTP_REFERER'];
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
        echo '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
        echo '<head>'."\n";
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n";
        echo '<title>权限信息提示</title>'."\n";
        echo '</head>'."\n";
        echo '<body>'."\n";
        echo '<div style="margin:0 auto;width:500px;text-align:center; font-size:12px;">'."\n";
        echo '<p><p><p><br><p><p><p>'."\n";
        echo '<h2 style="font-size:14px; color:#e00000;">您没有此操作权限</h2>'."\n";
        echo '系统将 <input type="text" style="width:10px;" readonly="true" value="3" id="time">秒钟后自动返回！' ."\n";
        echo '</div>'."\n";
        echo '</body>'."\n";
        echo '<html>'."\n";
        echo '<script language="javascript">                      '."\n";
        echo '  var t = 3;                                        '."\n";
        echo '  var time = document.getElementById("time");       '."\n";
        echo '  function fun(){                                   '."\n";
        echo '      t--;                                          '."\n";
        echo '      time.value = t;                               '."\n";
        echo '      if(t<=0){                                     '."\n";
        echo '          location.href = "'.$beforeurl.'";         '."\n";
        echo '          clearInterval(inter);                     '."\n";
        echo '      }                                             '."\n";
        echo '  }                                                 '."\n";
        echo '  var inter = setInterval("fun()",1000);            '."\n";
        echo '</script>                                           '."\n";
        die();
    }
  
}
