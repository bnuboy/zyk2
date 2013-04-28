<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="/resource/css/global.css" rel="stylesheet" />
    <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
    <title><?=$HTML_BLOCK['title'];?></title>
    <script>
      function checklog(){
          var login_name = $("#login_name").val();
          var password   = $("#password").val();
          var code       = $("#code").val();
          if(login_name == ''){
              alert('请填写用户名！');
              return false;
          }else if(password == ''){
              alert('请填写密码！');
              return false;
          }else if(code == ''){
              alert('请填写验证码！');
              return false;
          }else{
              $.post('/admin/login', {login_name:login_name, password:password, code:code}, function(data){
                  if(data == 'okt'){
                      location.href = '/admin_resource_library/librarylist';
                  }else if(data == 'ok'){
                	  location.href = '/admin_home/index';
                  }else if(data == '1'){
                      alert('验证码错误！');
                      $("#code").val('');
                  }else if(data == '2'){
                      alert('密码错误！');
                      $("#password").val('');
                  }else if(data == '3'){
                      alert('请输入用户名或密码！');
                  }else if(data == '4'){
                      alert('用户名错误！');
                      $("#login_name").select();
                  }else if(data == '5'){
                      alert('您没有管理权限或用户已被禁用！');
                      $("#login_name").select();
                  }
              });
              return false;
          }
      }
      
    </script>
  </head>
  <body>
    <!--头部-->
    <div class="p_topbg">
     <div class="p_topp"><img src="/resource/images/logoweb.jpg"></div>
    </div>
    <!--头部 end-->

    <!--中间内容-->
    <div class="counter">

      <!--左侧模块-->
      <div class="logingrouppic"><img src="/resource/images/logingroup.jpg" alt="管理图" /></div>


      <!--左侧模块 end-->

      <!--右侧模块-->
      <div class="loginfrombox">
        <div class="loginfword">

          <!--<div class="loginfnword"><label for="name">用户名</label></div>
          <div class="loginfnword"><label for="password">密&nbsp;&nbsp;&nbsp;码</label></div>
          <div class="loginfnword"><label for="code">验证码</label></div>-->
        </div>

        <div class="loginrbox">
          <form name="login_form" method="post" action="#this" onsubmit="return checklog();">
            <!--<div class="loginfnword">管理员登录</div>-->

            <div class="logininputbg"><input name="login_name" type="text" id="login_name" maxlength="32" /></div>
            <div class="logininputbg"><input name="password" type="password" id="password" maxlength="32" /></div>
            <div class="logininputbg"><input name="code" type="text" id="code" maxlength="5" /></div>

            <div class="yzma"><img id="imgcode" src="/common/getVerificationCode" alt="验证码" /><a onclick="$('#imgcode').attr('src', '/common/getVerificationCode/'+Math.random())" href="#this">换一个</a></div>
            <div class="loginin">
              <input name="btninput" type="submit" class="inputb"  value="登录" />
            </div>
          </form>
        </div>

      </div>
      <!--右侧模块 end-->
      <div class="clear"></div>
    </div>
    <!--中间内容 end-->

    <!--底部 -->
    <div class="footer"><?=$HTML_BLOCK['footer'];?></div>
    <!--底部  end-->

    <script type="text/javascript">

      $(document).ready(function(){

        $(":button").hover(function() {
          $(this).removeClass("inputb").addClass("inputon");
        },function(){
          $(this).removeClass("inputon").addClass("inputb");
        });
      });

    </script>
  </body>

</html>
