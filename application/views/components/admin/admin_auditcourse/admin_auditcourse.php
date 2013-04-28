<script>
    function checkeing()
    {
        if ( !confirm( "你确定要审核吗？" ) )
            return;
        var post_attr = $('#resousdata input[type=checkbox]:checked');
        
        $.post('/admin_auditcourse/plsh/',post_attr,function(ret)
        {
            if(ret.status =='ok')
                {
                    alert('审核成功!');
                    location.reload();
                }else{
                    alert('审核失败,请选择要审核的大赛');
                }
        },'json');
    }
</script>
<div class="noticewarp">

  <div class="noticetit">
    <h1>大赛列表</h1>
  </div>
    
  <div class="noticenwarp">
     
     <div class="noticekatebox1">
      
	      <form action="/admin_study_course/courselist"  method="get">
	        <div class="notiness">共有未审核大赛<span><?= $count ?></span>条</div>
	        <div class="serchbox1">
	         <div class="serchninput1"><input type="text" value="<?= isset($get[ 'name' ]) ? $get[ 'name' ] : '' ?>" onclick="$('#searchname').val('')" id="searchname" name="name"></div>
	          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
	        </div>
	      </form>
         
           <div class="noticekatebox" style="padding-left: 0px;">
              <div class="dataediabox">
                <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
                <div class="ediacheckw">全选</div>
                <div class="datadel"><a href="#this" onclick="return checkeing()" title="审核">通过审核</a></div>
              </div>    
        </div>
	    </div>

     
  

    <div class="databox" style="width: 750px;">
     <form id="sub_form" name="sub_form" method="post" action="/admin_study_course/courseaudit">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="5%">&nbsp;</th>
            <th width="20%">名称</th>
            <th width="20%">所属学院</th>
            <th width="20%">所属分类</th>
            <th width="10%">申请人</th>
            <th width="10%">大赛人数</th>
            <th width="20%">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $k => $v ) { ?>
            <tr>
              <td><input name="item_id[]" value="<?= $v['id']; ?>_<?=$v['uid']?>" class="check" type="checkbox"/></td>
			        <td><?=$v['name'];?></td>
              <td><?=$v['organization']['name']?></td>
              <td><?=$v['cat']['name']?></td>
              <td><?=$v['username']?></td>
              <td><?=$v['student_count'];?></td>
              <td>
                <a href="/admin_auditcourse/courseaudit?id=<?=$v['id'];?>&uid=<?=$v['uid']?>" title="通过审核" onclick="javascript:return confirm('您确定要审核通过此大赛吗?');">点击审核</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <form>
    </div>

    <div class="noticekatebox">
    <?= $pagination ?>
    </div>

  </div>

</div>


