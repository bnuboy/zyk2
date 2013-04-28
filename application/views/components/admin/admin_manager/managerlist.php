<script type="text/javascript" src="/resource/js/admin/common.js"></script>

<div class="noticewarp">
  <div class="noticetit"><h1>管理员管理</h1></div>

  <div class="noticenwarp">

    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量删除操作吗？', '请选择要删除的数据')" title="删除">删除</a></div>
        <div class="manageadd"><a href="/admin_manager/manageradd" title="新增管理员">新增管理员</a></div>
      </div>
      <?= $pagination ?>
    </div>

    <div class="databox">
      <form id="sub_form" name="sub_form" method="post" action="/admin_manager/managerdel">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th style="width:5%;">&nbsp;</th>
            <th style="width:20%;">用户名</th>
            <th style="width:20%;">群组名</th>
            <th style="width:20%;">状态</th>
            <th style="width:30%;">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach($list as $item){ ?>
            <tr class="layeven">
              <td><input class="check" name="item_id[]" value="<?=$item['id'];?>" type="checkbox"/></td>
              <td><?=$item['user']['name'];?></td>
              <td><?=$item['group']['name'];?></td>
              <td>
                <?php 
                if($item['enabled'] == 'y') {
                    echo  "<a href='/admin_manager/managerchangestatus?id=".$item['id']."&status=n' title='点击改变状态'><img src='/resource/images/exclamation.png' border='0'>可用</a>";
                } else if($item['enabled'] == 'n') { 
                    echo "<a href='/admin_manager/managerchangestatus?id=".$item['id']."&status=y' title='点击改变状态'><img src='/resource/images/lock.gif' border='0'>禁用</a>";
                }
                ?>
              </td>
              <td>
                <a href="/admin_manager/manageredit/<?=$item['id'];?>" title="编辑">编辑&nbsp;<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" /></a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;
                <a href="/admin_manager/managerdel?id=<?=$item['id'];?>" title="删除" onclick="javascript:return confirm('您确定要删除此管理员吗?');">删除&nbsp;<img align="middle" src="/resource/images/del.gif" width="16" height="17" /></a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
     </form>
    </div>
    <div class="noticekatebox"><?= $pagination ?></div>
    
  </div>
  
</div>