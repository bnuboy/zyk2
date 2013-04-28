<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="/resource/css/webindex.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<title><?=$HTML_BLOCK['title'];?></title>
<style type="text/css">
  .search_list{ width:980px; margin:auto;}
  .red{ color:#e00000}
  .gray{ color:#888}
  .search_list ul li{ padding:10px 0px; border-bottom:1px dotted #add7e5;}
  .search_list ul li h2{ font-size:14px; padding:5px 0px;}
  .search_list ul li p{ line-height:22px;}  
  .search_list ul li p a{ color:#006699} 
  .search_list ul li p em{ font-style:normal; margin-left:20px;}  
  .Spage{ width:980px; margin:auto; clear:both; padding:30px 0px 100px; text-align:center}
  .Spage a{ display:inline; padding:5px 8px; border:1px solid #d7d7d7; color:#666; margin:0px 5px;}
  .Spage a.hver,.Spage a:hover{ background-color:#0066cc; border:1px solid #0066aa; color:#fff; font-weight:bold}
</style> 
</head>
<body>
<!--头部-->
<div class="p_topbg">
  <div class="p_topp">
     <div class="logoimg">
      <img src="/resource/images/logoweb.jpg">
     </div> 
	<div class="indextoprav"><a href="/" title="返回首页">返回首页</a></div>

  </div>
</div>
<!--头部 end-->


<?= $component ?>

<!--底部 -->
<div class="footbg">
<div class="footer">
	<?=$HTML_BLOCK['footer'];?>
</div>
</div>
<!--底部  end-->
</body>
</html>

