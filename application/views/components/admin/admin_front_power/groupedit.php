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
                    "groupname": {required:true},
                    "rolename": {required:true}
                  },
          messages: {
                    "groupname": {required:"请填写群组名称"},
                    "rolename": {required:"请选择群组类型"}
                  }
      });
  });
</script>
<form action="/admin_front_power/groupedit/<?=$data['id'];?>" enctype="multipart/form-data" method="post" id="sub_form">
  <div class="noticewarp">

    <div class="noticetit">
      <h1>编辑用户群组</h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox" style="padding-top:30px;">
        <div class="maddpword">群组名：</div>
        <div class="maddness" style="width:500px;">
          <input name="groupname" type="text" value="<?=$data['groupname'];?>"/>
          <span class="must_star" >*</span>
        </div>
      </div>

      <div class="noticekatebox" style="padding-top:30px;">
        <div class="maddpword">所属类型：</div>
        <select name="rolename" style="padding:6px;">
          <option value="">请选择所属类型</option>
          <?php foreach ( $USER_ROLE as $key => $value ){ ?>
            <option value="<?= $key ?>" <?= $data['rolename'] == $key ? "selected" : "" ?>><?= $value ?></option>
<?php } ?>
        </select>
      </div>

    </div>

  </div>

  <div class="basebutbox">
    <div class="addbutdel"><input type="button" onclick="location.href='/admin_front_power/grouplist'" class="addbut" value="取消" /></div>
    <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
  </div>
</form>