<div class="noticewarp">

  <div class="noticetit">
    <h1><img src="/resource/images/bell.gif" />系统公告</h1>
  </div>

  <div class="noticenwarp">

    <div class="noticekatebox">
      <div class="notiness">共有公告<span><?= $count?></span>条</div>
      <form id="search_form" action="/ucenter_sys_notice/noticelist"  method="get">
        <div class="serchbox">
          <div class="serchninput"><input type="text" value="<?= isset($get[ 'keyword' ]) ? $get[ 'keyword' ]  : '请输入公告标题' ?>" onclick="this.value=''" name="keyword"></div>
          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
        </div>
      </form>
    </div>

    <div class="noticekatebox">
      <?=$pagination?>
    </div>

    <div class="databox">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="5%">序号</th>
            <th width="65%">公告名称</th>
            <th width="10%">优先级</th>
            <th width="10%">发布时间</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ($list as $k => $v) {?>
          <tr>
            <td><?php echo (($PB_page-1)*$pagesize)+$k+1;?></td>
            <td><a href="/ucenter_sys_notice/noticedetail/<?=$v['id'];?>"><?=$v['title'];?></a></td>
            <td><?=$PUBLICNOTICE_LEVEL[$v['level']];?></td>
            <td><?= date('Y-m-d', strtotime($v['created'])); ?></td>
          </tr>
            <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="noticekatebox">

      <?= $pagination ?>

    </div>

  </div>

</div>