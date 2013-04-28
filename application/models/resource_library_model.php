<?php
if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Resource_Library_Model extends DAO
{

    function __construct() {
        parent::__construct();
        parent::initTable( 'gz_resource_library', 'id' );
        $this->load->database();
    }
    
     /*
     * 资源库下是否存在分类
     * @param string $id
     * @return array
     */
     public function isHaveCat($id){ 
         parent::initTable( 'gz_resource_cat', 'id' );
         $ret = self::getOne("`library_id` = '$id'"); 
         if($ret){ 
             return true; 
         }else{ 
             return false; 
         }  
     } 


}
?>
