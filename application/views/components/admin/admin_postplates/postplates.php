<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script>
  function deleteItem( id )
  {
    if ( !confirm( "你确定要删除吗？" ) )
      return;
    location.href="/admin_postplates/delete/"+id;
  }
  function deleteItems( )
  {
    if( $("#resousdata input[type=checkbox]:checked").length == 0 ){
      alert( "请至少选择一条记录" );
      return ;
    }
    if ( !confirm( "你确定要删除吗？" ) )
      return;

    var post_str = $("#resousdata input[type=checkbox]").serialize();
    $.post("/admin_postplates/deletes/", post_str , function(ret){
      if ( ret.status == "ok" ) {
        alert("删除成功");
        location.reload();
      } else {
        alert(ret.data);
      }
    },"json");
  }
  function select_all()
  {
    if( $("#select_all:checked").length == 0 ){
      $("#resousdata input[type=checkbox]").attr("checked",false);
    }else{
      $("#resousdata input[type=checkbox]").attr("checked","checked");
    }
  }
  
  function enabled( id,enable_value ){
    var msg = "你确定要禁用吗？";
    if( enable_value=='y' )
      var msg = "你确定要启用吗？";
    if ( !confirm( msg ) )
      return ;
    $.post("/admin_postplates/enable/"+id, "enabled="+enable_value , function(ret){
      if ( ret.status == "ok" ) {
        location.reload();
      } else {
        alert(ret.data);
      }
    },"json");
  }
</script>
<div class="noticewarp">

  <div class="noticetit">
    <h1>论坛板块管理</h1>
  </div>
    
  <div class="noticenwarp">
     
     <div class="noticekatebox1">
	      <form action="/admin_postplates"  method="get" id="search_form">
			  <div class="notiness">
				  <select onchange="submitSearch()" name="id" style="padding:5px">
					  <option value=''>---所有板块---</option>					 
              <?php foreach($data as $val){ ?>   
            <option value='<?=$val->id?>' <?=isset($get['id']) && $get['id'] == $val->id ? 'selected':''?>><?=$val->title?></option>	
              <?php } ?>
				  </select>
			  </div>
	        <div class="notiness"></div>
	
	        <div class="serchbox1">
	         <div class="serchninput1"><input type="text" value="<?= isset($get[ 'name' ]) ? $get[ 'name' ] : '' ?>" onclick="search_input(this)" name="name"></div>
	          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
	        </div>
	      </form>
	</div>
     
    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="ediacheck"><input id="select_all" onchange="select_all();" type="checkbox"/></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="javascript:deleteItems()" title="删除">删除</a></div>
        <div class="manageadd"><a href="/admin_postplates/add" title="新增资源库">新增板块</a></div>
      </div>

      <?= $pagination ?>

    </div>

    <div class="databox">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="5%" style="text-align:center">&nbsp;</th>
            <th width="20%"  style="text-align:center">标题</th>
            <th width="20%"  style="text-align:center">图标</th>
            <th width="20%"  style="text-align:center">介绍</th>
            <th width="10%"  style="text-align:center">是否可用</th>
            <th width="10%"  style="text-align:center">帖子数量</th>
            <th width="25%"  style="text-align:center">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $item )
          {
 ?>
            <tr>
              <td><input name="item_id[]" value="<?= $item->id ?>" type="checkbox"/></td>
              <td style="text-align:center"><?= $item->title ?></td>
              <td style="text-align:center"><img src="<?= $item->icon ?>" width="100px" height="70px"></td>
              <td ><?= $item->info ?></td>
              <td style="text-align:center">
			  <?php if ( $item->enabled == 'y' )
              {
 ?>
                <a href="javascript:enabled(<?= $item->id ?>,'n')"><span class="mangbegin">启用</span></a>
              <?php
              }
              else
              {
              ?>
                <a href="javascript:enabled(<?= $item->id ?>,'y')">
                  <span class="mangclose">禁用</span>
                  <img height="21" width="16" align="middle" src="/resource/images/lock.gif">
                </a>
<?php } ?>
			  </td>
			  <td style="text-align:center"><?= $item->post_count ?></td>
              <td style="text-align:center"><a href="/admin_postplates/edit/<?= $item->id ?>" title="编辑">编辑<!--<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" />--></a>&nbsp;|&nbsp;<a href="javascript:deleteItem(<?= $item->id ?>);" title="删除">删除<!--<img align="middle" src="/resource/images/del.gif" width="16" height="17" />--></a></td>
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
