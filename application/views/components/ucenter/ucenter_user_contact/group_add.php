<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="/resource/css/center.css" rel="stylesheet" />
    <link type="text/css" href="/resource/css/center_data.css" rel="stylesheet" />
    <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
    <script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
    <title>高等职业教育教学资源中心--个人中心</title>
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
                  "data[name]": {required:"请输入分组名"}             
              }
          });
      });
    </script>

  </head>
  <body>

    <div class="noticewarp" style="min-height:0px;width:500px;">

      <div class="noticetit" style="width:500px;">
        <h1>新建联系组</h1>
      </div>
      <form action="/ucenter_user_contact/group_add" method="post" id="sub_form">
        <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
        <div class="noticenwarp" style="width:500px;">

          <div style="padding-top:30px;clear: both;height:29px;padding:13px 0 0 15px;">
            <div class="maddpword">分组名：</div>
            <div class="maddness" style="width:200px;">
              <input type="text" name="data[name]">
            </div>
          </div>

        </div>
        <div class="basebutbox">
          <div class="addbutdel"><input type="button" value="取消" class="addbut" onclick="windowclose()" /></div>
          <div class="addbutin"><input type="submit" value="保存" class="addbut"></div>
        </div>
      </form>
    </div>


    </div>
    <!--管理信息 end-->
    <div class="clear"></div>
    </div>
    </div>
    <div class="clear"></div>
    </div>


  </body>
</html>

    <script language="javascript">
      function windowclose(){
        parent.$('.iframe').colorbox.close();
      }
    </script>