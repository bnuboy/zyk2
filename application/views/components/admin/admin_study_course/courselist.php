<div class="noticewarp">

  <div class="noticetit">
    <h1>大赛列表</h1>
  </div>
    
  <div class="noticenwarp">
     
     <div class="noticekatebox1" style="width:auto">
	      <form action="/admin_study_course/courselist"  method="get">
	        <div class="notiness">共有大赛<span><?= $count ?></span>条</div>
          <div class="notiness" style="margin-right:-3px;<?=$this->type=='organization'?"display:none;":""?>">
          <select name="organization_id" style="padding:6px;" onchange="jascript:this.form.submit();">
            <option value="">==选择院系==</option>
            <?php foreach($organizations as $k => $v){ ?>
            <option value="<?=$v['id'];?>" <?=(isset($get['organization_id']) && $get['organization_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?></option>
            <?php } ?>
          </select>
        </div>
        <div class="notiness" style="margin-right:-3px;">
          <select name="classify_cat_id" style="padding:6px;" onchange="jascript:this.form.submit();">
            <option value="">==选择分类==</option>
            <?php foreach($cats as $k => $v){ ?>
            <option value="<?=$v['id'];?>" <?=(isset($get['classify_cat_id']) && $get['classify_cat_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?></option>
            <?php } ?>
          </select>
        </div>
        
        <div class="notiness" style="margin-right:-3px;">
          <select onchange="jascript:this.form.submit();" name="status" style="padding:5px" >
            <option value="">==审核状态==</option>
            <option value="wait" <?=(!empty($get['status']) && $get['status'] == 'wait') ? 'selected' : '';?>>待审核</option>
            <option value="audit" <?=(!empty($get['status']) && $get['status'] == 'audit') ? 'selected' : '';?>>已审核</option>            
          </select>
        </div>
	        <div class="serchbox1" style="width:164px;">
	         <div class="serchninput1"><input type="text" value="<?= isset($get[ 'name' ]) ? $get[ 'name' ] : '' ?>" onclick="$('#searchname').val('')" id="searchname" name="name"></div>
	          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
	        </div>
	      </form>
	    </div>

     
    <div class="noticekatebox" style="width:auto">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量删除操作吗？', '请选择要删除的数据')" title="删除">删除</a></div>
        <div class="manageadd"><a href="/admin_study_course/courseedit" title="新增大赛">新增大赛</a></div>
      </div>
      <?= $pagination ?>
    </div>


    <div class="databox" style="width: 770px;">
     <form id="sub_form" name="sub_form" method="post" action="/admin_study_course/coursedel">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="5%">&nbsp;</th>
            <th width="15%">名称</th>
            <th width="10%">主办单位</th>
            <th width="10%">所属分类</th>
            <th width="20%">指导教师</th>
            <th width="10%">大赛人数</th>
            <th width="10%">状态</th>
            <th width="25%">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $k => $v ) { ?>
            <tr>
              <td><input class="check" name="item_id[]" value="<?= $v['id']; ?>" type="checkbox"/></td>
			           <td><?=$v['name'];?></td>
              <td><?=$v['organization']['name'];?></td>
              <td><?=$v['cat']['name'];?></td>
              <td>
                <?php 
                if(!empty($v['teachers'])){
                    foreach($v['teachers'] as $teacher){
                        echo $teacher['name']."、";
                    }
                }
                ?>
              </td>
              <td><?=$v['student_count'];?></td>
              <td>
                <?php
                if($v['status'] == 'wait') {
                    echo  "<a href='/admin_study_course/changestatus?id=".$v['id']."&status=audit' title='点击改变状态'><img src='/resource/images/lock.gif' border='0'>待审核</a>";
                } else if($v['status'] == 'audit') { 
                    echo "<a href='/admin_study_course/changestatus?id=".$v['id']."&status=wait' title='点击改变状态'><img src='/resource/images/exclamation.png' border='0'>已审核</a>";
                }
                ?>
              </td>
              <td>
                <a href="/admin_study_course/courseedit?id=<?= $v['id']; ?>" title="编辑">编辑<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" /></a>&nbsp;|&nbsp;
                <a href="/admin_study_course/coursedel?id=<?=$v['id'];?>" title="删除" onclick="javascript:return confirm('您确定要删除此大赛吗?');">删除<img align="middle" src="/resource/images/del.gif" width="16" height="17" /></a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <form>
    </div>

    <div class="noticekatebox" style="width:auto">
    <?= $pagination ?>
    </div>

  </div>

</div>

