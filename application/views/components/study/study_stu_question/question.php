<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
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
        $.post("/study_stu_question/delete/", post_str , function(ret){
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
    <div class="noticewarp">
        <div class="noticetit tearch-nav tearch-navts">
            <h1>未回答问题</h1>
            <div><a href="/study_stu_question/index">返回</a></div>
        </div>

        <div class="noticenwarp">
            <div class="noticekatebox" style="width:730px;">
                <div class="dataediabox">
                    <div class="ediacheck"><input id="select_all" onClick="select_all();" type="checkbox" /></div>
                    <div class="ediacheckw">全选</div>
                    <div class="datadel"><a href="javascript:deleteItems();" title="删除">删除</a></div>
                    <div class="dataadd"><a title="我要提问" href="/study_stu_question/my_tiwen">我要提问</a></div>
                </div>
                <div class="serchbox">
                    <form action ="/study_stu_question/index" method="get">
                        <div class="serchninput"><input type="text" name="title" value="" onclick="search_input(this)"/></div>
                        <div class="serchbut"><input type="submit" id="serchadd" value="搜索" /></div>
                    </form>
                </div>

            </div>
            <div class="databox databoxs" style="width:730px">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50">&nbsp;</th>
                            <th width="347">问题标题</th>
                            <th width="89">提问人</th>
                            <th width="167">提问时间</th>
                            <th width="75">操作</th>
                        </tr>
                    </thead>
                    <tbody id="resousdata">
                        <?php foreach ( $list as $key => $val )
                        { ?>
                            <tr>
                                <td><input type="checkbox" name="item_id[]" value="<?= $val[ 'id' ] ?>"/></td>
                                <td><?= $val[ 'title' ] ?></td>
                                <td><?= $val[ 'username' ] ?></td>
                                <td><?= $val[ 'qtime' ] ?></td>
                                <td><a href="/study_stu_question/get_question_info/<?= $val[ 'id' ] ?>">回复</a></td>
                            </tr>
<?php } ?>
                    </tbody>                
                </table>
            </div>
            <div class="noticekatebox">

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
