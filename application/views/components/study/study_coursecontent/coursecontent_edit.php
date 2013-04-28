<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<style>
    form {
        margin: 0;
    }
    textarea {
        display: block;
    }
</style>
<script charset="utf-8" src="/resource/updata/kindeditor-min.js"></script>
<script charset="utf-8" src="/resource/updata/lang/zh_CN.js"></script>
<script charset="utf-8" src="/resource/updata/php/upload_json.php"></script>
<script>
    function putdata(str_id){
        $("#resource").attr("value",str_id);
    }
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[id="content"]', {
            allowFileManager : true
        });
   })
   function checksubmit(){
       if($("#title").val()==""){
           alert("标题不能为空");
           return false;
       }
       if($("#title").val().length>30){
           $("#title").val("");
           alert("标题不能超过30个字");
           return false;
       }
    }
</script>
<!--中间内容-->
<!--管理信息-->
<div class="noticesbox">
    <div class="noticewarp">
        <div class="noticetit tearch-nav tearch-navts">
            <h2>编辑章目</h2>
            <div><a href="/study_coursecontent">返回</a></div>
        </div>
        <div class="noticenwarp">
            <form action="/study_coursecontent/edit/<?= $content[ 'id' ] ?>" method="post" id="sub_form">
                <div class="noticekatebox">
                    <div class="addpword">标题：</div>
                    <div class="addptit"><input name="title" type="text" id="title" value="<?= $content[ 'title' ] ?>"/>*</div>
                </div>
                <div class="noticekatebox" style="height:auto;">
                    <div class="addpwordn">内容：</div>
                    <div class="addpease" style="height:auto;"><textarea id="content" name="content"><?= $content[ 'content' ] ?></textarea></div>
                </div>
                <div class="clear"></div>
                <link type="text/css" href="/resource/js/front/colorbox/colorbox.css" rel="stylesheet" />
                <script src="/resource/js/front/colorbox/jquery.colorbox.js"></script>
<!--                <div class="noticekatebox">
                    <div class="addbutin">
                        <a title="关联资源" href="/study_coursecontent/connectresource?content_id=<?=$content[ 'id' ]?>" class="iframe cboxElement">关联资源库</a>
                        <input type="hidden" name="resource_id" id="resource">
                    </div>
                </div>-->
                <script>
                    $(document).ready(function(){
                        $(".iframe").colorbox({iframe:true, innerWidth:980, innerHeight:500});
                        $("#click").click(function(){
                            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
                            return false;
                        });
                    });
                </script>
                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="button" onclick="location.href='/study_coursecontent/index/<?= $content[ 'id' ] ?>'" class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="submit"  class="addbut" value="保存" /></div>
                     <div class="addbutin">
                        <a title="关联资源" href="/study_coursecontent/connectresource?content_id=<?=$content[ 'id' ]?>" class="iframe cboxElement">关联资源库</a>
                        <input type="hidden" name="resource_id" id="resource">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--管理信息 end-->
<!--中间内容 end-->
