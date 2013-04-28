<?php
if ( !defined( 'BASEPATH' ) )
  exit( 'No direct script access allowed' );

class Front_Power_Group_Model extends DAO
{
    public function __construct()
    {
        parent::initTable('gz_front_power_group', 'id');
    }
    
    /*
     * 用户群组已有菜单ID
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
        $query = $this->db->get('gz_front_power_groupmenu');
        foreach ($query->result_array() as $row) {
            $rows[] = $row['menu_id'];
        }
        return $rows;
    }
    
}
?>
