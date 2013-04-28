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
              "data[name]": {required:true}         
          },
          messages: {
              "data[name]": {required : "请填写名称"}        
          }
      });
  });
</script>
<form action="/admin_study_course_cat/catedit" method="post" id="sub_form">
  <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
  <div class="noticewarp">

    <div class="noticetit">
      <h1>课程分类管理-<?php echo !empty($data['id'])?"编辑":"新增"; ?></h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox">
        <div class="addpword" >分类名称：</div>
        <div class="addfile" style="width:600px">
          <input name="data[name]" type="text" value="<?=isset($data['name']) ? $data['name'] : '' ;  ?>"/>
          <span class="must_star" >*</span>
        </div>
      </div>
      <div class="basebutbox">
        <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
        <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
      </div>
    </div>

  </div>

  
</form>










