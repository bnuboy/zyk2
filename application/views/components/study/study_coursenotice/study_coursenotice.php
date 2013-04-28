<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script type="text/javascript">
    function deleteItem( id )
    {
        if ( !confirm( "你确定要删除吗？" ) )
            return;
        location.href="/study_coursenotice/delete/"+id;
    }
    function deleteItems( )
    {
        if( $("#resousdata input[type=checkbox]:checked").length == 0 ){
            alert( "请至少选择一条记录" );
            return ;
        }
        if ( !confirm( "你确定要删除吗？" ) )
            return;
        var post_str = $("#resousdata input[type=checkbox]").serialize();
        $.post("/study_coursenotice/deletes/", post_str , function(ret){
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
<div class="noticewarp tea-cont">
    <div class="noticenwarp">
        <div class="noticekatebox">
            <div class="dataediabox">
                <div class="ediacheck"><input id="select_all" onchange="select_all();" type="checkbox"/></div>
                <div class="ediacheckw">全选</div>
                <div class="datadel"><a href="javascript:deleteItems()" title="删除">删除</a></div>
                <div class="dataadd"><a href="/study_coursenotice/add" title="新建公告">新建公告</a></div>
            </div>
            <form id="search_form" action="/study_coursenotice/index" onsubmit="return checkSearch(this);"  method="get">
                <div class="serchbox serchbox2">
                    <div class="serFl">
                        <select name="priority" onchange="submitSearch()" class="p5">
                            <option value="">选择优先级</option>
                            <?php
                            foreach ( $PUBLICNOTICE_LEVEL as $key => $value )
                            {
                            ?>
                                <option value="<?= $key ?>" <?= $get[ 'priority' ] == $key ? "selected=''" : "" ?>><?= $value ?></option>
                            <?php } ?>
                        </select></div>
                    <div class="serchninput"><input type="text"  value="<?= isset( $get[ 'title' ] ) ? $get[ 'title' ] . '" repeat_search = "1' : '请输入公告标题' ?>" onclick="search_input(this)" name="title"/></div>
                    <div class="serchbut"><input type="submit" id="serchadd" value="搜索" /></div>
                </div>
            </form>
        </div>

        <div class="databox databoxts">
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="20">&nbsp;</th>
                        <th width="250">公告名称</th>
                        <th width="125">优先级</th>
                        <th width="125">发布时间</th>
                        <th width="50">浏览量</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody id="resousdata">
                    <?php
                            foreach ( $list as $value )
                            {
                    ?>
                                <tr>
                                    <td><input type="checkbox" name="item_id[]" value="<?= $value[ 'id' ] ?>"/></td>
                                    <td><a href="/study_coursenotice/view/<?= $value[ 'id' ] ?>"><?= $value[ 'title' ] ?></a></td>
                                    <td><?= $PUBLICNOTICE_LEVEL[ $value[ 'priority' ] ] ?></td>
                                    <td><?= $value[ 'created' ] ?></td>
                                    <td><?= $value[ 'view' ] ?></td>
                                    <td><span class="dataedia">
                                            <a href="/study_coursenotice/edit/<?= $value[ 'id' ] ?>" title="修改">修改</a>
                                        </span>&nbsp;|&nbsp;
                                        <span class="datadell">
                                            <a href="/study_coursenotice/delete/<?= $value['id'] ?>" onclick="javascript:return confirm('你确定删除吗?')" title="删除">删除</a>
                                        </span>
                                    </td>
                                </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>


        <div class="noticekatebox">
   


        </div>
    </div>

</div>
</div>