<?php
include_once '_cmsController.php';

class Cms extends CmsController
{

    function __construct() {
        parent::__construct();
        $this->load->model('Cms_Focusmap_Model');
        $this->load->model('Cms_Article_Model');
        $this->load->model('Cms_Menu_Model');
        $this->load->model('Cms_Page_Model');
        $this->load->model("User_Model");
        $this->load->model("User_Login_Log_Model");
        $this->load->model('Resource_Library_Model');
        $this->load->model('Resource_Info_Model');
        $this->load->model('Resource_Cat_Model');
        $this->load->model('Resource_Comment_Model');
        $this->load->library('imgcode');
        $this->load->model('Study_Course_Model');
        $this->load->model('Study_Plan_Model');
        $this->load->model('Study_Course_Rescource_Model');
        $this->load->model('Study_Product_Model');
        $this->load->model('Study_Select_Course_Model');
        $this->load->model('Admin_Cms_Logo_Model');
    }

    /*
    * CMS首页
    */
    function index() {
        //计划id
        $plan_id=array();
        $course_new=array();
        $plan_content=array();
        $course_resource=array();
        $product=array();
        //LOGO
        $LOGO=$this->Admin_Cms_Logo_Model->getOne("`org_id` =".$this->cmsorg['id']." AND `enabled`='y'");
        //焦点图
        $focusmaps = $this->Cms_Focusmap_Model->getAll("`school_org_id` = '".$this->cmsorg['id']."'", '*', '`order` DESC, `id` DESC', 6, 0 );
        //置顶新闻图片
        $topnew = $this->Cms_Article_Model->getOne("`school_org_id` = '".$this->cmsorg['id']."' AND istop = 1" );
        //新闻资讯
        $where = "`school_org_id` = '".$this->cmsorg['id']."'";
        if(!empty($topnew)) $where .= " AND `id` <> '".$topnew['id']."'";
        $news = $this->Cms_Article_Model->getAll($where, '*', '`content_date` DESC, `id` DESC', 6, 0 );
        //资源更新
        $resourcs = $this->Resource_Info_Model->getAll("`library_id` = '".$this->cmsorg['resource']['id']."'", '*', '`id` DESC', 3, 0);
        //课程信息
        $course_new= $this->Study_Course_Model->getOne("`resource_id` = '".$this->cmsorg['resource']['id']."'","*","`created` desc");
        if(!empty($course_new)){
        //学习计划---学习单元
        $plan= $this->Study_Plan_Model->getOne("`course_id` = " .$course_new['id'],"*",'order_no asc');              
        if(!empty($plan))$plan_content= $this->Study_Plan_Model->getOne("`cid` = ".$plan['id']);
        //课程资源
        $course_resource= $this->Study_Course_Rescource_Model->getAll("`course_id` = " .$course_new['id']." AND `status`='1'","id,name,file_path",'id desc',7,0);
        //作品
        $plans= $this->Study_Plan_Model->getALL("`course_id` = " .$course_new['id'],"id");
        foreach($plans as $p){
            $plan_id[]=$p['id'];
        }
        $p_id=implode(',', $plan_id);
        if(!empty($p_id)){
           $product= $this->Study_Product_Model->getAll("`plan_id` in (".$p_id.")",'id,name','up_time desc',7,0);
        }
        }
        //选课
        $status= 'y';
        if(empty($this->user['id'])){
            $status='n';
            }else{
                if(!empty($course_new)){
                $user_course=$this->Study_Select_Course_Model->getOne('`user_id` = '.$this->user['id']." AND `course_id` = ".$course_new['id'],'course_part_id');
                if($user_course){$status='y';}else{$status='n';}
                }
            }
        $result = array(
            'focusmaps'        => $focusmaps,
            'topnew'           => $topnew,
            'news'             => $news,
            'resourcs'         => $resourcs,
            'course_new'       => $course_new,
            'plan_content'     => $plan_content,
            'course_resource'  => $course_resource,
            'product'          => $product,
            'status'           => $status,
            'logo'             => $LOGO
        );
        $this->setComponent( 'index', $result );
        $this->showTemplate('cms_base');
    }
    
    /*
    * 登陆
    */
    function login() {
        //参数
        $login_name = $_POST['login_name'];
        $password   = $_POST['password'];
        $code       = $_POST['code'];
        //验证
        if(!empty($login_name) && !empty($password)){
            if ( !$this->imgcode->check(trim($code))){
                echo '1'; //验证码错误
            }else{
                $user = $this->User_Model->getOne("`login_name` = '".$login_name."' AND `enabled` = 'y'");
                if(empty($user)) {
                    echo '4'; //用户名错误 
                }else if($user['password'] != md5($password)){
                    echo '2'; //密码错误
                }else{
                    //登陆成功记录登陆日志
                    $data = array(
                        'user_id'    => $user['id'],
                        'login_time' => date('Y-m-d H:i:s', time()),
                        'login_ip'   => $_SERVER['REMOTE_ADDR']
                    );
                    $log_id=$this->User_Login_Log_Model->insert($data);
                    $user['log_id']=$log_id;
                    $_SESSION['user'] = $user;
                    echo 'ok';
                }
            }
        }else{
            echo '3'; //请输入用户名或密码
        }
        die();
    }
    
    /*
    * 显示登陆后用户信息
    */
    function getloginfo(){
        echo "<table style='padding-left:10%; padding-top:50px; line-height:30px;'>";
        echo "<tr><td>欢迎".$_SESSION['user']['name']."登陆</td></tr>";
        echo "<tr><td><a href='/ucenter_course/mycourseselect'>进入个人中心</a></td></tr>";
        echo "<tr><td><a href='/index/logout'>退出</a></td></tr>";
        echo "</table>";
        die();
    }

    
    /*
    * 资源中心 列表
    */
    function resourcelist(){
	      $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
	      $cat_id    = Util::getPar('cat_id');
        $catnav = array();
        //构造条件
        $where = array();
        $where[] = "`status` = 'succeed'";
        $where[] = "`library_id` = '".$this->cmsorg['resource']['id']."'";
        if(!empty($cat_id)) $where[] = "(`cat_id` = '".$cat_id."' OR `cat_id` like '".$cat_id.",%' OR `cat_id` like '%,".$cat_id."' OR `cat_id` like '%,".$cat_id.",%')";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->Resource_Info_Model->getAll($condition, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->Resource_Info_Model->getCount( $condition );
        //分类导航
        if(!empty($cat_id)) $catnav = $this->Resource_Cat_Model->getParents($cat_id, 'id, f_id, name');
        //所有分类
        $cats = $this->Resource_Cat_Model->getAll("`library_id` = '".$this->cmsorg['resource']['id']."'");
        //资源库信息
        $library = $this->cmsorg['resource'];
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showStyle_web1();
        //构造返回
        $result = array(
            'list'       => $list, 
            'library'    => $library,
            'cat_id'     => $cat_id,
            'catnav'     => $catnav,
            'cats'       => $cats,
            'count'      => $count,
            'pagination' => $pagination,
            'pagesize'   => $pagesize,
            'PB_page'    => $PB_page
        );
        $this->setComponent( 'resourcelist', $result );
        $this->showTemplate('cms_base');
    }

    /*
    * 资源中心 详情
    */
    function resourcedetail($id){
        //构造条件
        $where = array();
        $where[] = "`id` = '".$id."'";
        $condition = implode(' AND ', $where);
        //构造数据
        $info = $this->Resource_Info_Model->getOne($condition, '*', '`id` DESC');
        //分类导航
        if(!empty($cat_id)) $catnav = $this->Resource_Cat_Model->getParents($cat_id, 'id, f_id, name');
        //所有分类
        $cats = $this->Resource_Cat_Model->getAll("`library_id` = '".$this->cmsorg['resource']['id']."'");
        //资源库信息
        $library = $this->cmsorg['resource'];
        //构造返回
        $result = array(
            'info'       => $info,
            'cats'       => $cats
        );
        $this->setComponent( 'resourcedetail', $result );
        $this->showTemplate('cms_base');
    }

    /*
    * 文章 列表
    */
    function articlelist(){
        $menuid = Util::getPar('menuid');
	       $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        //构造条件
        $where = array();
        //$where[] = "`status` = 'publish'";
        $where[] = "`menu_id` = '".$menuid."'";
        $condition = implode(' AND ', $where);
        //构造数据
        $list = $this->Cms_Article_Model->getAll($condition, '*', '`content_date` DESC', $pagesize, ($PB_page-1)*$pagesize);
        $count = $this->Cms_Article_Model->getCount( $condition );
        $menu = $this->Cms_Menu_Model->getOne( "`id` = '".$menuid."'" );
        //新闻资讯
        $news = $this->Cms_Article_Model->getAll("`menu_id` = '".$menuid."'", '*', '`order` DESC, `id` DESC', 20, 0 );
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showStyle_web1();
        //构造返回
        $result = array(
            'list'       => $list, 
            'count'      => $count,
            'menu'       => $menu,
            'pagination' => $pagination,
            'pagesize'   => $pagesize,
            'PB_page'    => $PB_page,
            'news'       => $news
        );
        $this->setComponent( 'articlelist', $result );
        $this->showTemplate('cms_base');
    }
    
    /*
    * 文章 详情
    */
    function articledetail($id){
        $menuid = Util::getPar('menuid');
        //构造条件
        $where = array();
        $where[] = "`id` = '".$id."'";
        $condition = implode(' AND ', $where);
        //构造数据
        $info = $this->Cms_Article_Model->getOne($condition, '*', '`id` DESC');
        $menu = $this->Cms_Menu_Model->getOne( "`id` = '".$info['menu_id']."'" );
        //新闻资讯
        $news = $this->Cms_Article_Model->getAll("`menu_id` = '".$menuid."'", '*', '`content_date` DESC, `id` DESC', 20, 0 );
        //构造返回
        $result = array(
            'info'       => $info,
            'menu'       => $menu,
            'news'       => $news
        );
        $this->setComponent( 'articledetail', $result );
        $this->showTemplate('cms_base');
    }

    /*
    * 单页
    */
    function page(){
        $menuid = Util::getPar('menuid');
        $id     = Util::getPar('id');
        if(empty($id)){
            $page = $this->Cms_Page_Model->getOne("id > 0 AND `menu_id` = '".$menuid."'", '*', '`order` DESC, `id` DESC');
            $id   = $page['id'];
        }
        //构造条件
        $where = array();
        $where[] = "`id` = '".$id."'";
        $condition = implode(' AND ', $where);
        //构造数据
        $page = $this->Cms_Page_Model->getOne($condition, '*', '`id` DESC');
        $pages = $this->Cms_Page_Model->getAll("id > 0 AND `menu_id` = '".$menuid."'", '*', '`order` DESC, `id` DESC');
        //构造返回
        $result = array(
            'page'     => $page,
            'pages'    => $pages,
            'id'       => $id
        );
        $this->setComponent( 'page', $result );
        $this->showTemplate('cms_base');
    }
    function test($id)
    {
        $this->setComponent('news_list');
        $this->showTemplate('public_base');
    }

    /*
    * 学习中心 列表
    */
    function courselist(){
        $organization_id=$this->cmsorg['id'];
	      $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $where='';
        $where = '`id` > 0';
        $catnav = array();
        $where.=" AND `organization_id` = ".$organization_id;
        $list = $this->Study_Course_Model->getAll($where, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize );
        $count = $this->Study_Course_Model->getCount( $where );
        $status='y';
//        foreach($list as $key=>$v){
//          if(empty($this->user['id'])){
//            $list[$key]['status']='n';
//           }else{
//               $user_course=$this->Study_Select_Course_Model->getOne('`user_id` = '.$this->user['id']." AND `course_id` = ".$v['id'],'course_part_id');
//               if($user_course){
//                   $list[$key]['status']='y';
//               }else{
//                   $list[$key]['status']='n';
//               }
//            }
//        }
        //构造分页
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showStyle_web1();
        $result = array(
            'list'         => $list,
            'count'        => $count,
            'pagination'   => $pagination,
            'catnav'       => $catnav,
            'status'       => $status
        );
        $this->setComponent( 'courselist', $result );
        $this->showTemplate('cms_base');
    }



}