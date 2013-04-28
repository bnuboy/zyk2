<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script src="/resource/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        $(".iframe").colorbox({iframe:true, innerWidth:502, innerHeight:440});
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
        $.post("/study_class_manage/delete_users/", post_str , function(ret){
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
</script>
<!--管理信息-->
      <div class="noticesbox kecheng">
        <div class="noticewarp">
        	
          <div class="noticetit tearch-nav tearch-navts">
            <h1>用户列表</h1>
            <div></div>
           </div>
            
           <div class="noticenwarp">
				<div class="noticekatebox">
					  <div class="dataediabox">
                <div class="ediacheck"><input id="select_all" onchange="select_all();" type="checkbox" /></div>
                    <div class="ediacheckw">全选</div>
                        <div class="datadel"><a href="javascript:deleteItems();" title="删除">删除</a></div>
                        <div class="dataadd"><a href="/study_class_manage/add_user/<?=$id?>" class="iframe">导入用户</a></div>
                    </div>		
				  </div>
              <div class="databox databoxs" style="width:730px">
                	<table width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="69">&nbsp;</th>
                                <th width="314">姓名</th>
                                <th width="106">用户名</th>
                                <th width="106">角色</th>
                                <th width="133">申请时间</th>
                            </tr>
                        </thead>
                        <tbody id="resousdata">
                            <?php foreach($list as $key=>$val){?>
                            <tr>
                                <td><input type="checkbox" name="item_id[]" value="<?=$val['id']?>" /></td>
                                <td><?=$val['login_name']?></td>
                                <td><?=$val['username']?></td>
                                <td><?=$val['part_name']?></td>
                                <td><?=$val['created']?></td>
                            </tr>
                              <?php } ?>                  
                        </tbody>                
                </table>
              </div>
            </div>
            
        </div>
      </div>
      <!--管理信息 end-->