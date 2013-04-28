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
                    "user_id": {required:true},
                    "manager_group_id": {required:true}
                  },
          messages: {
                    "user_id": {required:"请选择用户"},
                    "manager_group_id": {required:"请选择群组"}
                  }
      });
  });
</script>
<form action="/admin_manager/manageredit/<?=$data['user_id'];?>" enctype="multipart/form-data" method="post" id="sub_form">
  <div class="noticewarp">

    <div class="noticetit">
      <h1>编辑管理员</h1>
    </div>

    <div class="noticenwarp">

    <div class="noticekatebox" style="padding-bottom:20px;">
        <div class="maddpword">选择用户：</div>

        <div class="maddness" style="width:300px;">
          <select style="padding:6px;" name="user_id" >
            <option value="">==请选择==</option>
            <?php foreach ( $users as $v ){ ?>
              <option value="<?=$v['id'];?>" <?=$data['user_id'] == $v['id'] ? 'selected' : ''?>><?=$v['name'];?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="noticekatebox" style="padding-bottom:20px;">
        <div class="maddpword">所属群组：</div>
        <div class="maddness" style="width:300px;">
          <select style="padding:5px;" name="manager_group_id" >
            <option value="">==请选择==</option>
            <?php foreach ( $groups as $v ){ ?>
              <option <?=$v['id'] == $data['manager_group_id'] ? 'selected' : ''?> value="<?=$v['id'];?>"><?=$v['name'];?></option>
            <?php } ?>
          </select>
        </div>
      </div>

    </div>

  </div>

  <div class="basebutbox">
    <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
    <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
  </div>
</form>