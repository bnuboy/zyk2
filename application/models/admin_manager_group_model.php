<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Admin_Manager_Group_Model extends DAO
{

    function __construct()
    {
        parent::__construct();
        parent::initTable( 'gz_admin_manager_group', 'id' );
        $this->load->database();
    }
    
    /*
     * �û�Ⱥ�����в˵�ID
     * @param int $roleId
     * @return array
     */
    public function getGroupMenuIds($groupId){
        $rows = array();
        if(is_array($groupId)){
            $ids = implode(",", $groupId);
            $where = "`group_id` in (".$ids.")";
        }else{
            $where = "`group_id` = '".$groupId."'";
        }
        $this->db->where($where, NULL, FALSE);
        $query = $this->db->get('gz_admin_manager_groupmenu');
        foreach ($query->result_array() as $row) {
            $rows[] = $row['menu_id'];
        }
        return $rows;
    }
    
    
}
?>
