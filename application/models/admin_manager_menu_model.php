<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Admin_Manager_Menu_Model extends DAO
{

    function __construct()
    {
        parent::__construct();
        parent::initTable( 'gz_admin_manager_menu', 'id' );
        $this->load->database();
    }
    
     /*
     * 返回顶级菜单
     * @param string $id
     * @return array
     */
     public function getTopMenu($id, $topMenu = null){ 
         $ret = self::getOne("`id` = '$id'"); 
         if($ret['f_id'] == 0){ 
             $topMenu = $ret; 
         }else{ 
             self::getTopMenu($ret['f_id'], & $topMenu); 
         } 
         return $topMenu; 
     } 
    
     /*
     * 是否存在下级菜单
     * @param string $id
     * @return array
     */
     public function isHaveChild($id){ 
         $ret = self::getOne("`f_id` = '$id'"); 
         if($ret){ 
             return true; 
         }else{ 
             return false; 
         }  
     } 
	 
	    /*
     * 格式树形结构
     * @param string $pid
     * @param array $childs
     * @return array
    */
    public function getTrees($where = 'id > 0', $select = '*', $order = '`order` ASC', $pid = 0, $tags = "---", $_level = 0, & $childs = array() ){
        if(empty($pid)) $pid = 0;
        $ret = self::getAll("`f_id` = '$pid' AND ".$where."", $select, $order);
        if(is_array($ret)){
            foreach($ret as $item){
                $str = '';
                for($i = 0; $i < $_level; $i++){
                    $str .= $tags;
                }
                $keys = array_keys($item);
                $item['tag'] = $str; 
                $childs[] = $item;
                self::getTrees($where, $select, $order, $item['id'], $tags, $_level+1, $childs);
            }
        }
        return $childs;
    }
    
}
