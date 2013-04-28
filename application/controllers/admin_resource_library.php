<?php
include_once "_adminController.php";

class Admin_Resource_Library extends AdminController {

    function __construct() {
        parent::__construct();
        $this->load->model('Resource_Library_Model');
        $this->load->model('Resource_Cat_Model');
        $this->load->model('School_Organization_Model');
    }

    /*
    * 资源库列表
    */
    function librarylist($start=0) {
        $get = $this->input->get();
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $where = array();
        $limit=10;
        $where[] = 'id > 0';
        if(isset($get['name'])) $where[] = "`name` like '%".$get['name']."%'";
        $condition = implode(' AND ', $where);
        $this->type=='organization' ? $condition='`organization_id` ='.$this->admin['organization_id']:$condition;
        $list = $this->Resource_Library_Model->getAll($condition, '*', '`order` ASC, `id` DESC', $limit, $start );
        $count = $this->Resource_Library_Model->getCount( $condition );
        //关联数据-院系
        foreach($list as $k => $v){
            $list[$k]['organization'] = $this->School_Organization_Model->getOne("`id` = '".$v['organization_id']."'");
        }
        //构造分页
        //$page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        //$pagination  =  $page->showAdmin_1();
        $config[ 'total_rows' ] = $count;
        $config[ 'per_page' ] = $limit;
        $config[ 'base_url' ] = base_url() . 'admin_resource_library/librarylist';
        $this->adminpagination->initialize( $config );
        $pagination = $this->adminpagination->create_links();
        //判断有没有属于该院系的资源库
        $is_setlib = $this->Resource_Library_Model->getOne("organization_id = '".$this->admin['organization_id']."'");
        $this->setComponent( 'librarylist', array('list' => $list, "pagination" => $pagination, 'count' => $count, 'get' => $get,'is_setlib'=>$is_setlib) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 添加/编辑资源库
    */
    function libraryedit() {
        if($_POST){
            $data = $_POST['data'];
            $id = $data['id'];
            if($this->type=='organization'){$data['organization_id'] = $this->admin['organization_id'];}
            //判断资源库是否存在
            $library = $this->Resource_Library_Model->getOne("organization_id = '".$data['organization_id']."' AND `id` <> '".$id."'");
            if($library) Util::redirect("/admin_resource_library/libraryedit?id=".$id, "错误:此院系的资源库已存在！");
            if(!empty($id)){
                $this->Resource_Library_Model->update($data, "id = " . $id);
            }else{
                $data['created'] = date('Y-m-d H:i:s', time());
                $this->Resource_Library_Model->insert($data);
            }
            Util::redirect('/admin_resource_library/librarylist');
        }
        $data = '';
        if(!empty($_GET['id'])){
            $data = $this->Resource_Library_Model->getOne("`id` = '".$_GET['id']."'");
        }
        //院系管理员
        $org='';
        if($this->type=='organization'){$org = $this->admin['organization_id'];}
        //所有院系
        $organizations = $this->School_Organization_Model->getAll("`f_id` = 0 AND `enabled` = 'y'", "*", "`order` ASC, id DESC");
        $this->setComponent( 'libraryedit', array('data' => $data, 'organizations' => $organizations,'org'=>$org) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 删除资源库
    */
    function librarydel() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect('/admin_resource_library/librarylist', '请选择要删除的数据');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect('/admin_resource_library/librarylist', '请选择要删除的数据');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->Resource_Library_Model->delete($where);
        Util::redirect('/admin_resource_library/librarylist');
    }

    /*
    * 分类列表
    */
    function catlist($library_id) {
        $library = $this->Resource_Library_Model->getOne("`id` = '".$library_id."'");
        $cats = $this->Resource_Cat_Model->getTrees("`library_id` = '".$library_id."'");
        $this->setComponent( 'catlist', array('cats' => $cats, 'library' => $library) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 添加/编辑分类
    */
    function catedit($library_id) {
        if($_POST){
            $data = $_POST['data'];
            $id = $data['id'];
            if(!empty($id)){
                $this->Resource_Cat_Model->update($data, "id = " . $id);
            }else{
                $data['created'] = date('Y-m-d H:i:s', time());
                $this->Resource_Cat_Model->insert($data);
            }
            Util::redirect('/admin_resource_library/catlist/'.$library_id);
        }
        $data = '';
        if(!empty($_GET['id'])){
            $data = $this->Resource_Cat_Model->getOne("`id` = '".$_GET['id']."'");
        }
        //所属资源库
        $library = $this->Resource_Library_Model->getOne("`id` = '".$library_id."'");
        //所有分类
        $cats = $this->Resource_Cat_Model->getTrees("`library_id` = '".$library_id."'");
        $this->setComponent( 'catedit', array('data' => $data, 'cats' => $cats, 'library' => $library) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 删除分类
    */
    function catdel($library_id, $id) {
        //判断是否有下级菜单
        if($this->Resource_Cat_Model->isHaveChild($id)){
            Util::redirect('/admin_resource_library/catlist/'.$library_id, '此分类下含有子分类，请先删除子分类！');
        }
        $where = "`id` = '".$id."'";
        $this->Resource_Cat_Model->delete($where);
        Util::redirect('/admin_resource_library/catlist/'.$library_id);
    }

}