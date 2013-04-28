<div class="noticewarp">

  <div class="noticetit">
    <h1><img src="/resource/images/date.gif" />日程安排</h1>
  </div>

  <div class="noticenwarp">

    <div class="noticekatebox">
      <div class="notiness">共有日程<span><?=$count;?></span>条</div>
      <form id="search_form" action="/ucenter_user_agenda/agendalist"  method="get">
        <div class="serchbox">
          <div class="serchninput"><input type="text" value="<?= isset($get[ 'keyword' ]) ? $get[ 'keyword' ]  : '请输入日程名' ?>" onclick="this.value=''" name="keyword"></div>
          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
        </div>
      </form>
    </div>

    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量删除操作吗？', '请选择要删除的数据')" title="删除">删除</a></div>
        <div class="datasend"><a href="/ucenter_user_agenda/agendaedit" title="新建">新建</a></div>
      </div>
      <?=$pagination?>
    </div>    

    <div class="databox">
      <form id="sub_form" name="sub_form" method="post" action="/ucenter_user_agenda/agendadel">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="7%">序号</th>
            <th width="45%">名称</th>
            <th width="15%">开始日期</th>
            <th width="15%">截止日期</th>
            <th width="10%">状态</th>
            <th width="13%">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ($list as $k => $v) {?>
          <tr>
            <td><input class="check" name="item_id[]" value="<?= $v['id']; ?>" type="checkbox"/></td>
            <td><a href="/ucenter_user_agenda/agendadetail/<?=$v['id'];?>"><?=$v['name'];?></a></td>
            <td><?= date('Y-m-d', strtotime($v['start_time'])); ?></td>
            <td><?= date('Y-m-d', strtotime($v['end_time'])); ?></td>
            <td><?=$CALENDER_STATUS[$v['status']];?></td>
            <td><a href="/ucenter_user_agenda/agendaedit?id=<?=$v['id'];?>">编辑</a></td>
          </tr>
            <?php } ?>
        </tbody>
      </table>
      </form>
    </div>

    <div class="noticekatebox">

      <?= $pagination ?>

    </div>

  </div>

</div>