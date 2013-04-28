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
        $(".iframe").colorbox({iframe:true, innerWidth:502, innerHeight:280});
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
    
    
    function select_all()
    {
        if( $("#select_all:checked").length == 0 ){
            $("#resousdata input[type=checkbox]").attr("checked",false);
        }else{
            $("#resousdata input[type=checkbox]").attr("checked","checked");
        }
    }
    function deleteItems( )
    {
        if( $("#resousdata input[type=checkbox]:checked").length == 0 ){
            alert( "请至少选择一条记录" );
            return;
        }
        if ( !confirm( "你确定要删除吗？" ) )
            return;
        var type_id = $('#type_id').val();
        var post_str = $("#resousdata input[type=checkbox]").serialize();
        $.post("/study_question_bank/delete/"+type_id, post_str , function(ret){
            if ( ret.status == "ok" ) {
                alert("删除成功");
                location.reload();
            } else {
                alert(ret.data);
            }
        },"json");
    }
</script>
<div class="noticesbox">
    <div class="noticewarp">

        <div class="noticetit">
            <h1>题库管理</h1>
        </div>

        <div class="noticenwarp">

            <div class="noticekatebox">

                <div class="dataediabox">
                    <div class="ediacheck"><input type="checkbox" id="select_all" onClick="select_all();"/></div>
                    <div class="ediacheckw">全选</div>
                    <div class="datadel"><a href="javascript:deleteItems();" title="删除">删除</a></div>                   
                    <div class="dataadd"><a href="/study_question_bank/check" title="新建题库">新建题目</a></div>                  
                </div>

                <form action="/study_question_bank/index" method="get" id="search_form">
                    <div class="notiness" >
                        <select class="p5" onchange="submitSearch()" name="id" id="type_id">                          
                            <?php foreach ($pattern_type as $key=>$val){?>
                            <option value="<?=$val['id']?>" <?=  isset ($get['id']) && $get['id']==$val['id'] ? 'selected' : ''?>>&nbsp;<?=$val['name']?>&nbsp;</option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="serchbox" style="display:none;">
                        <div class="serchninput"><input type="text" name="name" value="" /></div>
                        <div class="serchbut"><input type="submit" id="serchadd" value="搜索" /></div>
                    </div>
                </form>
            </div>

            <div class="databox">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="30">&nbsp;</th>
                            <th width="343">题目</th>
                            <th width="99">难度</th>                          
                            <th width="79">操作</th>
                        </tr>
                    </thead>
                    <tbody id="resousdata">
                        <?php foreach($list as $key=>$val){?>
                        <tr>
                            <td><input type="checkbox" name="item_id[]" value="<?=$val['id']?>"/></td>
                            <td><?=$val['title']?></td>
                            <td><?=$HARDER[$val['harder']]?></td>                          
                            <td><span class="dataedia"><a href="/study_question_bank/edit/<?=$patterntype_id?>/<?=$val['id']?>" title="修改">修改</a></span></td>
                        </tr>
                        <?php } ?>                       
                    </tbody>                
                </table>
            </div>

            <div class="noticekatebox">
                <div class="datapkate">
                    <div class="datajump">                        
                    </div>            
                </div>

            </div>

        </div>

    </div>
</div>

<!--管理信息 end-->