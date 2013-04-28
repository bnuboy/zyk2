<div class="navgation">首页 > 学习中心</div>

<div class="content">
  <div class="Cright" style="width:980px;">
    <!--资源列表 begin-->
    <div class="sub_news" style="width:977px;">
      <div class="news-top"><h3>课程列表</h3></div>
      <div class="sn-list">
        <?php foreach($list as $k => $v){?>
      <dl style="width:951px;">
        <dt><a href="/study/index?course_id=<?=$v['id']?>"><?=Util::cut_str($v['name'], 30);?></a><em><?=$v['created']?></em></dt>

        <dd>
       <a target="_blank" href="<?=$v['status']=='y'?'/study/index?course_id='.$v['id']:"#this"?>"><img src="<?=$v['img'];?>" width="100"  border="0"/></a>
       <?=Util::cut_str($v['description'], 150);?>
      </dd>
      </dl>
      
        <?php } ?>
      </div>
      <div class="page"><?=$pagination;?></div>

    </div>
    <!--资源列表 end-->
  </div>
  
</div>