
<div class="navgation">首页 > <?=$menu['name'];?></div>

<div class="content">
  <div class="Cleft">
    <!--内容 begin-->
    <div class="sub_news">
      <div class="sc-title"><h3><?=$info['subject'];?></h3>
      <span><?=$info['created'];?>  &nbsp;  </span></div>
    
    <!--内容块 begin-->
      <div class="sc-cont">
        <?=$info['content'];?>
      </div>
       <!--内容块 end-->   
      
    </div>
    <!--内容 end-->
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
