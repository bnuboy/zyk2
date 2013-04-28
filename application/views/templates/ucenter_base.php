<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="/resource/css/center.css" rel="stylesheet" />
    <link type="text/css" href="/resource/css/center_data.css" rel="stylesheet" />
    <link type="text/css" href="/resource/css/expand.css" rel="stylesheet" />
    <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="/resource/js/common.js"></script>
<!--<link rel="shortcut icon" href="/upload/ico/favicon2.ico" type="image/x-icon" />-->
    <title><?=$HTML_BLOCK['title'];?></title>
  </head>

<body>
  <!--头部-->
  <div class="p_topbg">
   <div class="p_topp">
    <div class="logoimg">
      <img src="/resource/images/logoweb.jpg">
    </div>
    <div class="adminnotice">
      <?=$user['name']?>(<?=$USER_TYPE[$user['type']]?>)&nbsp;&nbsp;<?php $date=date('G');
      if ($date<11) echo '早上好';
      else if ($date<13) echo '中午好';
      else if ($date<17) echo '下午好';
      else echo '晚上好';?>!&nbsp;&nbsp;
      <a href="/index/logout" title="退出">退出</a>
    </div>
  </div>
  </div>
  <!--头部 end-->
<!--全站导航-->
  <div class="ravboxbg">
    <div class="ravbox">
      <?= $modules['ucenter_menus']; ?>
    </div>
  </div>
    <!--全站导航 end-->
  <!--中间内容-->
  <div class="counter counterborder">
    <div class="centerboxbg">
      <div class="centerboxbtm">
        <!--左侧信息-->
        <?= isset($modules['ucenter_left']) ? $modules['ucenter_left'] : ''; ?>
        <!--左侧信息 end-->
        <!--管理信息-->
        <div class="noticesbox">
          <?= $component ?>
        </div>
        <!--管理信息 end-->
        <div class="clear"></div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
  <!--中间内容 end-->

  <!--底部 -->
  <div class="footbg">
  <div class="footer"><?=$HTML_BLOCK['footer'];?></div>
  </div>
  <!--底部  end-->
</body>
</html>

