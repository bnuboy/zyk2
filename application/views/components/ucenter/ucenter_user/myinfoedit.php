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
              "data[name]": {required:true},
              "data[student_id]": {required:true},
              "data[gender]": {required:true},
              "data[email]": {required:true, email:true},
              "data[address]": {required:true},
              "data[mobile]": {required:true},
              "data[description]": {required:true}
          },
          messages: {
              "data[name]": {required:'请填写真实姓名！'},
              "data[student_id]": {required:'请填写学号！!'},
              "data[gender]": {required:'请选择性别！'},
              "data[email]": {required:'请填写电子邮件！', email:'电子邮件格式错误！'},
              "data[address]": {required:'请填写通讯地址！'},
              "data[mobile]": {required:'请填写联系电话！'},
              "data[description]": {required:'请填写个人简介！'}
          }
      });
  });
</script>
<div class="noticewarp">

  <div class="noticetit">
    <h1>个人信息</h1>
  </div>

  <div class="noticenwarp">
    <div class="cendatarav">
      <ul>
        <li class="over"><a href="/ucenter_user/myinfoedit" title="资料修改">资料修改</a></li>
        <li><a href="/ucenter_user/repassword" title="密码修改">密码修改</a></li>
        <li><a href="/ucenter_user/myloginlog" title="登录记录">登录记录</a></li>
      </ul>
    </div>
    <form action='/ucenter_user/myinfoedit' method='post' id="sub_form" name="sub_form">
     
      <div class="noticekatebox"  style="padding-top:0px;">
        <div class="addpwordn">用户名：</div>
        <div class="cendatawn"><?= $user['login_name']; ?></div>
      </div>

      <div class="noticekatebox"  style="padding-top:0px;">
        <div class="addpwordn">用户身份：</div>
        <div class="cendatawn"><?= $USER_TYPE[ $user['type'] ] ?></div>
      </div>
      <div class="noticekatebox"  style="padding-top:0px;">
        <div class="addpwordn">所在院系：</div>
        <div class="cendatawn"><?= isset($org['name']) ? $org['name'] : ''; ?></div>
      </div>
      <div class="noticekatebox"  style="padding-top:0px;">
        <div class="addpwordn">学号：</div>
        <div class="cendatawn"><?= $user['student_id']; ?></div>
      </div>


      <div class="noticekatebox">
        <div class="addpwordn">头像：</div>
        <div class="addfile" style="width:600px;height:58px;">
          <input name="data[face]" id="face" type="hidden" value="<?=isset($user['face']) ? $user['face'] : ''; ?>"/>
          <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=face&defaultvalue=<?php echo empty($user['face']) ? '' : $user['face']?>&allowed_extensions=gif|jpg|png&overwrite=false&encrypt_name=false&uppath=/upload/users/face/" width="600px" height="58px;"></iframe>
        </div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn">真实姓名：</div>
        <div class="addfile"><input name="data[name]" type="text" value='<?= $user['name']; ?>'/></div>
        <div class="cendatawn"><span class="must_star">*</span></div>
      </div>



      <div class="noticekatebox" style="padding-top:0;">
        <div class="addpwordn">性别：</div>
        <div class="addpnotwn">
          &nbsp;<label><input name="data[gender]" type="radio" value="m" <?= $user['gender'] == "m" ? "checked='checked'" : "" ?> />&nbsp;&nbsp;男</label>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="data[gender]" value="f" <?= $user['gender'] == "f" ? "checked='checked'" : "" ?> />&nbsp;&nbsp;女</label>
        </div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn">电子邮件：</div>
        <div class="addfile"><input name="data[email]" type="text" value='<?= $user['email']; ?>'/></div>
        <div class="cendatawn"><span class="must_star">*</span></div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn">通讯地址：</div>
        <div class="addfile"><input name="data[address]" type="text" value='<?= $user['address']; ?>'/></div>
        <div class="cendatawn"><span class="must_star">*</span></div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn">联系电话：</div>
        <div class="addfile"><input name="data[mobile]" type="text" value='<?= $user['mobile']; ?>'/></div>
        <div class="cendatawn"><span class="must_star">*</span></div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn">个人主页：</div>
        <div class="addfile"><input name="data[website]" type="text"  value='<?= $user['website']; ?>'/></div>
      </div>

      <div class="noticekatebox" style="height:95px;">
        <div class="addpwordn">个人简介：</div>
        <div class="resease"><textarea name="data[description]"><?= $user['description']; ?></textarea></div>
      </div>

      <div class="noticekatebox" id="sendbut" style="margin-top:10px; width:708px;">
        <div class="addbutdel"><input type="reset" name="reset" class="addbut" value="重置" /></div>
        <div class="addbutin"><input type="submit"  class="addbut" value="保存" /></div>
      </div>

    </form>
  </div>

</div>