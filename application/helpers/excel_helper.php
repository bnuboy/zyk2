<?php
class Excel{
    
    function __construct(){
        $CI =& get_instance();
        $CI->load->library('phpexcel/PHPExcel');
        $CI->load->library('phpexcel/PHPExcel/IOFactory');
    }

   /*
     * 读取EXCEL文件，返回数组
    */
    public static function getValues($excelFile, $exceType = 'Excel5', $sheet = 0, $startRow = 1){     
        $CI =& get_instance();
        $CI->load->library('phpexcel/PHPExcel');
        $CI->load->library('phpexcel/PHPExcel/IOFactory');
        $objReader = IOFactory::createReader($exceType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($excelFile); //档案名称
        $objWorksheet = $objPHPExcel->getActiveSheet($sheet); //读取第一个工作表(编号从0开始)
        $highestRow = $objWorksheet->getHighestRow();  //总行数
        $highestColumn = $objWorksheet->getHighestColumn();  //最高列数
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);  //总列数
        $excelVals = array();
        for ($row = $startRow; $row <= $highestRow; $row++) {
            $rowVals = array();
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $rowVals[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
            $excelVals[] = $rowVals;
        }
        return $excelVals;
    }
    
}