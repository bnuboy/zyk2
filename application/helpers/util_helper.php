<?php
class Util{   

    public static function getPar($name){
        if(!empty($_GET[$name])){
            return $_GET[$name];
        }elseif(!empty($_POST[$name])){
            return $_POST[$name];
        }elseif(!empty($_SESSION[$name])){
            return $_SESSION[$name]; 
        }elseif(!empty($_COOKIE[$name])){
            return $_COOKIE[$name];
        }else{
            return null;
        }
    }
    
    /*
    * 页面跳转
    */
    public static function redirect($url, $messages = null, $target = null){
        if(!empty($url)){
           echo  '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
           echo "<script>";     
           if(!empty($messages)){
               echo "alert('$messages');";
           }
           $locationurl = "location.href='$url';";
           if(!empty($target)){
               $locationurl = $target . "." . $locationurl;
           }
           echo $locationurl;
           echo "</script>";
           die();
        }else{
            die("重定向链连错误.");
        }
    }
    
    /*
    * 跳到上一页
    */
    public static function jumpback($msg){
        $ouput = "<script>";
        $ouput .= "alert('" . $msg . "');";
        $ouput .= "history.back();";
        $ouput .= "</script>";
        echo $ouput;
        die();
    }
    
    /**
    * 创建指定目录下的文件夹
    * @param string 文件夹所在路径  
    * @return string 如果成功返回true,否则返回信息
    * @author wanglei
    */
    public static function makeDir($directoryName) {
        $directoryName = str_replace("\\","/",$directoryName);
        $dirNames = explode('/', $directoryName);
        $total = count($dirNames) ;
        $temp = '';
        for($i=0; $i< $total; $i++) {
        $temp .= $dirNames[$i].'/';
        if (!is_dir($temp)) {
            $oldmask = umask(0);
            if (!mkdir($temp, 0777)) exit("不能建立目录 $temp"); 
                umask($oldmask);
            }
        }
        return true;
    }

    /*
     * FCKEDITOR编辑器
    */
    public function showFck($params = array()){
        echo '<script type="text/javascript" src="/resource/ckeditor/ckeditor.js"></script>'."\n"; 
        $id       = (empty($params['id'])?'':$params['id']);
        $name     = (empty($params['name'])?'':$params['name']);
        $value    = (empty($params['value'])?'':$params['value']);
        $width    = (empty($params['width'])?'98%':$params['width']);
        $height   = (empty($params['height'])?'':$params['height']);
        $toolbar  = (empty($params['toolbar'])?'Full':$params['toolbar']);
        echo "<textarea name='".$name."' id='".$id."'>".$value."</textarea> \n"; 
        echo "<script type='text/javascript'> \n"; 
        echo "CKEDITOR.replace( '".$name."', \n"; 
        echo "{ \n"; 
        echo "filebrowserBrowseUrl : '/resource/ckfinder/ckfinder.html', \n"; 
        echo "filebrowserImageBrowseUrl : '/resource/ckfinder/ckfinder.html?Type=Images', \n"; 
        echo "filebrowserFlashBrowseUrl : '/resource/ckfinder/ckfinder.html?Type=Flash', \n"; 
        echo "filebrowserUploadUrl : '/resource/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files', \n"; 
        echo "filebrowserImageUploadUrl : '/resource/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images', \n"; 
        echo "filebrowserFlashUploadUrl : '/resource/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash' \n"; 
        echo "}); \n"; 
        echo "</script> \n";
    }


    /*
    * 字节转换
    */    
    function byteChange($size, $type){
        if($type == 'KB'){
            $size = floor(($size/1024)*100)/100;
        }else if($type == 'MB'){
            $size = floor(($size/1048576)*100)/100;
        }
        return $size;
    }
    
   /*
    * 获取扩展名
    */
    function get_extension($file) {
        return substr($file, strrpos($file, '.')+1);
    }

    public static function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')  { 
        if($code == 'UTF-8') 
        { 
            $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/"; 
            preg_match_all($pa, $string, $t_string); 
     
            if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."..."; 
            return join('', array_slice($t_string[0], $start, $sublen)); 
        } 
        else 
        { 
            $start = $start*2; 
            $sublen = $sublen*2; 
            $strlen = strlen($string); 
            $tmpstr = ''; 
     
            for($i=0; $i< $strlen; $i++) 
            { 
                if($i>=$start && $i< ($start+$sublen)) 
                { 
                    if(ord(substr($string, $i, 1))>129) 
                    { 
                        $tmpstr.= substr($string, $i, 2); 
                    } 
                    else 
                    { 
                        $tmpstr.= substr($string, $i, 1); 
                    } 
                } 
                if(ord(substr($string, $i, 1))>129) $i++; 
            } 
            if(strlen($tmpstr)< $strlen ) $tmpstr.= "..."; 
            return $tmpstr; 
        } 
    }



    function showplayer($path, $useFlashPlayer = false){
        //取扩展名       
         $fiallpath = getcwd().str_replace('/','\\',$path);
         $fullpath = self::get_extension($fiallpath);
         $fipath = $path . ".swf";
         $ext = array(
             'doc',
             'gif',
             'docx',
             'xls',
             'pdf',
             'jpg',
             'jpeg',
             'png'
         );
         $pic = array(
             'jpg',
             'jpeg',
             'gif',
             'png'
         );
            
        if($useFlashPlayer){
            if(file_exists($fiallpath.'.swf')){       
                ?>             
                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="595" height="441" title="sadasdasd">
                <param name="movie" value="<?php echo $fipath;?>" />
                <param name="quality" value="high" />
                <embed src="<?php echo $fipath;?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="595" height="441"></embed>
                </object>        
                    <?php
            }else{ 
                if(in_array($fullpath,$pic))
                {
                    echo "<div style='width:660px;'><img src='".$path."'></div>";
                }else{
                    echo '此格式不支持！';
                }
            }
        }
        //if( in_array($fullpath,$ext) && !file_exists($path.'.swf')){
                //$cmd = "F:\SWFTools\pdf2swf.exe ".$fiallpath." -o ".$fiallpath.".swf"." -f -T 9 -t -s storeallcharacters";
                //exec($cmd);
        
//        else{
//            if($fileext == 'gif' || $fileext == 'jpg' || $fileext == 'png'){
//                echo "<img src='".$path."' onload='zoom(this, 700, 600)'>";
//            }else if($fileext == 'swf'){
//                echo '<embed id="top10movie" name="top10movie" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$path.'" width="650" height="488" type="application/x-shockwave-flash" menu="false" quality="high" />' . " \n";
//                echo '</embed />' . " \n";
//            }else if($fileext == 'flv'){
//                echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="500" height="400">' . "\n";
//                echo '  <param name="movie" value="/resource/swf/Flvplayer.swf" />' . "\n";
//                echo '  <param name="quality" value="high" />' . "\n";
//                echo '  <param name="allowFullScreen" value="true" />' . "\n";
//                echo '  <param name="FlashVars" value="vcastr_file='.$path.'" />' . "\n";
//                echo '  <embed src="/resource/swf/Flvplayer.swf" allowfullscreen="true" flashvars="vcastr_file='.$path.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="500" height="400"></embed>' . "\n";
//                echo '</object>' . "\n";
//            }else{
//                echo "格式错误,暂不支持格式文件！";
//            }
//       }
    }




}