<script charset="utf-8" src="https://ajax.googleapis.com/ajax/libs/mootools/1.4.1/mootools-yui-compressed.js"></script>
<script charset="utf-8" src="/resource/updata/kindeditor-min.js"></script>
<script charset="utf-8" src="/resource/updata/lang/zh_CN.js"></script>
<script>
    window.addEvent('domready', function() {
        var editor = KindEditor.create('textarea[id="content"]');
    });
</script>
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<script>
   $().ready(function() {
      $.validator.setDefaults({
          submitHandler: function(form){
              form.submit();
          }
      });
      $("#sub_form").validate({
          errorPlacement: function(error, element) { //配置错误信息输出
              error.appendTo( element.parent() );
          },
          success: function(label) {
              label.text("正确").addClass("success"); //返回值
          },
          rules: {
                    "data[name]": {required:true,maxlength:20},
                    "data[content]": {required:true},
                    "data[file_path]":{required:true},
                    "data[demo_path]":{required:true}
                  },
          messages: {
                    "data[title]": {required:"标题不能为空",maxlength:"不能超过20个字"},
                    "data[content]": {required:"内容不能为空"},
                    "data[relevance_type]":{required:"请上传资源"},
                    "data[demo_path]":{required:"请上传预览图"}
                  }
      });
  });
</script>
<div class="resourrdbox" style="height: auto;">
  <form id="sub_form" method="post" enctype="multipart/form-data" action="">
    <div class="resourkate">
      <div class="addpword">作品标题：</div>
      <div class="addptit">
        <input type="text" name="data[name]">
        <input type="hidden" name="data[plan_id]" value="<?= empty($plan_id) ? '':$plan_id ?>">
      </div>
    </div>

    <div style="height:auto;" class="resourkate">
      <div class="addpwordn">作品简介：</div>
      <div class="resease">
        <textarea name="data[info]"></textarea>
      </div>
    </div>

   <div style="height:auto;" class="resourkate">
      <div class="addpwordn">作品内容：</div>
      <div class="resease" style="height:auto;">
        <textarea name="data[content]" id="content"></textarea>
      </div>
    </div>

   <div style="padding-bottom:70px" class="resourkate">
      <div class="addpwordn">上传附件：</div>
      <div class="addfile">
       <input id="file_path" name="data[file_path]" type="hidden" value=""/>
       <iframe style="border:0px;padding-bottom: 20px;" src="/Uploadfiles/uploadfileform?fileid=file_path&allowed_extensions=jpg|gif|rmvb|flv|rm|mp4|doc|xls|zip|pdf&overwrite=False&encrypt_name=TRUE&fileinfoid=fileinfoid&uppath=<?=!empty($dir)? $dir['upload_url']:"/upload/product/file/"?>" width="760px" height="54px;">
       </iframe>
      </div>
    </div>

    <div class="resourkate" style="margin-bottom:20px">
      <div class="addpwordn">上传预览图：</div>
      <div class="addfile">
       <input id="demo_path" name="data[demo_path]" type="hidden" value=""/>
       <iframe style="border:0px;padding-bottom: 20px;" src="/Uploadfiles/uploadfileform?fileid=demo_path&allowed_extensions=jpg|gif|&overwrite=False&encrypt_name=TRUE&fileinfoid=fileinfoid&uppath=<?=!empty($dir)? $dir['upload_url']:"/upload/product/demo/"?>" width="760px" height="54px;">
       </iframe>
      </div>
    </div>
      
    <div style="padding-top:40px; width:705px;" id="sendbut" class="resourkate">
      <div class="addbutdel"><input type="button" value="取消" class="addbut" onclick="location.href='/study_plan/index'"></div>
      <div class="addbutin"><input type="submit" value="保存" class="addbut"></div>
    </div>
  </form>
</div>