<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="/resource/css/webindex.css" rel="stylesheet" />
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
              $.post('/index/login', {login_name:login_name, password:password, code:code}, function(data){
                  if(data == 'ok'){
                      location.href = "/ucenter_course/mycourseselect";
                      //alert('登陆成功！');
                      //getloginfo();
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
                  }
              });
              return false;
          }
      }

      function getloginfo(){
          $.post('/index/getloginfo', {}, function(data){
              $("#logininbox").html(data);
          });
      }

      <?php
      if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
          echo "getloginfo();";
      }
      ?>

    </script>

<style>
 <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
.loginwbg {
    background: url("/resource/images/logind.png") no-repeat scroll 0 0 transparent;
    float: right;
    height: 274px;
    margin-right:0px;
    width: 356px;
}
<?php } ?>
</style>


  </head>
  <body>
    <!--头部-->
    <div class="p_topbg">
      <div class="counter">
        <div style="width:400px; float:left"><img src="/resource/images/logoweb.jpg" /></div>
        <div class="indextoprav"><a title="设为首页" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://zyk.hncc.edu.cn');" href="javascript:;">设为首页</a>&nbsp;|&nbsp;<a href="javascript:window.external.AddFavorite('http://zyk.hncc.edu.cn', '高教资源')">加入收藏</a>&nbsp;|&nbsp;<a href="#" title="网站地图">网站地图</a></div>
      </div>
    </div>
    <!--头部 end-->

    <!--全站登录-->
    <div class="loginbox" style="height:282px">
      <div class="loginbg" style="background:none;">
        <div class="newg">
         <div class="newg-t"><h2>公告栏</h2><a href="/public_search/notice_list"  style='color:#11538c;font-family:"微软雅黑"'>更多>></a></div>
         <ul  class="ptop"><!-- <a href="/ucenter_sys_notice/noticedetail/<$n['id']?>">·<$n['title']?></a>-->
          <?php
            if(!empty($notice)){
          foreach($notice as $n){?>
          <li>[<?php echo $n['type'];?>]<a href="/public_search/notice_list/<?= $n['id']?>" style='color:#11538c;font-family:"微软雅黑"'>·<?= $n['title']?></a><span><?= $n['created']?></span></li>
          <?php }} ?>
         </ul>
        </div>

        <div class="loginwbg">
          <div class="logininbox" id="logininbox">
            <form name="login_form" method="post" action="#this" onsubmit="return checklog();">
              <div class="inputbox"><input id="login_name" name="login_name" type="text" class="loginin" /></div>
              <div class="inputbox"><input id="password" name="password" type="password" class="loginin" /></div>
              <div class="inputbox">
                <div class="loginyz"><input id="code" name="code" type="text" class="yzin" maxlength="5" /></div>
                <img id="imgcode" src="/index.php/common/getVerificationCode" />
                <a onclick="$('#imgcode').attr('src', '/common/getVerificationCode/'+Math.random())" href="#this">
                  换一张
                </a>
              </div>
              <div class="loingbutbox">
                <div style="float:left; _width:75px; _margin-right:5px;" class="loginbut"><input type="submit" name="send" class="wcoror" value="登录"/></div>
                <div style="float:left; _width:75px; _margin-right:5px;" class="loginbut"><input type="button" name="send" class="wcoror" value="注册" onclick="location.href='/index/register'" /></div>
                <div style="float:left; _width:75px;" class="loginpsw"><a href="/index/forgetpass" title="忘记密码？"  style='color:#11538c; float:left;font-family:"微软雅黑"'>忘记密码？</a></div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="loginend"></div>
    <!--全站登录-->
    <!--用户类型-->
    <!--<div class="counter">
      <div class="userbox">
        <div class="usertit">教师用户</div>
        <div class="userpic"><img src="/resource/images/repic1.jpg" width="96" height="106" alt="教师用户" /></div>
        <div class="userword">开发个性化课程，定制教学化内容；完成教学过程，提高教学效果；更新知识与技能，
        </div>
      </div>

      <div class="userbox1">
        <div class="usertit">学生用户</div>
        <div class="userpic"><img src="/resource/images/repic2.jpg" alt="学生用户" /></div>
        <div class="userword">开发个性化课程，定制教学化内容；完成教学过程，提高教学效果；更新知识与技能，
        </div>
      </div>

      <div class="userbox2">
        <div class="usertit">企业用户</div>
        <div class="userpic"><img src="/resource/images/repic3.jpg" alt="企业用户" /></div>
        <div class="userword">开发个性化课程，定制教学化内容；完成教学过程，提高教学效果；更新知识与技能，
        </div>
      </div>

      <div class="userbox3">
        <div class="usertit">社会学习者</div>
        <div class="userpic"><img src="/resource/images/repic4.jpg" alt="社会学习者" /></div>
        <div class="userword">开发个性化课程，定制教学化内容；完成教学过程，提高教学效果；更新知识与技能，
        </div>
      </div>

    </div>-->
    <!--用户类型 end-->
    <!--全站搜索-->

    <!--底部 -->
    <div class="footer"><?=$HTML_BLOCK['footer'];?></div>
    <!--底部  end-->


  </body>
</html>
