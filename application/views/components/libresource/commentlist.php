<?php foreach ( $infos as $key=> $item )
{?>
  <div class="resourevalnbox rescbg" >
    <div class="resourevalnup">
      <div class="resourecalntit"><?=$item['user']['name'];?><span><?=substr( $item['created'], 0,10 )?></span></div>
      <div class="resourecalnpic">
        <? for( $i=0;$i<5;$i++ ){?>
        <img  src="<?=$item['score'] > $i ? '/resource/images/starcf1.jpg' : '/resource/images/starbg.jpg'?>">
        <? }?>
      </div>
      <div class="resourecalnr"><span><?=(($PB_page-1)*$pagesize)+$key+1;?></span>位评论</div>
    </div>
    <div class="resourevalnw">
      <?=$item['comment'];?>
    </div>
  </div>
<? } ?>

<div style="height:40px;" id="evaluate_pagination" class="resourkate">
  <?=$pagenav?>
</div>