<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$HTML_BLOCK['title'];?></title>
    <link type="text/css" href="/resource/css/webindex.css" rel="stylesheet" />
    <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
    <style>
      .forgot{ width:980px; height:446px; margin:0px auto; padding:20px 0px 40px; font-size:16px; line-height:35px; background-color:#fff; border-radius:5px; border:1px solid #D7D7D7;font-family:"微软雅黑";}
      .email-input{ padding-left: 250px;  padding-top: 20px; text-align: left;}
      .email-input input.text{ width:300px; height:32px; line-height:32px; border:1px solid #b6b5b5;box-shadow:0 2px 5px #c6c6c6 inset}
      .email-input input.btn{ background-image:url(/resource/images/coredia.jpg); width:85px; height:35px; border:0px; cursor:pointer; margin-left:5px; color:#fff; font-weight:bold}
      .email_infor{ background:url(/resource/images/send.png) no-repeat left center; padding-left:40px; line-height:32px; margin-left:30px; margin-top:5px;}
    </style>
  </head>
  <body>

    <!--头部-->
    <div class="p_topbg">
     <div class="p_topp">
      <div class="counter">
       <div style="width:400px; float:left">
         <img src="/resource/images/logoweb.jpg">
       </div>
        <div class="indextoprav"><a title="设为首页" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://zyk.hncc.edu.cn');" href="javascript:;">设为首页</a>&nbsp;|&nbsp;<a href="javascript:window.external.AddFavorite('http://zyk.hncc.edu.cn', '高教资源')">加入收藏</a>&nbsp;|&nbsp;<a href="#" title="网站地图">网站地图</a></div>
      </div>
    </div>
    </div>
    <!--头部 end-->
    <div class="loginbox">
      <form action="/index/reg_key" id='form1' method="post" accept-charset="utf-8">
        <div class="forgot">
          <div class="codeindexline">
           <h3 class="findcode">找回密码</h3>
           <div class="returnindex"> <h3"><a href="javascript:history.go(-1);" style="color:#2D94D5;"><<返回首页</a></h3></div>
          </div>
          <div style=" clear:both"></div>
          <div class="email-input"> 
            邮&nbsp;&nbsp;&nbsp;&nbsp;箱：<input name="email" type="text" class="text" />
            <div class="email_infor">注：提交后密码将被修改，新密码将发送到您的邮箱。</div>
          </div>
          <div class="email-input">
            验证码：<input style="width:145px" type="text" name="code" id="code" class="text" />
          </div>
          <div class="email-input" style="padding-left:310px;">
            <img src="/index/getcode" width="75" height="27" align="middle" id="imgcode"/>
            <a href="#this" onclick="$('#imgcode').attr('src', '/index/getCode/'+Math.random())">换一张</a>
          </div>
          <div class="email-input" style="padding-left:310px;"> 
            <input name="" type="submit" class="btn" value="发送" />
          </div>
        </div>
      </form>

    </div>
    
      <!--底部 -->
      <div class="footbg">
        <div class="footer"><?=$HTML_BLOCK['footer'];?></div>
      </div>
      <!--底部  end-->
  </body>
</html>
