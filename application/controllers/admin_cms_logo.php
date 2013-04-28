<?php
include_once "_adminController.php";

class Admin_Cms_logo extends AdminController {

    function __construct() {
        parent::__construct();
        $this->load->model('Cms_Menu_Model');
        $this->load->model('School_Organization_Model');
        $this->load->model('Admin_Cms_Logo_Model');
        $this->load->library('adminpagination');
    }

    /*
    * 菜单列表
    */
    function logolist($start=0) {
        $get = $this->input->get();
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $where = array();
        $limit=10;
        $where[] = 'id > 0';
        //院系管理员
        if($this->type=='organization'){$where[] = "`org_id` = '".$this->admin['organization_id']."'";}
        if(!empty($get['title'])) $where[] = "`title` like '%".$get['title']."%'";
        if(!empty($get['org_id'])) $where[] = "`org_id` = '".$get['org_id']."'";
        $condition = implode(' AND ', $where);

        $list = $this->Admin_Cms_Logo_Model->getAll($condition, '*', '`id` DESC', $limit, $start );
        $count = $this->Admin_Cms_Logo_Model->getCount( $condition );
        //关联数据-院系
        foreach($list as $k => $v){
            $list[$k]['org'] = $this->School_Organization_Model->getOne("`id` = '".$v['org_id']."'");
        }
        //所有院系
        $organizations = $this->School_Organization_Model->getAll("`f_id` = 0 AND `enabled` = 'y'", "*", "`order` ASC, `id` DESC");
        //构造分页
        //$page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        //$pagination  =  $page->showAdmin_1();
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $config[ 'base_url' ] = base_url() . 'admin_cms_menu/menulist';
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        $result = array(
            'list'          => $list,
            "pagination"    => $pagination,
            'count'         => $count,
            'organizations' => $organizations,
            'get'           => $get
        );
        $this->setComponent( 'logolist', $result );
        $this->showTemplate( 'admin_base' );
    }

    function logoedit(){
       if($_POST){
            $data = $_POST['data'];
            $id = $data['id'];
            if($this->type=='organization'){$data['school_org_id'] = $this->admin['organization_id'];}
            if(!empty($id)){
                $this->Admin_Cms_Logo_Model->update($data, "id = " . $id);
            }else{
                $this->Admin_Cms_Logo_Model->insert($data);
            }
            Util::redirect('/admin_cms_logo/logolist');
          }
            $data = '';
            if(!empty($_GET['id'])){
                $data = $this->Admin_Cms_Logo_Model->getOne("`id` = '".$_GET['id']."'");
             }
            //院系管理员
            $org='';
            if($this->type=='organization'){$org = $this->admin['organization_id'];}
            //所有院系
            $orgs = $this->School_Organization_Model->getAll("`f_id` = 0");
            $result=array(
                'orgs' => $orgs,
                'org'  => $org,
                'data' => $data
            );
            $this->setComponent( 'logoedit', $result );
            $this->showTemplate( 'admin_base' );
    }


    /*
    * 改变状态
    */
    function changestatus() {
        $status = Util::getPar('status');
        $url = $_SERVER['HTTP_REFERER'];
        if($_POST){
            $ids = $this->input->post('ids');
            if(empty($ids)){
                Util::redirect($url, '请选择要改变状态的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect($url, '请选择要改变状态的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $data = array(
            'enabled' => $status
        );
        $this->Admin_Cms_Logo_Model->update($data, $where);
        Util::redirect($url);
    }

    /*
    * 删除
    */
    function logodel() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect('/admin_cms_logo/logolist', '请选择要删除的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect('/admin_cms_logo/logolist', '请选择要删除的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->Admin_Cms_Logo_Model->delete($where);
        Util::redirect('/admin_cms_logo/logolist');
    }
}

