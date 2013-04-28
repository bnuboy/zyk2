<script>
  $( "#birthday" ).datepicker({ dateFormat: 'yymmdd',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'] });
  $(function(){
    $( "#start_time" ).datepicker({ dateFormat: 'yymmdd',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
  })
</script>
<link rel="stylesheet" href="/resource/css/jquery-ui.css">
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<script src="/resource/js/validate.expand.js" type="text/javascript"></script>

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
              "data[login_name]": {required:true, rangelength:[5,12], remote:"/admin_user/checkreg?type=login_name&defaulval=<?=!empty($data['login_name']) ? $data['login_name'] : '';?>"},           
              "data[password]": {required:true, rangelength:[5,12]},
              //"repassword": {required:true, equalTo:"#password" },  
              "data[name]": {required:true},
              "data[address]": {required:true},
              "data[email]": {required:true, email:true, remote:"/admin_user/checkreg?type=email&defaulval=<?=!empty($data['email']) ? $data['email'] : '';?>"},
              "data[student_id]": {required:true, remote:"/admin_user/checkreg?type=student_id&defaulval=<?=!empty($data['student_id']) ? $data['student_id'] : '';?>"},
              "data[birthday]": {required:true},
              "data[mobile]": {required:true},
              "data[organization_id]": {required:true},
              "data[type]":{required:true}
          },
          messages: {
              "data[login_name]": {required:"请填写登录名", rangelength:[5,12], remote:"此登录名已被占用"},  
              "data[password]": {required : "请填写登录密码",  rangelength:"密码长度为5-12位"},
              //"repassword": {required:'请填写重复密码', equalTo:'两次密码不一致'},
              "data[name]": {required : "请填写姓名"},
              "data[address]": {required : "请填写地址"},
              "data[email]": {required : "请填写电子邮件", email:"格式错误", remote:"此邮箱已被占用"},
              "data[student_id]": {required : "请填写学号", remote:"此学号已被占用"},
              "data[birthday]": {required : "请选择出生日期"},
              "data[mobile]": {required : "请填写电话"},
              "data[organization_id]": {required : "请选择所属院系"},
              "data[type]":{required:'请选择身份'}
          }
         /* 
         //重写错误显示消息方法,以alert方式弹出错误消息
        showErrors: function(errorMap, errorList) {  
            var msg = "";  
            $.each( errorList, function(i,v){  
              msg += (v.message+"\r\n");  
            });  
            if(msg!="") alert(msg);  
        },  
        //失去焦点时不验证
        onfocusout: false  
        */      
      });
  });

  $( "#birthday" ).datepicker({ dateFormat: 'yymmdd',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'] });
    $(function(){
    $( "#start_time" ).datepicker({ dateFormat: 'yy-mm-dd 00:00:00',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
    $( "#end_time" ).datepicker({ dateFormat: 'yy-mm-dd 00:00:00',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
  });
  
 
 </script>
<form action="/admin_user/edit" enctype="multipart/form-data" method="post" id="sub_form">
  <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
  <div class="noticewarp">

    <div class="noticetit">
      <h1>用户管理-<?php echo !empty($data['id'])?"编辑":"新增"; ?></h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox" style="padding-top:30px;">
        <div class="maddpword">登录名：</div>
        <div class="maddness"><input name="data[login_name]" type="text" value='<?=isset($data['login_name']) ? $data['login_name'] : '' ;  ?>'/><span class="must_star" >*</span></div>
        
        <div class="maddpword">登录密码：</div>
        <div class="maddness"><input name="data[password]" id="password" type="password" value=''/><span class="must_star" >*</span></div>
       
        <div class="maddpword">邮件地址：</div>
        <div class="maddness"><input name="data[email]" type="text" value='<?=isset($data['email']) ? $data['email'] : '' ;  ?>'/><span class="must_star" >*</span></div>
      </div>

      <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">姓名：</div>

        <div class="maddness"><input name="data[name]" type="text" value='<?=isset($data['name']) ? $data['name'] : '' ;  ?>'/><span class="must_star" >*</span></div>
        <!-- if(empty($data['id']))
        <div class="maddpword">重复密码：</div>
        <div class="maddness"><input name="repassword" id="repassword" type="password" value=''/><span class="must_star" >*</span></div>
       -->
        <div class="maddpword">生日：</div>

        <div class="maddness"><input  name="data[birthday]" type="text" id="start_time" value='<?=isset($data['birthday']) ? $data['birthday'] : '' ;  ?>'/><span class="must_star" >*</span></div>
      </div>

      <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">地址：</div>

        <div class="maddness"><input name="data[address]" type="text" value='<?=isset($data['address']) ? $data['address'] : '' ;  ?>'/><span class="must_star" >*</span></div>
        <div class="maddpword">电话：</div>

        <div class="maddness"><input name="data[mobile]" type="text" value='<?=isset($data['mobile']) ? $data['mobile'] : '' ;  ?>'/><span class="must_star" >*</span></div>
      </div>
      <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">学号：</div>
        <div class="maddness"><input name="data[student_id]" type="text" value='<?=isset($data['student_id']) ? $data['student_id'] : '' ;  ?>'/><span class="must_star" >*</span></div>
        <div class="maddpword">个人主页：</div>

        <div class="maddness"><input name="data[website]" type="text" value='<?=isset($data['website']) ? $data['website'] : '' ;  ?>'/></div>
      </div>
      <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">性别：</div>

        <div class="maddness" style="padding-top:6px">
          <label><input checked style="width:30px;height:12px;" name="gender" value="m" type="radio"/><span style="font-size:14px">男</span></label>
          &nbsp;<label><input style="width:30px;height:12px;" name="gender" value="f" type="radio"/><span style="font-size:14px">女</span></label>
        </div>
        
      </div>
      <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">所属院系：</div>
        <div class="maddness">
            <select name="data[organization_id]" style="padding:6px;">
              <option value="">==请选择==</option>
              <?php foreach( $organizations as $k => $v ){ ?>
                <option value="<?=$v['id'];?>" <?= isset($data['organization_id']) && $v['id'] == $data['organization_id'] ? "selected" : "" ?>><?=$v['name'];?></option>
              <?php } ?>
            </select><span class="must_star" >*</span>
        </div>
        
      </div>

      <div class="noticekatebox" style="width:800px;height:58px;">
        <div class="maddpword">头像：</div>
        <div  class="maddness"  style="width:600px;height:58px;">
          <input name="data[face]" id="face" type="hidden" value="<?=isset($data['face']) ? $data['face'] : ''; ?>"/>
          <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=face&defaultvalue=<?php echo empty($data['face']) ? '' : $data['face']?>&allowed_extensions=gif|jpg|sql&overwrite=false&encrypt_name=false"
           frameBorder="no" scrolling="no" width="400px" height="54px;"></iframe>
        </div>
      </div>

      <div class="noticekatebox" style="width:800px;height:58px;">
        <div class="maddpword">身份：</div>
        <div  class="maddness"  style="width:600px;height:58px;">
              <select style="padding:6px;" name="data[type]" >
                  <option value="">==请选择==</option>
                <?php foreach ( $USER_TYPE as $key => $value ) { ?>
                  <option value="<?= $key ?>" <?=(!empty($data['type']) && $data['type'] == $key) ? 'selected' : '';?>><?= $value ?></option>
                <?php } ?>
              </select><span class="must_star" >*</span>
        </div>
      </div>


      <div class="noticekatebox" style="padding-bottom:150px;">
        <div class="maddpword">个人简介：</div>

        <div class="addpease">
          <textarea  name="data[description]"><?=isset($data['description']) ? $data['description'] : '' ;  ?></textarea>
        </div>
      </div>
      <div class="basebutbox">
       <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
       <div class="addbutin"><input type="submit" class="addbut" value="保存"/></div>
      </div>
    </div>

  </div>

  
</form>