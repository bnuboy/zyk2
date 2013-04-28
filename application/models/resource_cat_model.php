<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Resource_Cat_Model extends DAO
{

    function __construct() {
        parent::__construct();
        parent::initTable( 'gz_resource_cat', 'id' );
        $this->load->database();
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
        $ret = self::getAll("`f_id` = '$pid' AND ".$where."", $select, $order);
        if(is_array($ret)){
            foreach($ret as $item){
                $str = '';
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
     * ���ظ�������
     * @param string $id
     * @return array
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
