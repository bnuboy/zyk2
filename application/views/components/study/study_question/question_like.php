<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<script src="/resource/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        $(".iframe").colorbox({iframe:true, innerWidth:402, innerHeight:340});
        $(".callbacks").colorbox({
            onOpen:function(){ alert('onOpen: colorbox is about to open'); },
            onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
            onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
            onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
            onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
        });
				
				
        $("#click").click(function(){ 
            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
            return false;
        });
    });
      
    $(document).ready(function(){
	
        $("#resousdata>tr:odd,#ediaresousdata>tr:odd").addClass('layodd');
        $("#resousdata>tr:even,#ediaresousdata>tr:even").addClass('layeven');
    });
    function hite()
    {
        parent.$('.iframe').colorbox.close();
    }
    </script>
<title>高等职业教育教学资源中心--个人中心</title>
</head>

<body>
<div class="Stc w400">
  <div class="Stc-top"><h1>确认提问</h1></div>
  <div class="Stc-bottom zcjg">
      <form action="/study_question/tiwen_add" method="post">
    <h3>你是否想要想要问：</h3>
   <ul class="tw_list">
       <?php if(!empty($list)){?>
       <?php foreach($list as $key=>$val){?>
       <li><a href="/study_question/see_question/<?=$val['id']?>" class="iframe"><?=$val['title']?></a>    &nbsp;&nbsp;&nbsp;          <?=$val['count']?>个回答      <?=!empty($val['last_riqi']['last_time']) ? $val['last_riqi']['last_time'] : '0000:00:00 00:00:00';?> </li>
       <?php }?>
       <?php }else{?>
            没有类似的问题
       <?php } ?>
   </ul>
    <input type="hidden" name="title" value="<?=$post['title']?>" />
    <input type="hidden" name="content" value="<?=$post['content']?>" />
    <input type="hidden" name="plan_id" value="<?=$post['plan_id']?>" />
    
    <p align="right"><input type="button" class="remove"  value="取消"  onClick="return hite();"/> 
    <input type="submit" class="save" value="确认提问" /></p>
    </form>
  </div>
</div>
</body>
</html>
