<div class="noticewarp">
    <div class="noticetit tearch-nav tearch-navts">
        <h1>其他课程资源</h1>
        <div><a onclick="javascript:history.go(-1)" class="blue" href="#">&lt;&lt;返回</a></div>
    </div>
    <div class="cendatarav">
       <ul>
          <li ><a href="/study_course_resource/upfile/<?=$this->course['id']?>" title="上传">上传</a></li>
          <li class="over"><a href="/study_course_resource/anthorcourse" title="其他课程资源">其他课程资源</a></li>
        </ul>
     </div>
    <form action="/study_course_resource/importcourse" method="post" id="sub">
    <div class="noticenwarp">
        <div class="noticekatebox" style="width:730px;padding-right:0;">
            <div class="dataediabox">
                <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
                <div class="ediacheckw">全选</div>
            </div>
        </div>

        <div class="databox databoxs" style="width:730px">
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="42">&nbsp;</th>
                        <th width="226">名称</th>
                        <th width="65">所属课程</th>
                        <th width="65">文件大小</th>
                        <th width="164">导出时间</th>
                    </tr>
                </thead>
                <tbody id="resousdatas">
                    <?php foreach($list as $value){?>
                    <tr>
                        <td><input class="check" name="item_id[]" value="<?= $value[ 'id' ] ?>" type="checkbox"/></td>
                        <td><a href="<?=$value['file_path']?>"><?=$value['name']?></a></td>
                        <td><?=$value['course_name']['name']?></td>
                        <td><?=$value['file_size']?></td>
                        <td><?=$value['load_time']?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>

        <div class="noticekatebox" style="width:730px">
            <div class="dataediabox">
                <div class="datadel"><a href="#this" onclick="javascript:history.go(-1)" title="取消">取消</a></div>
                <div class="dataadd"><a href="#this" onclick="javascript:$('#sub').submit()" title="导入">导入</a></div>
            </div>

        </div>
    </div>
       </form>
</div>
<link type="text/css" href="/resource/js/front/colorbox/colorbox.css" rel="stylesheet" />
<script src="/resource/js/front/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        //Examples of how to assign the ColorBox event to elements


        $(".iframe").colorbox({iframe:true, innerWidth:403, innerHeight:331});
        //Example of preserving a JavaScript event for inline calls.
        $("#click").click(function(){
            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
            return false;
        });
    });
</script>