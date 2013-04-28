<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script>
  
  function deleteItems( )
  {
    if( $("#resousdata input[type=checkbox]:checked").length == 0 ){
      alert( "请至少选择一条记录" );
      return ;
    }
    if ( !confirm( "你确定要删除吗？" ) )
      return;

    var post_str = $("#resousdata input[type=checkbox]").serialize();
    $.post("/study_teach_manage/delete/", post_str , function(ret){
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
 
  function process( id )
  {
    if ( !confirm( "你确定要处理吗？" ) )
      return;
    location.href="/study_teach_manage/audit/"+id;
  }
  
  function check_add()
  {
      var sttr =  $('#class').val();

  }
</script>
<script src="/resource/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        $(".iframe").colorbox({iframe:true, innerWidth:502, innerHeight:245});
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
<!--管理信息-->
      <div class="noticesbox kecheng">
        <div class="noticewarp">
        	
          <div class="noticetit tearch-nav tearch-navts">
            <h1>审核信息</h1>
            <div></div>
           </div>
            
           <div class="noticenwarp">
				<div class="noticekatebox">
					  <div class="dataediabox">
               <div class="ediacheck"><input id="select_all" onClick="select_all();" type="checkbox" /></div>
                    <div class="ediacheckw">全选</div>
                        <div class="datadel"><a href="javascript:deleteItems();" title="删除">删除</a></div>
                        <input type="hidden" id="class" value="iframe cboxElement"/>
                        <div class="dataadd"><a href="/study_teach_manage/add_user" title="导入用户" class="iframe" onClick="return check_add()" id="add_title">导入用户</a></div>
                    </div>					
					<div style="float:right">
             <form action="" method="get" id="search_form"> 
						<div style="float:left; margin-right: 5px;">
							<select name="status" class="p5" onchange="submitSearch()">
							  <option value="">请选择申请状态</option>
                <option value="audit" <?=isset($get['status']) && $get['status']=='audit' ? 'selected' : ''?>>审核通过</option>
							  <option value="wait" <?=isset($get['status']) && $get['status']=='wait' ? 'selected' : ''?>>申请中</option>
							</select>
						</div>
						<div class="serchninput"><input type="text" name="name" value="" onclick="search_input(this)"  /></div>
						<div class="serchbut"><input type="submit" id="serchadd" value="搜索" /></div>
            </form>
					</div>
				  </div>
              <div class="databox databoxs" style="width:730px">
                	<table width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="53">&nbsp;</th>
                                <th width="231">姓名</th>
                                <th width="102">角色</th>
                                <th width="100">状态</th>
                                <th width="158">申请时间</th>
                                <th width="84">操作</th>
                            </tr>
                        </thead>
                        <tbody id="resousdata">
                            
                            <?php foreach($list as $key=>$val){?>
                            <tr>
                                <td><input type="checkbox" name="item_id[]" value="<?=$val['id']?>"/></td>
                                <td><?=$val['username']?></td>
                                <td><?=$val['part_name']?></td>
                                <td><?=$SELECT_COURSE_STATUS[$val['status']]?></td>
                                <td><?=$val['created']?></td>
                                <td><?php if($val['status']=='wait'){?><a href="javascript:process(<?=$val['id']?>)">审核通过</a>
								<?php }else{ ?>
								审核通过
								<?php }?>
							
								</td>
                            </tr>
                             <?php } ?>
                        </tbody>                
                </table>
              </div>
               <?=$pagination?>
            </div>
            
        </div>
      </div>
      <!--管理信息 end-->