<?php foreach ( $list as $key=> $item )
{?>
  <div class="resourevalnbox rescbg" >
    <div class="resourevalnup">
      <div class="resourecalntit"><?=$item->username?><span><?=  substr( $item->created, 0,10 )?></span></div>
      <div class="resourecalnpic">
        <? for( $i=0;$i<5;$i++ ){?>
        <img  src="<?=$item->score > $i ? '/resource/images/starcf1.jpg' : '/resource/images/starbg.jpg'?>">
        <? }?>
      </div>
      <div class="resourecalnr"><span><?=$start+$key+1?></span>位评论</div>
    </div>
    <div class="resourevalnw">
      <?=$item->comment?>
    </div>
  </div>
<? } ?>

<div style="height:40px;" id="evaluate_pagination" class="resourkate">
  <?=$pagination?>
</div>

<div class="resourevalwritebox">
  <form id="sub_form">
    <input type="hidden" id="score" name="score" value="3" />
    <div class="resourevalwritetit">
      <div class="resoureavalwtw">打分</div>
      <div class="resoureavalwtpic" id="scoresArea">
        <img width="23" height="24" onclick="setScores(1)" src="/resource/images/starcf1.jpg">
        <img width="23" height="24" onclick="setScores(2)" src="/resource/images/starcf1.jpg">
        <img width="23" height="24" onclick="setScores(3)" src="/resource/images/starcf1.jpg">
        <img width="23" height="24" onclick="setScores(4)" src="/resource/images/starbg.jpg">
        <img width="23" height="24" onclick="setScores(5)" src="/resource/images/starbg.jpg">
      </div>
    </div>
    <div class="resoureavalin"><textarea name="comment"></textarea></div>
    <div style="width:705px; height:38px;" id="sendbut" class="resourkate">
      <div class="addbutin"><input type="button" value="评论" class="addbut" onclick="upResoureComment(<?= $resource_id ?>)"></div>
    </div>
  </form>
</div>
