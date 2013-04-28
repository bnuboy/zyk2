<script type="text/javascript" src="/cms/js/admin/common.js"></script>

<div class="noticewarp">

  <div class="noticetit">
    <h1>文章管理</h1>
  </div>
    
  <div class="noticenwarp">
     
     <div class="noticekatebox1">
	      <form action="/admin_cms_article/articlelist"  method="get">
	
	        <div class="notiness">共有文章<span><?= $count ?></span>条</div>
        <div class="notiness" style="margin-right:-3px;<?=$this->type=='organization'?"display:none;":""?>">
          <select name="school_org_id" style="padding:6px;" onchange="jascript:this.form.submit();">
            <option value="">==选择院系==</option>
            <?php foreach($organizations as $k => $v){ ?>
            <option value="<?=$v['id'];?>" <?=(isset($get['school_org_id']) && $get['school_org_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?></option>
            <?php } ?>
          </select>
        </div>
	        <div class="serchbox1">
	         <div class="serchninput1"><input type="text" value="<?= isset($get[ 'subject' ]) ? $get[ 'subject' ] : '' ?>" onclick="$('#searchsubject').val('')" id="searchsubject" name="subject"></div>
	          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
	        </div>
	      </form>
	</div>
     
    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量删除操作吗？', '请选择要删除的数据')" title="删除">删除</a></div>
        <div class="manageadd"><a href="/admin_cms_article/articleedit" title="新增文章">新增文章</a></div>
      </div>

      <?= $pagination ?>

    </div>

    <div class="databox">
      <form id="sub_form" name="sub_form" method="post" action="/admin_cms_article/articledel">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th style="width:5%;">&nbsp;</th>
            <th style="width:45%;">标题</th>
            <th style="width:15%;">所属院系</th>
            <th style="width:15%;">所属菜单</th>
            <th style="width:20%;">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $v ) { ?>
            <tr>
              <td><input class="check" name="item_id[]" value="<?= $v['id']; ?>" type="checkbox"/></td>
              <td>
			    <?= $v['subject']; ?>
			    <?php
				if($v['istop'] == 1){
				    echo "<a href='/admin_cms_article/articletop/".$v['id']."/".$v['menu_id']."/FALSE' style='color:red'>[取消首页]</a>";
				}else{
				    echo "<a href='/admin_cms_article/articletop/".$v['id']."/".$v['menu_id']."/TRUE'>[调到首页]</a>";
				}
				?>
			  </td>
              <td><?= $v['org']['name']; ?></td>
              <td><?= $v['menu']['name']; ?></td>
              <td>
                <a href="/admin_cms_article/articleedit?id=<?= $v['id']; ?>" title="编辑">编辑<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" /></a>&nbsp;|&nbsp;
                <a href="/admin_cms_article/articledel?id=<?=$v['id'];?>" title="删除" onclick="javascript:return confirm('您确定要删除此文章库吗?');">删除<img align="middle" src="/resource/images/del.gif" width="16" height="17" /></a>
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