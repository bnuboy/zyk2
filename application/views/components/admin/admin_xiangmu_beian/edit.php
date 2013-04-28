<link type="text/css" href="/resource/css/index.css" rel="stylesheet" />
<style>
  .middlebox{padding:0 !important}
  .zuzhi_textarea{width:125px;height:50px;border:0;}
  td{background:#fff;}
  th{background:#fff;}
</style>
<form action="/admin_xiangmu_beian/post" enctype="multipart/form-data" method="post" id="sub_form" >
  <div class="noticewarp">

    <div class="noticetit">
      <h1>项目备案</h1>
    </div>

    <div class="noticenwarp">
      <div class="noticekatebox" style="padding-bottom:35px">
        <div class="addpwordn" style="width:auto;">选择文件：</div>
        <div  class="addfile" >
          <input id="file_path_input" type="text"/>
          <input style="opacity:0;width:315px;position:relative;top:-30px" onchange="$('#file_path_input').val( this.value );" size="34" name="file_path" type="file"/>
        </div>
        <div class="addfileput"><a href="javascript:;">浏览</a></div>
      </div>
  <div class="basebutbox">
    <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
  </div>   </div></div>
</form>