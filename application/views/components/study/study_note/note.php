<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
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
        $.post("/study_note/delete/", post_str , function(ret){
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
            <h2>学习笔记 > 笔记管理&nbsp;</h2> 
            <div><a href="/study_note" class="blue">&lt;&lt;返回</a></div>
        </div>

        <div class="noticenwarp">
            <div class="noticekatebox">
                <div class="dataediabox">

                    <div class="ediacheck"><input type="checkbox" onchange="select_all();" id="select_all" /></div>
                    <div class="ediacheckw">全选</div>
                    <div class="datadel"><a title="删除" href="javascript:deleteItems();">删除</a></div>
                    <div class="dataadd"><a title="新建笔记" href="/study_note/add">新建笔记</a></div>
                </div>


                <div style="float:right">
                    <form action="/study_note/index" method="get" id="search_form">
                    <div style=" float:left; margin-right:3px;" class="notiness">
                        <select style="padding:5px" name="note_cat_id" onchange="submitSearch()">
                            <option value="">&nbsp;选择分类&nbsp;</option>
                            <?php foreach ( $cat_list as $key => $val )
                            { ?>
                                <option value="<?= $val[ 'id' ] ?>" <?=isset($get['note_cat_id']) && $get['note_cat_id']==$val['id'] ? 'selected' : ''?>>
                                <?= $val[ 'name' ] ?></option>
<?php } ?>
                        </select> 
                    </div>
                    
                    <div class="serchninput"><input type="text" name="title" value=""  onclick="search_input(this)"  /></div>
                    <div class="serchbut"><input type="submit" id="serchadd" value="搜索" /></div>
                    </form>
                </div>

            </div>

            <div class="databox">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr> <th>&nbsp;</th>
                            <th>标题</th>

                            <th  width="130">最后编辑时间</th>
                            <th width="130">操作</th>
                        </tr>
                    </thead>
                    <tbody id="resousdata">
<?php foreach ( $list as $key => $val )
{ ?>
                            <tr>   
                                <td><input type="checkbox" name="item_id[]" value="<?= $val[ 'id' ] ?>"/></td>
                                <td><a href=""><?= $val[ 'title' ] ?></a></td>                                   
                                <td><?= $val[ 'update_time' ] ?></td>
                                <td><a href="/study_note/edit/<?= $val[ 'id' ] ?>">编辑</a></td>
                            </tr>
<?php } ?>
                    </tbody>                
                </table>
            </div>

            <div class="noticekatebox">
                <div class="dataediabox">

                    <div class="ediacheck"></div>

                </div>
                <div class="datapkate">
                    <div class="datajump">

                    </div>
<?= $pagination ?>
                </div>

            </div>

        </div>

    </div>
</div>

<!--管理信息 end-->