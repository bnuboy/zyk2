
<div class="navgation">首页 > <?=$menu['name'];?></div>

<div class="content">
  <div class="Cleft">
    <!--新闻资讯 begin-->
    <div class="sub_news">
      <div class="news-top">
        <h3><?=$menu['name'];?>列表</h3>
       <span>共有新闻资讯<?=$count?>篇，当前第<?=$PB_page?>页</span></div>
      <div class="sn-list">
        <?php foreach($list as $k => $v){?>
      <dl>
        <dt><a target="_blank" href="/cms/articledetail/<?=$v['id'];?>?menuid=<?=$v['menu_id'];?>"><?=Util::cut_str($v['subject'], 30);?></a><em><?=$v['created']?></em></dt>
      <dd>
        <img src="<?=$v['img'];?>" width="100"  /><?=Util::cut_str($v['intro'], 150);?>
      </dd>
      </dl>
        <?php } ?>
      </div>
      <div class="page"><?=$pagination;?></div>
      
      
      
    </div>
    <!--新闻资讯 end-->
    <!--课程展示 begin-->
    <!--课程展示 end-->
  </div>
  <div class="Cright">
    <!--政策法规 begin-->
    <div class="zy rboder ">
      <div class="title">最新资讯</div>
      <div class="zy-cont">
        <ul class="zcfg">
          <?php foreach($news as $k => $v){ ?>
          <li> <a target="_blank" href="/cms/articledetail/<?=$v['id'];?>?menuid=<?=$v['menu_id'];?>"> • <?=Util::cut_str($v['subject'], 24)?></a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <!--政策法规 end-->
  </div>
</div>