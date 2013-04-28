<div class="noticewarp">

  <div class="noticetit">
    <h1><img src="/resource/images/email.gif" />站内短信</h1>
  </div>

  <div class="noticenwarp">

    <div class="noticekatebox">
      <div class="centnoticerav">
        <ul>
          <li class="over"><a href="/ucenter_msg/recevlist" title="收件箱">收件箱</a>(<span><?=$count?></span>)</li>
          <li><a href="/ucenter_msg/sendlist" title="发件箱">发件箱</a>(<span><?=$sendcount;?></span>)</li>
          <!--<li><a href="/message/draft" title="草稿箱">草稿箱</a>(<span><?=$count['draft']?></span>)</li>-->
        </ul>
      </div>
      <form id="search_form" action="/ucenter_msg/recevlist" onsubmit="return checkSearch(this);"  method="get">
        <div class="serchbox">
          <div class="serchninput"><input type="text" value="<?= isset($get[ 'keyword' ]) ? $get[ 'keyword' ] : '请输入信息标题或内容' ?>" onclick="this.value=''" name="keyword"></div>
          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
        </div>
      </form>
    </div>
    
    <div class="noticekatebox" style="width: 760px !important">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量删除操作吗？', '请选择要删除的数据')" title="删除">删除</a></div>
        <div class="datasend"><a href="/ucenter_msg/msgadd" title="写信">写信</a></div>
      </div>
      <?=$pagination?>
    </div>    


    <div class="databox">
      <form action="/ucenter_msg/msgdel?optype=recev" id="sub_form" method="post">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="20">&nbsp;</th>
            <th width="103">发信人</th>
            <th width="369">标题</th>
            <th>时间</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach($list as $k => $v):?>
          <tr>
            <td><input class="check" name="item_id[]" value="<?=$v['msgid'];?>" type="checkbox"/></td>
            <td><?=$v['sendusername'];?></td>
            <td><a href="/ucenter_msg/msgdetail?msgid=<?=$v['msgid'];?>"><?=$v['msgtitle'];?></a></td>
            <td><?=$v['msgcreated'];?></td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
      </form>
    </div>

    <div class="noticekatebox">

      <?= $pagination ?>

    </div>

  </div>

</div>
