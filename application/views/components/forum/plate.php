<link rel="stylesheet" type="text/css" href="/resource/css/forum_base.css" />
<link rel="stylesheet" type="text/css" href="/resource/css/forum.css" />
<div class="navgation">
  <!--<div class="fl"><a href="#"><img src="/resource/images/forum/home.png" width="16" height="15" /></a> > 高职资源平台论坛</div>-->
  <div class="fl">我的位置：高职资源平台论坛</div>
  <div class="fr" style="display:none">高职资源平台<b>论坛</b></div>
</div>
<div class="navg"></div>
<div class="title">
  <div class="fr"> 主题：<a href="#"><?=$subject_count?></a> 帖子：<a href="#"><?=$posts_count?></a> 今日：<a href="#"><?=$today_count?></a> 用户：<a href="#"><?=$user_count?></a></div>
</div>
<div class="bbs">
  <div class="bbs-top">高职资源平台论坛</div>
  <div class="bbsm">
    <? foreach ( $list as $plate ) { ?>
    <dl>
      <div class="listwbg"><a href="/forum/postlist/<?= $plate->id ?>"><img src="<?= $plate->icon ?>"  /></a></div>
      <dt><b> <a href="/forum/postlist/<?= $plate->id ?>"><?= $plate->title ?></a></b> <em><?= $plate->post_count ?></em> 篇帖子 <em><?= $plate->subject_count ?></em> 个主题</dt>
      <dd> <?= $plate->info ?> <span> 最后发表: <a href="/forum/view/<?=$plate->new_post_id?>"><?=$plate->new_post?> </a> <?=$plate->cmptime?></span></dd>
    </dl>
  <?php } ?>
  </div>
</div>