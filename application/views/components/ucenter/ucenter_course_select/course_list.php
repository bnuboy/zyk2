<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<script src="/resource/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        $(".iframe").colorbox({iframe:true, innerWidth:502, innerHeight:210});
        $(".callbacks").colorbox({
            onOpen:function(){ alert('onOpen: colorbox is about to open'); },
            onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
            onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
            onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
            onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
        });
				
				
        $("#click").click(function(){ 
            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
            return false;
        });
    });
      
    $(document).ready(function(){
	
        $("#resousdata>tr:odd,#ediaresousdata>tr:odd").addClass('layodd');
        $("#resousdata>tr:even,#ediaresousdata>tr:even").addClass('layeven');
    });
</script>
<div class="noticewarp">

  <div class="noticetit">
    <h1>课程列表</h1>
  </div>
    
  <div class="noticenwarp" style="min-height: 250px;">
     
     <div class="noticekatebox1">
	      <form action="/ucenter_course_select/index"  method="get">
	        <div class="notiness">共有课程<span><?= $count ?></span>条</div>
	        <div class="serchbox1" style="width:320px;">
          <div style="margin-right:-3px;float: left;" >
          <select style="padding:5px" name="classify_cat_id" onchange="this.form.submit()">
            <option value="">&nbsp;请选择分类&nbsp;</option>
            <?php foreach($classify as $key=>$val){?>
            <option value="<?=$val['id']?>" <?= isset($get[ 'classify_cat_id' ] ) && $get[ 'classify_cat_id' ] == $val['id'] ? 'selected' : '' ?>><?=$val['name']?></option>
            <?php }?>
          </select>
        </div>
	         <div class="serchninput1"><input type="text" value="<?= isset($get[ 'name' ]) ? $get[ 'name' ] : '请输入课程名' ?>" onclick="$('#searchname').val('')" id="searchname" name="name" /></div>
	          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
	        </div>
	      </form>
	    </div>
 
    <div class="databox" style="width: 750px;">
     <form id="sub_form" name="sub_form" method="post" >
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="10%">&nbsp;</th>
            <th width="20%">名称</th>
            <th width="10%">所属院系</th>
            <th width="10%">所属分类</th>
            <th width="20%">课程教师</th>
            
            <th width="20%">操作</th>
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
              <td>
                  <a href="/ucenter_course_select/select_course/<?=$v['id']?>" class="iframe">选课</a>
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

