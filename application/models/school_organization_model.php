<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class School_Organization_Model extends DAO
{

    function __construct() {
        parent::initTable( 'gz_school_organization', 'id' );
    }

    public function getAll( $where = '`id` > 0', $select = '*', $orderby = '`order` ASC, `id` DESC', $limit = '', $offset = '' )
    {
        $rows = array();
        $this->db->select( $select );
        $this->db->order_by( $orderby );
        $this->db->where( $where, NULL, FALSE );
        if ( !empty( $limit ) )
        {
            $query = $this->db->get( 'gz_school_organization', $limit, $offset );
        }
        else
        {
            $query = $this->db->get( 'gz_school_organization' );
        }
        foreach ( $query->result_array() as $row )
        {
            $rows[ ] = $row;
        }
        return $rows;
    }
    
    /*
     * �Ƿ�����¼�����
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
     * ��ʽ���νṹ
     * @param string $pid
     * @param array $childs
     * @return array
    */
    public function getTrees($where = 'id > 0', $select = '*', $order = '`order` ASC', $pid = 0, $tags = "---", $_level = 0, & $childs = array() ){
        if(empty($pid)) $pid = 0;
        $ret = self::getAll("`f_id` = '$pid' AND  ".$where."", $select, $order);
        if($pid!=0)$_level=$_level+1;
        if(is_array($ret)){
            foreach($ret as $item){
                $str = '';
                //if($pid!=0){$i=1;}
                for($i = 0; $i < $_level; $i++){
                    $str .= $tags;
                }
                $keys = array_keys($item);
                $item['tag'] = $str;
                $item['level'] = $_level+1; 
                $childs[] = $item;
                self::getTrees($where, $select, $order, $item['id'], $tags, $_level+1, $childs);
            }
        }
        return $childs;
    }

    /*
     * 得所有上级分类
     */
     public function getParents($id, $select = '*', & $parents = array() ){
        $ret = self::getOne("`id` = '$id'", $select);
        if(is_array($ret)){
            $parents[] = $ret;
            self::getParents($ret['f_id'], $select, $parents);
        }
        return array_reverse($parents);
    }
}
?>
