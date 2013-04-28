<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$HTML_BLOCK['title'];?></title>
    <link type="text/css" href="/resource/css/webindex.css" rel="stylesheet" />
    <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
    <style>
      .forgot{ width:800px; margin:20px auto; padding:20px 0px 40px; font-size:16px; line-height:35px; background-color:#fff; border-radius:5px; border:1px solid #e9e9e9;}
      .forgot h3{ font-size:14px; line-height:25px; padding-left:20px;}
      .email-input{ text-align:center; padding-top:20px;}
      .email-input input.text{ width:300px; height:25px; line-height:25px; border:1px solid #e6e6e6}
      .email-input input.btn{ background-image:url(/resource/images/coredia.jpg); width:67px; height:30px; border:0px; cursor:pointer; margin-left:5px; color:#fff; font-weight:bold}
      .email_infor{ background:url(/resource/images/send.png) no-repeat left center; padding-left:40px; line-height:32px; margin-left:30px; margin-top:5px;}
    </style>
    <script>
        $(function(){
            pload();
        })
        function pload(){
            setTimeout("location.href='http://zyk.hncc.edu.cn'",3000);
        }
        </script>
  </head>
  <body>

    <!--头部-->
    <div class="p_topbg">
      <div class="counter">
        <div class="indextoprav"><a title="设为首页" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://zyk.hncc.edu.cn');" href="javascript:;">设为首页</a>&nbsp;|&nbsp;<a href="javascript:window.external.AddFavorite('http://zyk.hncc.edu.cn', '高教资源')">加入收藏</a>&nbsp;|&nbsp;<a href="#" title="网站地图">网站地图</a></div>
      </div>
    </div>
    <!--头部 end-->
    <div class="loginbox">
      <div style="padding-top:25px;"></div>
      <form action="/front/reg_key" id='form1' method="post" accept-charset="utf-8">
        <div class="forgot">
          <h3>新的密码已发送到你邮箱。&nbsp;&nbsp;&nbsp;</h3>
        </div>
      </form>

      <!--底部 -->
      <div class="footer"><?=$HTML_BLOCK['footer'];?></div>
      <!--底部  end-->

    </div>

  </body>
</html>
