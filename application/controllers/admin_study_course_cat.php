<?php
include_once "_adminController.php";

class Admin_Study_Course_Cat extends AdminController
{

    function __construct() {
        parent::__construct();
        $this->load->model( 'Study_Course_Cat_Model' );
        $this->load->model( 'Study_Course_Model' );
    }

    /*
    * �����б�
    */
    function catlist() {
        $get = $this->input->get();
        $PB_page   = empty($_GET['PB_page'])?1:$_GET['PB_page'];
        $pagesize  = empty($_POST['pagesize'])?10:$_POST['pagesize'];
        $where = array();
        $where[] = 'id > 0';
        if(isset($get['name'])) $where[] = "`name` like '%".$get['name']."%'";
        $condition = implode(' AND ', $where);

        $list = $this->Study_Course_Cat_Model->getAll($condition, '*', '`id` DESC', $pagesize, ($PB_page-1)*$pagesize );
        $count = $this->Study_Course_Cat_Model->getCount( $condition );
        //�γ�����
        foreach($list as $k => $v){
            $list[$k]['coursecount'] = $this->Study_Course_Model->getCount("`classify_cat_id` = '".$v['id']."'");
        }
        //�����ҳ
        $page     = new mypage(array('total'=> $count,'perpage'=> $pagesize));
        $pagination  =  $page->showAdmin_1();
        $this->setComponent( 'catlist', array('list' => $list, "pagination" => $pagination, 'count' => $count, 'get' => $get) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * ���/�༭����
    */
    function catedit() {
        if($_POST){
            $data = $_POST['data'];
            $id = $data['id'];
            if(!empty($id)){
                $this->Study_Course_Cat_Model->update($data, "id = " . $id);
            }else{
                $this->Study_Course_Cat_Model->insert($data);
            }
            Util::redirect('/admin_study_course_cat/catlist');
        }
        $data = '';
        if(!empty($_GET['id'])){
            $data = $this->Study_Course_Cat_Model->getOne("`id` = '".$_GET['id']."'");
        }
        $this->setComponent( 'catedit', array('data' => $data) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * ɾ������
    */
    function catdel() {
        if($_POST){
            $ids = $this->input->post('item_id');
            if(empty($ids)){
                Util::redirect('/admin_study_course_cat/catlist', '��ѡ��Ҫɾ��������');
            }else{
                $where = "`id` in (".implode(',', $ids).")";
            }
        }else{
            if(empty($_GET['id'])){
                Util::redirect('/admin_study_course_cat/catlist', '��ѡ��Ҫɾ��������');
            }else{
                $where = "`id` = '".$_GET['id']."'";
            }
        }
        $this->Study_Course_Cat_Model->delete($where);
        Util::redirect('/admin_study_course_cat/catlist');
    }

}
?>
