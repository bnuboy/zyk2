<div class="noticewarp">

  <div class="noticetit">
    <h1>课程列表</h1>
  </div>
    
  <div class="noticenwarp">
     
     <div class="noticekatebox1">
	      <form action="/admin_study_course/courselist"  method="get">
	        <div class="notiness">共有课程<span><?= $count ?></span>条</div>
	        <div class="serchbox1">
	         <div class="serchninput1"><input type="text" value="<?= isset($get[ 'name' ]) ? $get[ 'name' ] : '请输入课程名' ?>" onclick="$('#searchname').val('')" id="searchname" name="name"></div>
	          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
	        </div>
	      </form>
	    </div>

     
    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量审核操作吗？', '请选择要通过审核的课程')" title="审核">通过审核</a></div>
      </div>
      <?= $pagination ?>
    </div>


    <div class="databox" style="width: 750px;">
     <form id="sub_form" name="sub_form" method="post" action="/admin_study_course/courseaudit">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="10%">&nbsp;</th>
            <th width="20%">名称</th>
            <th width="10%">所属学院</th>
            <th width="10%">所属分类</th>
            <th width="20%">课程教师</th>
            <th width="10%">课程人数</th>
            <th width="20%">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $k => $v ) { ?>
            <tr>
              <td><input name="item_id[]" value="<?= $v['id']; ?>" class="check" type="checkbox"/></td>
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
                <a href="/admin_study_course/courseaudit?id=<?=$v['id'];?>" title="通过审核" onclick="javascript:return confirm('您确定要审核通过此课程吗?');">点击审核</a>
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

