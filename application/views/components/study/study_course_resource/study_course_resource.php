<script>
    /*
     *  重命名
     */
    function rename(){
        if($("#resousdatas input[type=checkbox]:checked").length == 0){
            alert("请选择一条记录");
        }else if($("#resousdatas input[type=checkbox]:checked").length >1){
            alert("只能选择一条记录");
        }else{
            var selectid=$("#resousdatas input[type=checkbox]:checked").val();
            $("#rename").attr('href', "/study_course_resource/rename?id="+selectid);
            $("#rename").click();
        }
    }

</script>
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<div class="noticewarp">
    <div class="noticetit tearch-nav tearch-navts">
        <h1>课程资源</h1>
        <div></div>
    </div>
    <div class="noticenwarp">
        <div class="noticekatebox" style="width:730px;padding-right:0;">
            <div class="dataediabox">
                <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
                <div class="ediacheckw">全选</div>
                <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量删除操作吗？', '请选择要删除的数据')" title="删除">删除</a></div>
                <div class="dataadd">
                    <a href="" id="rename" class="rename cboxElement"></a>
                    <a title="重命名" href="#this"onclick="rename();">重命名</a>
                </div>
                <div class="dataadd"><a href="/study_course_resource/upfile/<?=$course_id?>" title="导入课程资源">共享课程资源</a></div>
                <div class="dataadd"><a href="/study_course_resource/exportfile/<?=$course_id?>" class="iframe cboxElement" title="导出课程">导出课程</a></div>
            </div>
      <form id="search_form" action="/study_course_resource/" onsubmit="return checkSearch();"  method="get">
            <div class="serchbox">
                <div class="serchninput">
                     <input type="text" value="<?= isset( $get[ 'name' ] ) ? $get[ 'name' ] . '" repeat_search = "1' : '请输入资源名' ?>" onclick="search_input(this)" name="name">
                </div>
                <div class="serchbut">
                    <input type="submit" id="serchadd" value="搜索" />
                </div>
            </div>
      </form>
        </div>
         <form id="sub_form" name="sub_form" method="post" action="/study_course_resource/delete">
        <div class="databox databoxs" style="width:730px">
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="42">&nbsp;</th>
                        <th width="226">名称</th>
                        <th width="65">类型</th>
                        <th width="65">大小</th>
                        <th width="164">更新时间</th>
                        <th width="74">下载次数</th>
                        <th width="92">操作</th>
                    </tr>
                </thead>
                <tbody id="resousdatas">
                    <?php foreach($list as $value){?>
                    <tr>
                        <td><input class="check" name="item_id[]" value="<?= $value[ 'id' ] ?>" type="checkbox"/></td>
                        <td><a href="#"><?=$value['name']?></a></td>
                        <td><?=$value['type']?></td>
                        <td><?=$value['file_size']?></td>
                        <td><?=$value['update']?></td>
                        <td><?=$value['down_num']?></td>
                        <td><a href="<?=$value['file_path']?>">下载</a></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
         </form>

    </div>
</div>
<link type="text/css" href="/resource/js/front/colorbox/colorbox.css" rel="stylesheet" />
<script src="/resource/js/front/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        //Examples of how to assign the ColorBox event to elements


        $(".iframe").colorbox({iframe:true, innerWidth:403, innerHeight:265});
        $(".rename").colorbox({iframe:true, innerWidth:402, innerHeight:203});
        //Example of preserving a JavaScript event for inline calls.
        $("#click").click(function(){
            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
            return false;
        });
    });
</script>