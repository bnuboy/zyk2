<script type="text/javascript" src="/resource/js/admin/common.js"></script>

<div class="noticewarp">

  <div class="noticetit">
    <h1>系统公告管理</h1>
  </div>
    
  <div class="noticenwarp">
     
     <div class="noticekatebox1">
	      <form action="/admin_sys_notice/noticelist"  method="get">
	
	        <div class="notiness">共有公告<span><?= $count ?></span>条</div>
	
	        <div class="notiness" style="margin-right:-3px;">
        </div>

	        <div class="serchbox1">
	         <div class="serchninput1"><input type="text" value="<?= isset($get[ 'title' ]) ? $get[ 'title' ] : '' ?>" onclick="$('#searchtitle').val('')" id="searchtitle" name="title"></div>
	          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
	        </div>
	      </form>
	</div>
     
    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量删除操作吗？', '请选择要删除的数据')" title="删除">删除</a></div>
        <div class="manageadd"><a href="/admin_sys_notice/noticeedit" title="新增系统公告">新增公告</a></div>
      </div>

      <?= $pagination ?>

    </div>

    <div class="databox">
      <form id="sub_form" name="sub_form" method="post" action="/admin_sys_notice/noticedel">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th style="width:5%;">&nbsp;</th>
            <th style="width:30%;">公告标题</th>
            <th style="width:10%;">接收对象</th>
            <th style="width:10%;">浏览量</th>
            <th style="width:15%;">状态</th>
            <th style="width:10%;">创建时间</th>
            <th style="width:20%;">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $k => $v ) { ?>
            <tr>
              <td><input class="check" name="item_id[]" value="<?= $v['id']; ?>" type="checkbox"/></td>
              <td><?=$v['title']; ?></td>
              <td><?=($v['target'] == 'all') ? '不限' : $USER_TYPE[$v['target']]; ?></td>
              <td><?=$v['view']; ?></td>
              <td>
                <?php
                if($v['type'] == "draft"){
                    echo  "<a href='/admin_sys_notice/changestatus?id=".$v['id']."&status=publicnotice' title='点击改变状态'><img src='/resource/images/lock.gif' border='0'>草稿</a>";
                }else if($v['type'] == "publicnotice"){
                    echo  "<a href='/admin_sys_notice/changestatus?id=".$v['id']."&status=draft' title='点击改变状态'><img src='/resource/images/exclamation.png' border='0'>已发布</a>";
                }
                ?>
              </td>
              <td><?= date('Y-m-d', strtotime($v['created'])); ?></td>
              <td>
                <a href="/admin_sys_notice/noticeedit?id=<?= $v['id']; ?>" title="编辑">编辑<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" /></a>&nbsp;|&nbsp;
                <a href="/admin_sys_notice/noticedel?id=<?=$v['id'];?>" title="删除" onclick="javascript:return confirm('您确定要删除此系统公告吗?');">删除<img align="middle" src="/resource/images/del.gif" width="16" height="17" /></a>
              </td>
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