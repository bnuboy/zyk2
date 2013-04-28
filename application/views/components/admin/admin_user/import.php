
<form action="/admin_user/import"  method="POST" enctype="multipart/form-data" id="sub_form" name="sub_form">
  <div class="noticewarp">
    <div class="noticetit">
      <h1>用户导入</h1>
    </div>
    <div class="noticenwarp">
      <div class="noticekatebox" style="width:750px;height:58px;">
        <div class="maddpword" style="width:200px;">选择要导入的EXCEL文件：</div>
        <div  class="maddness">
            <input id="file"  name="file" type="file"/>
        </div>
        <div class="basebutbox">
        <a href="/resource/images/C8C29A00.xls" target="_blank">点击下载导入模板</a>
        <div class="addbutin"><input type="submit" name="sub" class="addbut" value="执行导入" /></div>
      </div>
      </div>
       
    </div>
  </div>
 
</form>

<?php
if(isset($i) && isset($j)){
    echo "<H1>导入成功用户<span style='color:red;'>".$i."</span>个，导入失败用户<span style='color:red;'>".$j."</span>个<br></H1>";
}
if(!empty($errormsg)){
    echo "<H1>导入失败原因如下：<BR></H1>";
    foreach($errormsg as $k => $v){
        echo $v . "<span style='color:blue;'>|</span>";
    }
} 
if(!empty($usererror)){
    echo "<H1>导入失败原因如下：<BR></H1>";
    foreach($usererror as $k => $v){
        foreach($v as $item){
            echo $item . "<span style='color:blue;'>|</span>";
        }
        echo "<br>";
    }
}
?>