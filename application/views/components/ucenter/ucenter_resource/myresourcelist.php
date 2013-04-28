<div class="noticewarp">

  <div class="noticetit">
    <h1><img src="/resource/images/resour.gif" />我上传的资源</h1>
  </div>

  <div class="noticenwarp">

    <div class="noticekatebox">
      <div class="notiness">共有资源<span><?= $count?></span>条</div>
      <form id="search_form" action="/ucenter_resource/myresourcelist" onsubmit="return checkSearch(this);"  method="get">
        <div class="serchbox">
          <div class="serchninput"><input type="text" value="<?= isset($get[ 'name' ]) ? $get[ 'name' ]  : '请输入资源名称' ?>" onclick="this.value=''" name="name"></div>
          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
        </div>
      </form>
    </div>

    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="datasend"><a href="/ucenter_resource/myresourceedit" title="新建">新建资源</a></div>
      </div>
      <?=$pagination?>
    </div>

    <div class="databox">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="8%">序号</th>
            <th width="57%">资源名称</th>
            <th width="10%">上传时间</th>
            <th width="10%">状态</th>
            <th width="15%">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ($list as $k => $v) {?>
          <tr>
            <td><?=$PB_page+$k+1;?></td>
            <td><a href="/ucenter_resource/myresourcedetail/<?=$v['id'];?>" title="点击查看详细"><?=$v['name'];?></a></td>
            <td><?= date('Y-m-d', strtotime($v['created'])); ?></td>
            <td><?=$RESOURCE_STATUS[$v['status']];?></td>
            <td><a title="编辑" href="/ucenter_resource/myresourceedit?id=<?=$v['id'];?>">编辑</a>&nbsp;|&nbsp;
              <a title="删除" href="/ucenter_resource/myresourcedel?id=<?=$v['id'];?>" onclick="javascript:return confirm('您确定要删除此资源吗?');">删除</a>
            </td>
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