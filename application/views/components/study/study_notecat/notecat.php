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
        $(".iframe").colorbox({iframe:true, innerWidth:502, innerHeight:268});
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

        $.post("/study_notecat/delete/", post_str , function(ret){
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
<div class="noticesbox">
    <div class="noticewarp tea-cont">

        <div class="noticetit tearch-nav">
            <h2>学习笔记 > 笔记分类&nbsp;</h2>             
        </div>

        <div class="noticenwarp">
            <div class="noticekatebox">
                <div class="dataediabox">

                    <div class="ediacheck"><input id="select_all" onchange="select_all();" type="checkbox" /></div>
                    <div class="ediacheckw">全选</div>
                    <div class="datadel"><a title="删除" href="javascript:deleteItems();">删除</a></div>
                    <div class="dataadd"><a title="新建分类" href="/study_notecat/add" class="iframe">新建分类</a></div>
                </div>


                <div class="serchbox">
                    <form action="/study_notecat" method="get">
                        <div class="serchninput"><input type="text" name="name" value="搜索名称"  onclick="search_input(this)" /></div>
                        <div class="serchbut"><input type="submit" id="serchadd" value="搜索" /></div>
                    </form>
                </div>

            </div>

            <div class="databox">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr> <th width="40">&nbsp;</th>
                            <th >名称</th>
                            <th width="100">笔记数量</th>
                            <th width="80">操作</th>
                        </tr>
                    </thead>
                    <tbody id="resousdata">
                        <?php foreach($list as $key=>$val){?>
                        <tr>   
                            <td><input type="checkbox" name="item_id[]" value="<?=$val['id']?>"/></td>
                            <td><?=$val['name']?></td>
                            <td id="count_<?=$val['id']?>"><?=$val['count']?></td>
                            <td><span class="greenm">
                                    <a href="/study_notecat/edit/<?=$val['id']?>" class="iframe">修改</a>
                                </span>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>                
                </table>
            </div>

            <div class="noticekatebox">
                <div class="dataediabox">
                </div>
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