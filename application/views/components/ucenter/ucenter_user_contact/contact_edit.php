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
              "data[add_user_id]": {required:true, remote:"/ucenter_user_contact/checkuser?default_add_user_id=<?=empty($data['add_user_id']) ? '' : $data['add_user_id']?>"}              
          },
          messages: {
              "data[add_user_id]": {required:"请选择用户", remote:"此用户已存在通讯录中！"}             
          }
      });
  });
</script>
    <div class="noticewarp">

      <div class="noticetit">
        <h1><img src="/resource/images/emailedit.gif" />通讯录-<?php echo !empty($data['id'])?"编辑":"新增"; ?></h1>
      </div>
      <form action="/ucenter_user_contact/contact_edit" method="post" id="sub_form" name="sub_form">
        <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
        <div class="noticenwarp">

          <div style="padding-top:30px;" class="noticekatebox">
            <div class="maddpword">用户名：</div>
            <div style="width:500px;" class="maddness">
              <select name="data[add_user_id]" id="add_user_id" style="padding:6px;" >
                <option value="">==请选择==</option>
                <?php foreach($users as $k => $v){ ?>
                <option value="<?=$v['id'];?>" <?=(isset($data['add_user_id']) && $data['add_user_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?>&nbsp;[<?=isset($USER_TYPE[$v['type']]) ? $USER_TYPE[$v['type']] : '' ?>]</option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div style="padding-top:30px;" class="noticekatebox">
            <div class="maddpword">分组：</div>
            <div class="maddness">
              <select name="data[contact_group_id]" id="contact_group_id" style="padding:6px;" >
                <option value="0">未分类</option>
                <?php foreach($groups as $k => $v){ ?>
                <option value="<?=$v['id'];?>" <?=(isset($data['contact_group_id']) && $data['contact_group_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?></option>
                <?php } ?>
              </select>
            </div>
          </div>

        </div>
        <div class="basebutbox">
          <div class="addbutdel"><input type="button" value="取消" class="addbut" onclick="javascript:history.go(-1);"/></div>
          <div class="addbutin"><input type="submit" value="保存" class="addbut"></div>
        </div>
      </form>
    </div>

    </div>
