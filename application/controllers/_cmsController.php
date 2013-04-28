<?php
class CmsController extends CI_Controller {
 
    private $_views;     //保存视图数据
    private $_component; //组件
    public  $user;       //用户
    public  $cmsorg;     //当前CMS院系
    
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('Util');
        $this->load->helper('pagestyleclass');
        $this->load->model('School_Organization_Model');
        //判断用户是否登陆
        if (!empty($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
        }
        
        //判断是否选择CMS院系
        if(!empty($_GET['cmsorg_id'])){
            $this->load->model('Resource_Library_Model');
            $cmsorg = $this->School_Organization_Model->getOne("`id` = '".$_GET['cmsorg_id']."' AND `f_id` = 0");
            if(empty($cmsorg)) Util::jumpback("此院系CMS不存在");
            $cmsorg['resource'] = $this->Resource_Library_Model->getOne("`organization_id` = '".$cmsorg['id']."'");
            $_SESSION['cmsorg'] = $cmsorg;
            $this->cmsorg = $cmsorg;
        }else if(isset($_SESSION['cmsorg']) && !empty($_SESSION['cmsorg'])){
            $this->cmsorg = $_SESSION['cmsorg'];
        }else{
            Util::redirect( '/', '请选择院系' );
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
        $data['user'] = $this->user;
        $this->_component = $this->load->view( "components/cms/" . $view, $data, true );
    }

    /*
    * 选择视图框架
    */
    function showTemplate( $templates, $title = false, $keywords = false, $description = false ) {
        $menuid = Util::getPar('menuid');
        $this->load->model('Cms_Menu_Model');
        $menus = $this->Cms_Menu_Model->getAll("`school_org_id` = '".$this->cmsorg['id']."'", "*", "`order` ASC, `id` DESC");
        //所有院系
        $organizations = $this->School_Organization_Model->getAll("`f_id` = 0");
        $result = array(
            'menus'         => $menus, 
            'menuid'        => $menuid,
            'organizations' => $organizations,
            'controller'    => self::getUrlSectionName(1),
            'action'        => self::getUrlSectionName(2)
        );
        $this->setModule( 'cms_menus', $result );
        
        //构造视图框架返回数据
        $result = array(
            'component'   => $this->_component,
            'modules'     => $this->_views,
            'title'       => $title,
            'keywords'    => $keywords,
            'description' => $description,
            'cmsorg'      => $this->cmsorg            
        );
        $this->load->view( "templates/" . $templates, $result );
    }



}
