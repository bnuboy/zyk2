<?php
include_once "_adminController.php";

class Admin_Cms_Article extends AdminController {

    function __construct() {
        parent::__construct();
        $this->load->model('Cms_Article_Model');
        $this->load->model('Cms_Menu_Model');
        $this->load->model('School_Organization_Model');
        $this->load->library('adminpagination');
    }

    /*
    * 文章列表
    */
    function articlelist($start=0) {
        $get = $this->input->get();
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $where = array();
        $limit=10;
        $where[] = 'id > 0';
        //院系管理员
        if($this->type=='organization'){$where[] = "`school_org_id` = '".$this->admin['organization_id']."'";}
        if(!empty($get['subject'])) $where[] = "`subject` like '%".$get['subject']."%'";
        if(!empty($get['school_org_id'])) $where[] = "`school_org_id` = '".$get['school_org_id']."'";
        $condition = implode(' AND ', $where);

        $list = $this->Cms_Article_Model->getAll($condition, '*', '`content_date` DESC', $limit, $start);
        $count = $this->Cms_Article_Model->getCount( $condition );
        //关联数据-院系
        foreach($list as $k => $v){
            $list[$k]['org'] = $this->School_Organization_Model->getOne("`id` = '".$v['school_org_id']."'");
            $list[$k]['menu'] = $this->Cms_Menu_Model->getOne("`id` = '".$v['menu_id']."'");
        }
        //所有院系
        $organizations = $this->School_Organization_Model->getAll("`f_id` = 0 AND `enabled` = 'y'", "*", "`order` ASC, `id` DESC");
        //构造分页
        //$page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        //$pagination  =  $page->showAdmin_1();
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $config[ 'base_url' ] = base_url() . 'admin_cms_article/articlelist';
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        $result = array(
            'list'          => $list, 
            "pagination"    => $pagination, 
            'count'         => $count, 
            'organizations' => $organizations,
            'get'           => $get
        );
        $this->setComponent( 'articlelist', $result );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 添加/编辑文章
    */
    function articleedit() {
        if($_POST){
            $data = $_POST['data'];
            $id = $data['id'];
            if($this->type=='organization'){$data['school_org_id'] = $this->admin['organization_id'];}
            if(!empty($id)){
                $this->Cms_Article_Model->update($data, "id = " . $id);
            }else{
                $data['created'] = date('Y-m-d H:i:s', time());
                $this->Cms_Article_Model->insert($data);
            }
            Util::redirect('/admin_cms_article/articlelist');
        }
        $data = '';
        if(!empty($_GET['id'])){
            $data = $this->Cms_Article_Model->getOne("`id` = '".$_GET['id']."'");
        }
        //文章分类
        $menus = $this->Cms_Menu_Model->getAll();
        //院系管理员
        $org='';
        if($this->type=='organization'){$org = $this->admin['organization_id'];}
        //所有院系
        $orgs = $this->School_Organization_Model->getAll("`f_id` = 0");
        $this->setComponent( 'articleedit', array('data' => $data, 'menus' => $menus, 'orgs' => $orgs,'org'=>$org) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 文章首页
    */
    function articletop($id, $menu_id, $istop) {
        $url = $_SERVER['HTTP_REFERER'];
        if($istop == 'TRUE'){
            $data = array('istop' => 0);
            $this->Cms_Article_Model->update($data, "menu_id = " . $menu_id);
            $data = array('istop' => 1);
        }else{
            $data = array('istop' => 0);
        }
        $this->Cms_Article_Model->update($data, "id = " . $id);
        Util::redirect($url);
    }
	
    /*
    * 删除文章
    */
    function articledel() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect('/admin_cms_article/articlelist', '请选择要删除的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect('/admin_cms_article/articlelist', '请选择要删除的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->Cms_Article_Model->delete($where);
        Util::redirect('/admin_cms_article/articlelist');
    }

}