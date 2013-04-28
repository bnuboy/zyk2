<div class="noticewarp">

  <div class="noticetit">
    <h1><img src="/resource/images/script_add.png" />我的回复</h1>
  </div>

  <div class="noticenwarp">

    <div class="noticekatebox">
      <div class="centnoticerav">
        <ul>
          <li><a href="/ucenter_post/mypost" title="我的帖子">我的帖子</a>(<span><?=$mypost;?></span>)</li>
          <li class="over"><a href="/ucenter_post/myreply" title="我的回复">我的回复</a>(<span><?=$count;?></span>)</li>
        </ul>
      </div>
      <form id="search_form" action="/ucenter_post/myreply" onsubmit="return checkSearch(this);"  method="get">
        <div class="serchbox">
          <div class="serchninput"><input type="text" value="<?= isset($get[ 'keyword' ]) ? $get[ 'keyword' ] : '请输入帖子标题或内容' ?>" onclick="this.value=''" name="keyword"></div>
          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
        </div>
      </form>
    </div>


    <div class="databox">
      <form action="/ucenter_msg/msgdel?optype=send" id="sub_form" method="post">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <!--<th style="width:5%;">&nbsp;</th>-->
            <th style="width:80%;">回复内容</th>
            <th style="width:20%;">回复时间</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach($list as $k => $v):?>
          <tr>
            <!--<td><input class="check" name="item_id[]" value="<?=$v['msgid'];?>" type="checkbox"/></td>-->
            <td><a href="/forum/view/<?=$v['parent_id'];?>"><?=$v['content'];?></a></td>
            <td><?=$v['created'];?></td>
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
