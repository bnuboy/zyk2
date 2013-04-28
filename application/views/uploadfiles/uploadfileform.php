<?php
$this->load->helper('Util');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<!--处理等待效果-->
<script type="text/javascript" src="/resource/js/blockUI.js"></script>
<script type="text/javascript" src="/resource/js/common.js"></script>

<script language="javascript">
      function checkform(){
          var fileid = document.getElementById('userfile').value;
          if(fileid == ''){
              alert('请选择要上传的文件！！！');
              return false;
          }else{
              return true;
          }
      }
</script>
</head>
<body style="padding:0px;margin:0px;overflow-x:hidden;">
<table cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td width="260px;" height="50px" valign="middle">
      <form style="margin:0" onsubmit="return checkform()" action="/Uploadfiles/saveuploadfile" name="updatefile" id="updatefile" method="post" enctype="multipart/form-data">
         <input type="file" name="userfile" id="userfile" onchange="javascript:document.getElementById('updatefile').submit();loading('正在上传文件....');" />
         <input type="hidden" name="fileid" value="<?php echo $fileid;?>" />
         <input type="hidden" name="fileinfoid" value="<?php echo $fileinfoid;?>" />
         <input type="hidden" name="allowed_extensions" value="<?php echo $allowed_extensions;?>" />
         <input type="hidden" name="source" value="<?php echo $source;?>" />
         <input type="hidden" name="overwrite" value="<?php echo $overwrite;?>" />
         <input type="hidden" name="encrypt_name" value="<?php echo $encrypt_name;?>" />
         <input type="hidden" name="uppath" value="<?php echo $uppath;?>" />
      		 <input type="hidden" name="chagetoswf" value="<?php echo $chagetoswf;?>" />
      		 <input type="hidden" name="chagetoflv" value="<?php echo $chagetoflv;?>" />
      </form>
    </td>
    <td valign="middle" style="font-size:12px;">
      <div id="filediv" style="word-wrap: break-word;word-break: normal;  width:235px;">
      <?php echo empty($error)?'' : $error_content;?>
      <?php if(!empty($data)){ ?>
         <a href="<?php echo $filepath;?>" title="下载" target="_blank">
          <?php 
            if($data['is_image'] == '1'){
                echo "<img src='".$filepath."' width='100px' height='50px'>";
            }else{
                echo  $data['file_name'];
            }
          ?>
         </a>
         <a href="#this" style="font-size:12px;" onclick="javascript:window.parent.document.getElementById('<?php echo $fileid;?>').value='';document.getElementById('filediv').style.display='none';">删除</a>

         <script>
           window.parent.document.getElementById('<?php echo $fileid;?>').value="<?php echo $filepath;?>";
           <?php if(!empty($fileinfoid)) { ?>
           window.parent.document.getElementById('<?php echo $fileinfoid;?>').value='<?php echo serialize($data);?>';
           <?php } ?>
         </script>
      <?php } ?>
      <?php if(!empty($defaultvalue) && $defaultvalue <> ''){ ?>
         <?php 
		 $ext = strtolower(Util::get_extension($defaultvalue));	 
		 if($ext == 'gif' || $ext == 'png' || $ext == 'jpg'){
	     ?>
		   <a href="<?php echo $defaultvalue;?>" title="下载" target="_blank"><img  width='100px' height='50px' src="<?php echo $defaultvalue;?>"></a>
         <?php } else { ?>
		   <a href="<?php echo $defaultvalue;?>" title="下载" target="_blank"><?php echo $defaultvalue;?></a>
		 <?php } ?>
         <a href="#this" style="font-size:12px;" onclick="javascript:window.parent.document.getElementById('<?php echo $fileid;?>').value='';document.getElementById('filediv').style.display='none';">删除</a>
      <?php } ?>
     </div>
    </td>
</table>
</body>
</html>
