<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script>
    function plsh()
    {
            var piliang = $('#resousdata input[type=checkbox]:checked');
            $.post('/admin_resource_info/piliang',piliang,function(ret)
            {
                    if(ret.status=='ok')
                        {
                            alert('审核成功');
                            location.reload();
                        }
            },'json');
    }    
</script>
<div class="noticewarp">

  <div class="noticetit">
    <h1>参考资料管理</h1>
  </div>
    
  <div class="noticenwarp">
     
     <div class="noticekatebox1">
	      <form action="/admin_resource_info/infolist"  method="get">
	
	        <div class="notiness">共有参考资料<span><?= $count ?></span>条</div>
          <div class="notiness" style="margin-right:-3px;<?=$this->type=='organization'?"display:none;":""?>" >
          <select name="library_id" style="padding:6px;" onchange="jascript:this.form.submit();">
            <option value="">==选择参考资料库==</option>
            <?php foreach($librarys as $k => $v){ ?>
            <option value="<?=$v['id'];?>" <?=(isset($get['library_id']) && $get['library_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?></option>
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
        <div class="manageadd"><a href="javascript:plsh();" title="批量审核">批量审核</a></div>
        <div class="manageadd"><a href="/admin_resource_info/infoedit" title="新增参考资料">新增参考资料</a></div>
      </div>

      <?= $pagination ?>

    </div>

    <div class="databox">
      <form id="sub_form" name="sub_form" method="post" action="/admin_resource_info/infodel">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th style="width:5%;">&nbsp;</th>
            <th style="width:15%;">名称</th>
            <th style="width:15%;">所属分类</th>
            <th style="width:15%;">状态</th>
            <th style="width:15%;">上传人</th>
            <th style="width:15%;">创建时间</th>
            <th style="width:25%;">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $v ) { ?>
            <tr>
              <td><input class="check" name="item_id[]" value="<?= $v['id']; ?>" type="checkbox"/></td>
              <td><a href="/admin_resource_info/infodetail/<?= $v['id']; ?>" title="点击查看详细"><?= $v['name']; ?></a></td>
              <td><?=isset($v['resource'])?$v['resource']['name']:""?></td>
              <td>
                <?php
                if($v['status'] == 'wait') {
                    echo  "<a href='/admin_resource_info/changestatus?id=".$v['id']."&status=succeed' title='点击改变状态'><img src='/resource/images/lock.gif' border='0'>待审核</a>";
                } else if($v['status'] == 'succeed') { 
                    echo "<a href='/admin_resource_info/changestatus?id=".$v['id']."&status=wait' title='点击改变状态'><img src='/resource/images/exclamation.png' border='0'>已发布</a>";
                } else if($v['status'] == 'fail'){
                    echo "审核失败";
                }
                ?>
              </td>
              <td><?=isset($v['up_user'])?$v['up_user']['name']:""?></td>
              <td><?= date('Y-m-d', strtotime($v['created'])); ?></td>
              <td>
                <a href="/admin_resource_info/infoedit?id=<?= $v['id']; ?>" title="编辑">编辑<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" /></a>&nbsp;|&nbsp;
                <a href="/admin_resource_info/infodel?id=<?=$v['id'];?>" title="删除" onclick="javascript:return confirm('您确定要删除此参考资料吗?');">删除<img align="middle" src="/resource/images/del.gif" width="16" height="17" /></a>
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