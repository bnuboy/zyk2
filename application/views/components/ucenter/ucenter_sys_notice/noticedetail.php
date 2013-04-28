<div class="noticewarp">

  <div class="noticetit">
    <h1><img src="/resource/images/bell.gif" />系统公告</h1>
  </div>

  <div class="noticenwarp">

    <!--<div class="noticekatebox">
      <div class="centdateback">
        <?=empty($prev['id'])? "上一条":"<a href='/ucenter_sys_notice/noticedetail/".$prev['id']."'>上一条</a>" ?>
        <?=empty($next['id'])? "下一条":"<a href='/ucenter_sys_notice/noticedetail/".$next['id']."'>下一条</a>" ?>
        <a href="/ucenter_sys_notice/noticelist">返回</a>
      </div>
    </div>-->

    <div class="centnoticetit"><h1><?=$info['title'];?><br/><span><?=$info['created']?></span></h1></div>

    <div class="centnoticebox">
      <p>
        <?=$info['comment'];?>
      </p>
    </div>

    <div class="noticekatebox">
        <div class="centdateback">
          <?=empty($prev['id'])? "上一条":"<a href='/ucenter_sys_notice/noticedetail/".$prev['id']."'>上一条</a>" ?>
          <?=empty($next['id'])? "下一条":"<a href='/ucenter_sys_notice/noticedetail/".$next['id']."'>下一条</a>" ?>
          <a href="/ucenter_sys_notice/noticelist">返回</a>
      </div>
    </div>

  </div>

</div>