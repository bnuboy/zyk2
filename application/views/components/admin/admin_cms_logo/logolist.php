<div class="noticewarp">

  <div class="noticetit">
    <h1>LOGO列表</h1>
  </div>
    
  <div class="noticenwarp">
     
     <div class="noticekatebox1" style="width:auto">
	      <form action="/admin_cms_logo/logolist"  method="get">
	        <div class="notiness">共有LOGO<span><?= $count ?></span>条</div>
          <div class="notiness" style="margin-right:-3px;<?=$this->type=='organization'?"display:none;":""?>">
          <select name="org_id" style="padding:6px;" onchange="jascript:this.form.submit();">
            <option value="">==选择院系==</option>
            <?php foreach($organizations as $k => $v){ ?>
            <option value="<?=$v['id'];?>" <?=(isset($get['org_id']) && $get['org_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?></option>
            <?php } ?>
          </select>
        </div>

	        <div class="serchbox1" style="width:164px;">
	         <div class="serchninput1"><input type="text" value="<?= isset($get[ 'title' ]) ? $get[ 'title' ] : '' ?>" onclick="$('#searchname').val('')" id="searchname" name="title"></div>
	          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
	        </div>
	      </form>
	    </div>

     
    <div class="noticekatebox" style="width:auto">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量删除操作吗？', '请选择要删除的数据')" title="删除">删除</a></div>
        <div class="manageadd"><a href="/admin_cms_logo/logoedit" title="新增">新增LOGO</a></div>
      </div>
      <?= $pagination ?>
    </div>


    <div class="databox" style="width: 750px;">
     <form id="sub_form" name="sub_form" method="post" action="/admin_cms_logo/logodel">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="5%">&nbsp;</th>
            <th width="20%">名称</th>
            <th width="20%">所属院系</th>
            <th width="20%">图标</th>
            <th width="10%">状态</th>
            <th width="20%">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $k => $v ) { ?>
            <tr>
              <td><input class="check" name="item_id[]" value="<?= $v['id']; ?>" type="checkbox"/></td>
			           <td><?=$v['title'];?></td>
                 <td><?=$v['org']['name'];?></td>
                 <td><img src="<?=$v['img_url']?>" width="58px" height="54px"/></td>
                   <td>
                    <?php
                        if($v['enabled'] == 'y') {
                            echo  "<a href='/admin_cms_logo/changestatus?id=".$v['id']."&status=n' title='点击改变状态'><img src='/resource/images/exclamation.png' border='0'>可用</a>";
                        } else if($v['enabled'] == 'n') {
                            echo "<a href='/admin_cms_logo/changestatus?id=".$v['id']."&status=y' title='点击改变状态'><img src='/resource/images/lock.gif' border='0'>禁用</a>";
                        }
                    ?>
                </td>
              <td>
                <a href="/admin_cms_logo/logoedit?id=<?= $v['id']; ?>" title="编辑">编辑<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" /></a>&nbsp;|&nbsp;
                <a href="/admin_cms_logo/logodel?id=<?=$v['id'];?>" title="删除" onclick="javascript:return confirm('您确定要删除此课程吗?');">删除<img align="middle" src="/resource/images/del.gif" width="16" height="17" /></a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      </form>
    </div>

    <div class="noticekatebox" style="width:auto">
    <?= $pagination ?>
    </div>

  </div>

</div>

