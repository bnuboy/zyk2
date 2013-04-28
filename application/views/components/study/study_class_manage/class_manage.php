<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
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
<script type="text/javascript">
    function deleteItems( )
    {
        if( $("#resousdata input[type=checkbox]:checked").length == 0 ){
            alert( "请至少选择一条记录" );
            return;
        }
        if ( !confirm( "你确定要删除吗？" ) )
            return;

        var post_str = $("#resousdata input[type=checkbox]").serialize();
        $.post("/study_class_manage/delete/", post_str , function(ret){
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
    
    function rewritename()
    {
        if( $("#resousdata input[type=checkbox]:checked").length == 0 || $("#resousdata input[type=checkbox]:checked").length >1){
            alert( "请选择一条记录来重命名" );
            return;
        }
        
        if ( !confirm( "你确定要重命名吗？" ) )
            return;

        var post_str = $("#resousdata input[type=checkbox]:checked").val();
       location.href='/study_class_manage/rewritename/'+post_str;
    }
  
</script>
<!--管理信息-->
      <div class="noticesbox kecheng">
        <div class="noticewarp">
        	
          <div class="noticetit tearch-nav tearch-navts">
            <h1>班级管理</h1>
            <div></div>
           </div>
            
           <div class="noticenwarp">
				<div class="noticekatebox">
					  <div class="dataediabox">
                <div class="ediacheck"><input id="select_all" onClick="select_all();" type="checkbox" /></div>
                    <div class="ediacheckw">全选</div>
                        <div class="datadel"><a href="javascript:deleteItems();" title="删除">删除</a></div>
                        <div class="dataadd"><a href="javascript:rewritename();" title="重命名" >重命名</a></div>
                        <div class="dataadd"><a href="/study_class_manage/add_class" title="创建班级" >创建班级</a></div>
                    </div>		
				  </div>
              <div class="databox databoxs" style="width:730px">
                	<table width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="69">&nbsp;</th>
                                <th width="314">名称</th>
                                <th width="130">助教</th>
                                <th width="124">已有人数</th>
                                <th width="91">操作</th>
                            </tr>
                        </thead>
                        <tbody id="resousdata">
                            <?php foreach($list as $key=>$val){?>
                            <tr>
                                <td><input type="checkbox" name="item_id[]" value="<?=$val['id']?>"/></td>
                                <td><a href="/study_class_manage/get_user_list/<?=$val['id']?>"><?=$val['name']?></a></td>
                                <td><?=$val['usernames']?></td>
                                <td><?=$val['num']?></td>
                                <td><a href="/study_class_manage/add_user/<?=$val['id']?>" class="iframe">导入用户</a></td>
                            </tr>
                             <?php } ?>                   
                        </tbody>                
                </table>
              </div>
            </div>
            
        </div>
      </div>
      <!--管理信息 end-->