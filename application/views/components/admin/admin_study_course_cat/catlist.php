<script type="text/javascript" src="/resource/js/admin/common.js"></script>

<div class="noticewarp">

  <div class="noticetit">
    <h1>大赛分类管理</h1>
  </div>
    
  <div class="noticenwarp">
     
     <div class="noticekatebox1">
	      <form action="/admin_study_course_cat/catlist"  method="get">
	
	        <div class="notiness">共有大赛分类<span><?= $count ?></span>条</div>
	
	        <div class="serchbox1">
	         <div class="serchninput1"><input type="text" value="<?= isset($get[ 'name' ]) ? $get[ 'name' ] : '请输入分类名' ?>" onclick="$('#searchname').val('')" id="searchname" name="name"></div>
	          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
	        </div>
	      </form>
	    </div>
     
    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量删除操作吗？', '请选择要删除的数据')" title="删除">删除</a></div>
        <div class="manageadd"><a href="/admin_study_course_cat/catedit" title="新增大赛分类">新增大赛分类</a></div>
      </div>
      <?= $pagination ?>
    </div>

    <div class="databox">
      <form id="sub_form" name="sub_form" method="post" action="/admin_study_course_cat/catdel">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th style="width:5%;">&nbsp;</th>
            <th style="width:30%;">名称</th>
            <th style="width:30%;">大赛数</th>
            <th style="width:20%;">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $v ) { ?>
            <tr>
              <td><input class="check" name="item_id[]" value="<?= $v['id']; ?>" type="checkbox"/></td>
              <td><?= $v['name']; ?></td>
              <td><?= $v['coursecount']; ?></td>
              <td>
                <a href="/admin_study_course_cat/catedit?id=<?= $v['id']; ?>" title="编辑">编辑<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" /></a>&nbsp;|&nbsp;
                <a href="/admin_study_course_cat/catdel?id=<?=$v['id'];?>" title="删除" onclick="javascript:return confirm('您确定要删除此大赛分类吗?');">删除<img align="middle" src="/resource/images/del.gif" width="16" height="17" /></a>
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