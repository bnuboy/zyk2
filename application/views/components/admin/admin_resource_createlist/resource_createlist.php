<link type="text/css" href="/resource/css/center_data.css" rel="stylesheet" />

<form action="/admin_resource_leadin/importcourse" enctype="multipart/form-data" method="post" id="sub_form" >
  <div class="noticewarp">

    <div class="noticetit">
      <h1>导入资源</h1>
    </div>

    <div class="noticenwarp">
      <div class="noticekatebox" style="padding-bottom:35px">
        <div class="addpwordn">选择文件：</div>
        <div  class="addfile" >
          <input id="file_path_input" type="text"/>
          <input style="opacity:0;width:315px;position:relative;top:-30px" onchange="$('#file_path_input').val( this.value );" size="34" name="file_path" type="file"/>
        </div>
        <div class="addfileput"><a href="javascript:;">浏览</a></div>
      </div>
      <div style="padding-left: 55px"> <a target="_blank" href="/resource/images/moban.xls">点击下载导入模板</a></div>
  <div class="basebutbox">
    <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
  </div>   </div></div>
</form>