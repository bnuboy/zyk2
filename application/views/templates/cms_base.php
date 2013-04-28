<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$HTML_BLOCK['title'];?></title>
<link href="/resource/css/cms/base.css" type="text/css" rel="stylesheet" />
<link href="/resource/css/cms/index.css" type="text/css" rel="stylesheet" />
<link type="text/css" href="/resource/css/expand.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="/resource/js/common.js"></script>
<style>
 .logopic{ float: left; padding-top: 10px;}
 .logopic img{ float:left; padding-right:10px;}
 .logopic h1{ color:#000; font-family:"微软雅黑"; font-size:34px; font-weight:400; min-width:555px;}
</style>
</head>
<body>
<!--头部begin-->

<div class="p_topbg">
  <div class="p_topp">
    <!--<div class="logopic"><img src="<?= empty($logo['img_url'])?"/resource/images/cms/logo-pic.png":$logo['img_url']?>" width="58px" hright="54px"/><h1><?= empty($logo['title'])?"数字化学习资源中心":$logo['title']?></h1></div>-->
    <div class="logoimg">
      <img src="/resource/images/logoweb.jpg">
    </div>
    <div class="header-right" style="width:120px;">
      <p>
        <a href="/">主页</a><a href="/ucenter_course/mycourseselect">个人中心</a>
      </p>
      <div>
       <!--
        <input name="" type="text" class="search-text" />
        <input name="" type="button" class="search-btn" value="" />
        -->
      </div>
    </div>
    <div class="clear"></div>
    <?=$modules['cms_menus']?>
  </div>
</div>
<div class="ravboxbg">
</div>

<?=$component?>
 <!--底部 begin-->
<div class="footbg">
 <div class="footer">
  <div class="Ftext"><?=$HTML_BLOCK['footer'];?></div>
</div>
</div>
 <!--底部 end-->
</body>
</html>
