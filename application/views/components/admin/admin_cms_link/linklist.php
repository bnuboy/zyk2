<script type="text/javascript" src="/cms/js/admin/common.js"></script>

<div class="noticewarp">

  <div class="noticetit">
    <h1>友情链接管理</h1>
  </div>
    
  <div class="noticenwarp">
     
     <div class="noticekatebox1">
	      <form action="/admin_cms_link/linklist"  method="get">
	
	        <div class="notiness">共有友情链接<span><?= $count ?></span>条</div>
        <div class="notiness" style="margin-right:-3px;<?=$this->type=='organization'?"display:none;":""?>">
          <select name="school_org_id" style="padding:6px;" onchange="jascript:this.form.submit();">
            <option value="">==选择院系==</option>
            <?php foreach($organizations as $k => $v){ ?>
            <option value="<?=$v['id'];?>" <?=(isset($get['school_org_id']) && $get['school_org_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?></option>
            <?php } ?>
          </select>
        </div>
	        <div class="serchbox1">
	         <div class="serchninput1"><input type="text" value="<?= isset($get[ 'name' ]) ? $get[ 'name' ] : '' ?>" onclick="$('#searchname').val('')" id="searchname" name="name"></div>
	          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
	        </div>
	      </form>
	</div>
     
    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量删除操作吗？', '请选择要删除的数据')" title="删除">删除</a></div>
        <div class="manageadd"><a href="/admin_cms_link/linkedit" title="新增友情链接">新增友情链接</a></div>
      </div>

      <?= $pagination ?>

    </div>

    <div class="databox">
      <form id="sub_form" name="sub_form" method="post" action="/admin_cms_link/linkdel">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th style="width:5%;">&nbsp;</th>
            <th style="width:15%;">名称</th>
            <th style="width:35%;">链接</th>
            <th style="width:15%;">所属院系</th>
            <th style="width:10%;">排序</th>
            <th style="width:20%;">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $v ) { ?>
            <tr>
              <td><input class="check" name="item_id[]" value="<?= $v['id']; ?>" type="checkbox"/></td>
              <td><?= $v['name']; ?></td>
              <td><?= $v['url']; ?></td>
              <td><?= $v['org']['name']; ?></td>
              <td><?= $v['order']; ?></td>
              <td>
                <a href="/admin_cms_link/linkedit?id=<?= $v['id']; ?>" title="编辑">编辑<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" /></a>&nbsp;|&nbsp;
                <a href="/admin_cms_link/linkdel?id=<?=$v['id'];?>" title="删除" onclick="javascript:return confirm('您确定要删除此友情链接库吗?');">删除<img align="middle" src="/resource/images/del.gif" width="16" height="17" /></a>
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