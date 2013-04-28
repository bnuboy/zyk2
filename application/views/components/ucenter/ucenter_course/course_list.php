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
    function tuike(param,param1)
    {
        $.post('/ucenter_course/tuike/'+param+'/'+param1,function(ret)
        {
            if(ret.status=='ok')
                {
                    alert('退赛成功');
                    location.reload();
                }else{
                    alert('退赛不成功');
                }
            },'json');
    }
</script>
<div class="noticewarp">

  <div class="noticetit">
    <h1 style="float: left;">大赛列表</h1>
     <?php if(!isset($list) || empty ($list)){?><span style="float:right; line-height: 35px;font-weight: bold;"> 
         <a href="/ucenter_select_course/index" style="color: #1E8DD2;">>>+去选赛 </a></span><?php }?>
  </div>
    
  <div class="noticenwarp" style="min-height: 250px;">
     
     <div class="noticekatebox1">
	      <form action="/ucenter_course/mycourseselect"  method="get">
	        <div class="notiness">共有赛程<span><?= $count ?></span>条</div>
	        <div class="serchbox1" style="width:320px;">
          <div style="margin-right:10px;float: left;" >
          <select style="padding:5px" name="classify_cat_id" onchange="this.form.submit()">
            <option value="">&nbsp;请选择分类&nbsp;</option>
            <?php foreach($classify as $key=>$val){?>
            <option value="<?=$val['id']?>" <?= isset($get[ 'classify_cat_id' ] ) && $get[ 'classify_cat_id' ] == $val['id'] ? 'selected' : '' ?>><?=$val['name']?></option>
            <?php }?>
          </select>
        </div>
	         <div class="serchninput1"><input type="text" value="<?= isset($get[ 'name' ]) ? $get[ 'name' ] : '' ?>" onclick="$('#searchname').val('')" id="searchname" name="name" /></div>
	          <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
	        </div>
	      </form>
	    </div>
 
    <div class="databox" style="width: 750px;">
     <form id="sub_form" name="sub_form" method="post" >
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
           
            <th width="20%">名称</th>
            <th width="10%">班级</th>
            <th width="10%">赛程角色</th>
            <th width="20%">申请时间</th>
            <th width="10%">选赛状态</th>
            <th width="20%">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
          <?php foreach ( $list as $k => $v ) { 
              $url ="#this";
             if($v['status'] == 'audit'){
                 $url = "/study/index?course_id=".$v['course_id'];
             }
              ?>
            <tr>
			           <td><?php if($v['status']=='audit'){?><a href="/study/index?course_id=<?=$v['course_id']?>"><?=$v['name'];?></a>
                 <?php }else{?><?=$v['name'];}?></td>
                 <td><?=isset($v['banji']) && !empty ($v['banji']) ? $v['banji']['name'] : '';?></td>
              <td><?=$v['part_name'];?></td>
              <td><?=$v['created']?></td>
              <td><?php 
             if($v['status'] == 'wait'){
                 echo "待审核";
             }else if($v['status'] == 'audit'){
                 echo "<span class='greenm'>审核通过</span>";
             }
             ?> </td> 
              <td> <?php if($v['status']=='wait'){?><span>退赛</span>&nbsp;&nbsp;&nbsp;<?php }else{?>
                <span><a href="javascript:tuike(<?=$v['course_id']?>,<?=$v['user_id']?>);" >退赛</a></span>&nbsp;&nbsp;&nbsp;<?php }?><span><a href="<?=$url;?>">进入赛程</a></span></td>
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

