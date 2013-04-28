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
                    "title": {required:true},
                    "ico": {required:true}
                  },
          messages: {
                    "title": {required:"请填写title"},
                    "ico": {required:"请上传图标"}
                  }
      });
  });
</script>
<form action="/admin_manager/editico" method="post" id="sub_form">

    <div class="noticewarp">

        <div class="noticetit">
            <h1>ICO设置</h1>
        </div>

        <div class="noticenwarp">

            <div class="logobox">
                <div class="logoserch">
                    <div class="logoinbox">
                        <div class="noticekatebox">
                            <div class="addpword">TITLE：</div>
                            <div style="width:600px" class="addfile">
                                <input type="text" value="" name="title">
                                <span class="must_star">*</span>
                            </div>
                        </div>
                        <div style="width:800px;height:58px;" class="noticekatebox">
                            <div class="addpwordn">ICO：</div>
                            <div style="width:600px;height:58px;" class="addfile">
                                <input type="hidden" value="" id="ico" name="ico">
                                <iframe style="border:0px;padding-bottom: 20px;" src="/Uploadfiles/uploadfileform?fileid=ico&allowed_extensions=ico&overwrite=false&encrypt_name=true&fileinfoid=fileinfoid&uppath=/upload/ico/" width="760px" height="54px;">
                               </iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>


        </div>



    </div>

    <div class="basebutbox">
        <div class="addbutin" style="margin-right:60px;"><input type="submit"  class="addbut" value="保存" /></div>
    </div>

</form>
</div>