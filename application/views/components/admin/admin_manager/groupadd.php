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
                    "name": {required:true}
                  },
          messages: {
                    "name": {required:"请填写群组名称"}
                  }
      });
  });
</script>
<form action="/admin_manager/groupadd" enctype="multipart/form-data" method="post" id="sub_form">
  <div class="noticewarp">

    <div class="noticetit">
      <h1>新增管理员群组</h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox" style="padding-top:30px;">
        <div class="maddpword">群组名：</div>
        <div class="maddness" style="width:500px;">
          <input name="name" type="text"/>
          <span class="must_star" >*</span>
        </div>
      </div>
   <div class="basebutbox">
    <div class="addbutdel"><input type="button" onclick="location.href='/admin_manager/grouplist'" class="addbut" value="取消" /></div>
    <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
   </div>
    </div>

  </div>

  
</form>