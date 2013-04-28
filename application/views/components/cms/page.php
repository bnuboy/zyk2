<link href="/resource/css/cms/sub.css" type="text/css" rel="stylesheet" />
<div class="news-cont">
 <div class="nc-left">
  <?php 
  foreach($pages as $k => $v){ 
      $class = "";
      if($id == $v['id']) $class = "hver";
      echo "<a href='/cms/page?menuid=".$v['menu_id']."&id=".$v['id']."' class='".$class."'><span></span>".$v['subject']."</a>";
  }
  ?>
 </div>
 <div class="nc-right">
  <div class="ncr-title"><?=$page['subject'];?></div>
  <div class="ncr-cont"><?=$page['content'];?></div>
 </div>
</div>