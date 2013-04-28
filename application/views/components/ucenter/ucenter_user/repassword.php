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
              "oldpassword": {required:true},
              "newpassword": {required:true, rangelength:[5,12]},
              "repassword": {required:true, equalTo:"#newpassword" }
          },
          messages: {
              "oldpassword": {required:'请填写原始密码'},
              "newpassword": {required:'请填写新密码',  rangelength:"密码长度为5-12位"},
              "repassword": {required:'请填写重复密码', equalTo:'两次密码不一致'}
          }
      });
  });
</script> 
    <div class="noticewarp">
                    
                    <div class="noticetit">
                        <h1><img src="/resource/images/nessus.gif" />密码修改</h1>
                    </div>
                    
                    <div class="noticenwarp" style="height:560px;">
                    	<div class="cendatarav">
                        	<ul>
                            	<li><a href="/ucenter_user/myinfoedit" title="资料修改">资料修改</a></li>
                                <li class="over"><a href="/ucenter_user/repassword" title="密码修改">密码修改</a></li>
                                <li><a href="/ucenter_user/myloginlog" title="登录记录">登录记录</a></li>
                            </ul>
                        </div>                        
                        <form action='/ucenter_user/repassword' method='post' id="sub_form">
                        	<div class="noticekatebox">
                                <div class="addpwordn">原密码：</div>
                                <div class="addfile" style="width:500px;"><input name="oldpassword" id="oldpassword" type="password"/></div>
                            </div>
                            
                            <div class="noticekatebox">
                                <div class="addpwordn">新密码：</div>
                                <div class="addfile" style="width:500px;"><input name="newpassword" id="newpassword" type="password"/></div>
                            </div>
                            
                            <div class="noticekatebox">
                                <div class="addpwordn">重复密码：</div>
                                <div class="addfile" style="width:500px;"><input name="repassword" id="repassword" type="password"/></div>
                            </div>
                            
                            <div class="noticekatebox" id="sendbut" style="margin-top:10px; width:398px;">
                                <div class="addbutdel"><input type="reset" name="reset" class="addbut" value="重置" /></div>                        
                                <div class="addbutin"><input type="submit"  class="addbut" value="保存" /></div>
                            </div>
                        
                        </form>
                    </div>
                    
                </div>
            