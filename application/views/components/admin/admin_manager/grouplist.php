<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script src="/resource/colorbox/jquery.colorbox.js"></script>
<script>
  $(document).ready(function(){
      $(".setmenus").colorbox({iframe:true, innerWidth:600, innerHeight:400});
  });
</script>

<div class="noticewarp">

  <div class="noticetit">
    <h1>管理员群组管理</h1>
  </div>

  <div class="noticenwarp">

    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="manageadd"><a href="/admin_manager/groupadd" title="新增管理员群组">新增管理员群组</a></div>
      </div>
    </div>

    <div class="databox">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="276">群组名</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $item ){ ?>
            <tr>
              <td><?=$item['name'];?></td>
              <td>
                <a href="/admin_manager/setmenu/<?=$item['id'];?>" title="分配权限节点" class="setmenus">权限&nbsp;<img align="middle" src="/resource/images/mange.gif" width="19" height="21" /></a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;
                <a href="/admin_manager/groupedit/<?=$item['id'];?>" title="编辑">编辑&nbsp;<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" /></a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;
                <a href="/admin_manager/groupdel/<?=$item['id'];?>" title="删除" onclick="javascript:return confirm('您确定要删除此群组吗?');">删除&nbsp;<img align="middle" src="/resource/images/del.gif" width="16" height="17" /></a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

  </div>

</div>