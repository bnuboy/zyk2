
<div class="noticewarp">

  <div class="noticetit">
    <h1><?=!empty($get['type']) ? $USER_TYPE[$get['type']] : '用户';?>管理</h1>
  </div>

  <div class="noticenwarp">

    <div class="noticekatebox1">
      <form action="/admin_user/index" id="search_form" onsubmit="" method="get">
        <div class="notiness">共有用户<span><?= $count ?></span>个</div>
        <div class="notiness" style="margin-right:-3px;">
          <select onchange="jascript:this.form.submit();" name="type" style="padding:5px" >
            <option value="0">==选择身份==</option>
            <?php foreach ( $USER_TYPE as $key => $value ) { ?>
              <option value="<?= $key ?>" <?=(!empty($get['type']) && $get['type'] == $key) ? 'selected' : '';?>><?= $value ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="notiness" style="margin-right:-3px;">
          <select onchange="jascript:this.form.submit();" name="enabled" style="padding:5px" >
            <option value="">==是否可用==</option>
            <option value="y" <?=(!empty($get['enabled']) && $get['enabled'] == 'y') ? 'selected' : '';?>>可用</option>
            <option value="n" <?=(!empty($get['enabled']) && $get['enabled'] == 'n') ? 'selected' : '';?>>禁用</option>            
          </select>
        </div>
        <div class="serchbox1">
          <div class="serchninput1"><input type="text" value="<?= isset($get[ 'keyword' ]) ? $get[ 'keyword' ]  : '' ?>" onclick="this.value=''" name="keyword"></div>
          <div class="serchbut"><input type="submit" value="搜索"  id="serchadd"></div>
        </div>
      </form>
    </div>
    
    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量删除操作吗？', '请选择要删除的数据')" title="删除">删除</a></div>
        <div class="manageadd"><a href="/admin_user/edit/<?=!empty($get['type']) ? $get['type'] : '';?>" title="新增<?=!empty($get['type']) ? $USER_TYPE[$get['type']] : '用户';?>">新增<?=!empty($get['type']) ? $USER_TYPE[$get['type']] : '用户';?></a></div>
        <div class="manageadd"><a href="/admin_user/import" title="导入">导入用户</a></div>
      </div>
      <?= $pagenav ?>
    </div>

    <div class="databox">
      <form id="sub_form" name="sub_form" method="post" action="/admin_user/del/<?=!empty($get['type']) ? $get['type'] : '';?>">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="20">&nbsp;</th>
            <th width="276"><?=!empty($get['type']) ? $USER_TYPE[$get['type']] : '用户';?>名</th>
            <th width="108">身份</th>
            <th width="108">状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $item ){ ?>
            <tr class="layeven">
              <td><input class="check" name="item_id[]" value="<?=$item['id'];?>" type="checkbox"/></td>
              <td><?=$item['name'];?></td>
              <td><?=isset($USER_TYPE[$item['type']]) ? $USER_TYPE[$item['type']] : '';?></td>
              <td>
                <?php 
                if($item['enabled'] == 'y') {
                    echo  "<a href='/admin_user/changestatus?id=".$item['id']."&status=n' title='点击改变状态'><img src='/resource/images/exclamation.png' border='0'>可用</a>";
                } else if($item['enabled'] == 'n') { 
                    echo "<a href='/admin_user/changestatus?id=".$item['id']."&status=y' title='点击改变状态'><img src='/resource/images/lock.gif' border='0'>禁用</a>";
                }
                ?>
              </td>
              <td><a href="/admin_user/edit?id=<?=$item['id'];?>" title="编辑">编辑&nbsp;<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;
                <a href="/admin_user/del?id=<?=$item['id'];?>" title="删除" onclick="javascript:return confirm('您确定要删除此用户吗?');">删除<img align="middle" src="/resource/images/del.gif" width="16" height="17" /></a>
               </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      </form>
    </div>

    <div class="noticekatebox">
      <?= $pagenav ?>
    </div>

  </div>

</div>