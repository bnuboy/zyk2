<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script src="/resource/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        $(".iframe").colorbox({iframe:true, innerWidth:486, innerHeight:209,slideshowSpeed:2550});
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
       
        $.post("/study_pattern/delete", post_str , function(ret){
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
        
       //alert('sss');
//  if($('#select_all').attr('checked') === 'checked') {
//    $('.click').attr('checked', 'checked');
//  } else {
//    $('#resousdata input[type=checkbox]').removeAttr('checked');
//  }

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
<div class="noticesbox">
    <div class="noticewarp">
        <div class="noticetit">
            <h1>题型管理</h1>
        </div>
        <div class="noticenwarp">
            <div class="noticekatebox">
                <div class="dataediabox">
                    <div class="ediacheck"><input id="select_all" onchange="select_all();" type="checkbox" oninput="select_all();" onpropertychange="select_all()"/></div>
                    <div class="ediacheckw">全选</div>
                    <div class="datadel"><a href="javascript:deleteItems();" title="删除">删除</a></div>
                    <div class="dataadd"><a href="/study_pattern/add" title="新建题型" class="iframe">新建题型</a></div>
                </div>
                <form action="/study_pattern/index" method="get">
                    <div class="serchbox">
                        <div class="serchninput"><input type="text" name="name" value="名称" onclick="search_input(this)"  /></div>
                        <div class="serchbut"><input type="submit" id="serchadd" value="搜索" /></div>
                    </div>
                </form>
            </div>
            <div class="databox">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="30">&nbsp;</th>
                            <th width="343">名称</th>
                            <th width="99">基本类型</th>
                            <th width="79">题目数量</th>
                            <th width="76">题目列表</th>
                            <th width="79">操作</th>
                        </tr>
                    </thead>
                    <tbody id="resousdata">
                        <?php foreach ( $list as $key => $val )
                        { ?>
                            <tr>
                                <td><input type="checkbox"  name="item_id[]" value="<?=$val['id']?>" class="click"/></td>
                                <td><?=$val['name']?></td>
                                <td><?=$val['pattern_type']?></td>
                                <td><?=$val['shiti_count']?></td>
                                <td><span class="dataedia"><a href="/study_pattern/get_look/<?=$PATTERN[$val['pattern_type']]?>/<?=$val['id']?>" title="查看" class="iframe">查看</a></span></td>
                                <td><span class="dataedia"><a href="/study_pattern/edit/<?=$val['id']?>?num=<?=$val['shiti_count']?>" title="重命名" class="iframe">重命名</a></span></td>
                            </tr>
                    <?php } ?>
                    </tbody>                
                </table>
            </div>
            <div class="noticekatebox">
                <div class="datapkate">
                    <div class="datajump">
                        
                    </div>
                    <?=$pagination?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--管理信息 end-->
<!--中间内容 end-->