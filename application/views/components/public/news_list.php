
<div class="content">
  <div class="Cright">
    <!--政策法规 begin-->
    <div class="zy rboder ">
      <div class="title">最新公告</div>
      <div class="zy-cont">
        <ul class="zcfg">
            <?php foreach($notice as $n){ ?>
                    <li> <a <?=$notice_id==$n['id']?"class='hver'":""?> href="/public_search/notice_list/<?=$n['id']?>"> • <?=$n['title']?></a></li>
            <?php } ?>
                  </ul>
      </div>
    </div>
    <!--政策法规 end-->
  </div>
  
  <div class="Cleft">
    <!--新闻资讯 begin-->
    <div class="sub_news">
      <div class="ncr-title"><h3><?=$info['title']?></h3></div>
      <div class="sn-list">
        <p><?=$info['comment']?></p>
       </div> 
    </div>
    <!--新闻资讯 end-->
    <!--课程展示 begin-->
    <!--课程展示 end-->
  </div>

</div>