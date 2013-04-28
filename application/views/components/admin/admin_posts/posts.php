<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script>
  function deleteItem( id )
  {
    if ( !confirm( "你确定要删除吗？" ) )
      return;
    location.href="/admin_posts/delete/"+id;
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
    $.post("/admin_posts/deletes/", post_str , function(ret){
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
    
    var msg = "你确定要不在置顶了吗？";
    if( enable_value=='0' )
      var msg = "你确定要置顶吗？";
    if ( !confirm( msg ) )
      return ;
    $.post("/admin_posts/enable/"+id, "top="+enable_value , function(ret){
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
    <h1>论坛帖子管理</h1>
  </div>
    
  <div class="noticenwarp">
     
     <div class="noticekatebox1">
	      <form action="/admin_posts"  method="get" id="search_form" >
			  <div class="notiness">
				  <select onchange="submitSearch()" name="status" style="padding:5px">
					  <option value=''>---所有状态---</option>					 
              <?php foreach($POST_STATUS as $key =>$val){ ?>  
            
            <option <?=isset($get['status']) && $get['status'] == $key ? 'selected' : ''?> 
              value='<?=$key?>'><?=$val?></option>	
              <?php } ?>
				  </select>
			  </div>
	        <div class="notiness">共有帖子<span><?= $count ?></span>条</div>
	
	      </form>
	</div>
     
    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="ediacheck"><input id="select_all" onchange="select_all();" type="checkbox"/></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="javascript:deleteItems()" title="删除">删除</a></div>
        
      </div>

      <?= $pagination ?>

    </div>

    <div class="databox">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="20">&nbsp;</th>
            <th width="140">标题</th>
            <th width="148">状态</th>
            <th width="70">是否置顶</th>
            <th width="125">发帖时间</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $item )
          {
 ?>
            <tr>
              <td><input name="item_id[]" value="<?= $item->id ?>" type="checkbox"/></td>
              <td><a href="/forum/view/<?=$item->id?>" target="_blank"><?= $item->title ?></a></td>
              <td><?= $POST_STATUS[$item->status ] ?></td>
              <td>
			  <?php if ( $item->top == '0' )
              {
 ?>
                <a href="javascript:enabled(<?= $item->id ?>,'1')"><span class="mangclose" style="margin-right:0">不置顶</span> <img height="21" width="16" align="middle" src="/resource/images/lock.gif"></a>
              <?php
              }
              else
              {
              ?>
                <a href="javascript:enabled(<?= $item->id ?>,'0')">
                  <span class="mangbegin">置顶</span>
                 
                </a>
<?php } ?>
			  </td>
              <td><?= $item->created ?></td>
              <td><a href="/admin_posts/edit/<?= $item->id ?>" title="编辑">编辑<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" /></a>&nbsp;|&nbsp;<a href="javascript:deleteItem(<?= $item->id ?>);" title="删除">删除<img align="middle" src="/resource/images/del.gif" width="16" height="17" /></a></td>
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

