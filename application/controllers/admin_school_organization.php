<?php
include_once "_adminController.php";

class Admin_School_Organization extends AdminController {

    function __construct() {
        parent::__construct();
        $this->load->model('School_Organization_Model');
    }

    /*
    * 院系列表
    */
    function organizationlist() {
        $pid=$this->type=='organization'?$this->admin['organization_id']:0;
        $where=($this->type=='organization'?"`id` =".$this->admin['organization_id']:"`id`>0");
        if($pid!='0'){$top_tree=$this->School_Organization_Model->getOne('`id` = '.$this->admin['organization_id']);}
        $organizations = $this->School_Organization_Model->getTrees('`id`>0', '*', '`order` ASC',$pid);
        if(!empty($top_tree)){array_unshift($organizations,$top_tree);}
        $this->setComponent( 'organizationlist', array('organizations' => $organizations,'pid'=>$pid) );
        $this->showTemplate( 'admin_base' );
    }

    /*
    * 添加/编辑院系
    */
    function organizationedit($f_id = 0) {
        if($_POST){
            $data = $_POST['data'];
            $id = $data['id'];
            if(!empty($id)){
                $this->School_Organization_Model->update($data, "id = " . $id);
            }else{
                $this->School_Organization_Model->insert($data);
            }
            Util::redirect('/admin_school_organization/organizationlist');
        }
        $data = "";
        $data['f_id'] = $f_id;
        if(!empty($_GET['id'])){
            $data = $this->School_Organization_Model->getOne("`id` = '".$_GET['id']."'");
        }
        //所有院系
        $organizations = $this->School_Organization_Model->getTrees();
        $this->setComponent( 'organizationedit', array('data' => $data, 'organizations' => $organizations ) );
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
        $this->School_Organization_Model->update($data, $where);
        Util::redirect($url);
    }
    
    /*
    * 删除院系
    */
    function organizationdel($id) {
        //判断是否有下级
        if($this->School_Organization_Model->isHaveChild($id)){
            Util::redirect('/admin_school_organization/organizationlist', '此菜单下含有子院系，请先删除子院系！');
        }
        //删除菜单
        $this->School_Organization_Model->delete("`id` = '".$id."'");
        Util::redirect('/admin_school_organization/organizationlist');
    }

}