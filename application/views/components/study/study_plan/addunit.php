<script>
    function addto(id_str){
        if(id_str==""){
        alert("请选择关联内容");
        }
        $("#p").append("<input type='hidden' value='"+id_str+"' name='data[relevance_id]'>");
    }
</script>
<style>
    form {
        margin: 0;
    }
    textarea {
        display: block;
    }
</style>
<script>
    $(function(){
        product();
        changeweight();
    });
  function product(){
        if($("select option:selected").val()=='5'){
           $("#product_score").show();
        }else{
         $("#product_score").css("display","none");
        }
        var href_url="";
        var id='';
        if($("select option:selected").val()=='1'){
           id="iframe";
           href_url="/study_plan/course_resource?id=<?= empty( $info[ 'id' ] ) ? '' : $info[ 'id' ] ?>";
        }else if($("select option:selected").val()=='2'){
           id="job";
           href_url="/study_plan/homework?id=<?= empty( $info[ 'id' ] ) ? '' : $info[ 'id' ] ?>";
        }else if($("select option:selected").val()=='3'){
           id="test";
           href_url="/study_plan/selftesting?id=<?= empty( $info[ 'id' ] ) ? '' : $info[ 'id' ] ?>";
        }else if($("select option:selected").val()=='6'){
           id="course_content";
           href_url="/study_plan/course_content?id=<?= empty( $info[ 'id' ] ) ? '' : $info[ 'id' ] ?>";
        }
        $("#"+id).attr('href', href_url);
        $("#"+id).click();
    }

    function changeweight(){
        if($("#rad input[type='radio']:checked").val()=='1'){
            $("#weight").html("<div class='addpwordn'>学生评分权重：</div><div class='addptimes'><input type='text' value='<?= empty( $info[ 'relevance' ]['stu_weight'] ) ? '' : $info[ 'relevance' ]['stu_weight'] ?>'name='param[stu_weight]'/>%</div>");
        }else if($("#rad input[type='radio']:checked").val()=='2'){
            $("#group").attr('href', "/study_plan/group");
            $("#group").click();
            $("#weight").html("<div class=addpwordn>评分策略：</div> <div class='addpnotwn'><lable><input name='param[stu_weight]' type='radio' value='0' checked='checked'/>&nbsp;&nbsp;小组平均分</lable></div>");
        }
       
    }
    function putdata(obj){
    $("#group_name").val(obj);
    }
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
<script charset="utf-8" src="/resource/updata/kindeditor-min.js"></script>
<script charset="utf-8" src="/resource/updata/lang/zh_CN.js"></script>
<script charset="utf-8" src="/resource/updata/php/upload_json.php"></script>
<script>
 var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[id="content"]', {
            allowFileManager : true
        });
   })
</script>
<div class="noticewarp tea-cont">
    <form method="post" id="updateconfig" name="updateconfig" action="" onsubmit="return checksubmit()">
        <input type="hidden" id="id" name="data[id]" value="<?= empty( $info[ 'id' ] ) ? '' : $info[ 'id' ] ?>" />
        <div class="noticetit tearch-nav">
            <h2>课程计划 ><?php echo!empty( $info[ 'id' ] ) ? "编辑" : "添加"; ?>教学单元</h2>
            <div><a href="#" class="blue" onclick="javascript:history.go(-1)">&lt;&lt;返回</a></div>
        </div>
        <div class="noticenwarp" style="height:auto;">
            <div class="noticekatebox">
                <div class="addpword">标题：</div>
                <div class="addptit">
                    <input name="data[title]" id="title" type="text" value="<?= empty( $info[ 'title' ] ) ? '' : $info[ 'title' ] ?>"/>
                </div>
            </div>
            <div class="noticekatebox" style="height:auto;">
                <div class="addpwordn">内容：</div>
                <div class="addpease" style="height:auto;"><textarea id="content" name="data[content]"><?= empty( $info[ 'content' ] ) ? '' : $info[ 'content' ] ?></textarea></div>
            </div>
            <div class="noticekatebox">
                <div class="addpwordn">关联项目：</div>
                <div class="addfile">
                    <select style="padding:5px;" name="data[relevance_type]" id="select" onchange="product()" >
                        <option <?= !empty( $info[ 'relevance_type' ] ) ? '' : "selected='selected'" ?> value="">无</option>
                        <option value="1" <?= isset( $info[ 'relevance_type' ] ) && $info[ 'relevance_type' ] == '1' ? "selected='selected'" : "" ?>>教学资料</option>
                        <option value="2" <?= isset( $info[ 'relevance_type' ] ) && $info[ 'relevance_type' ] == '2' ? "selected='selected'" : "" ?>>作业</option>
                        <option value="3" <?= isset( $info[ 'relevance_type' ] ) && $info[ 'relevance_type' ] == '3' ? "selected='selected'" : "" ?>>自测</option>
                        <option value="4" <?= isset( $info[ 'relevance_type' ] ) && $info[ 'relevance_type' ] == '4' ? "selected='selected'" : "" ?>>即时讨论</option>
                        <option value="5" <?= isset( $info[ 'relevance_type' ] ) && $info[ 'relevance_type' ] == '5' ? "selected='selected'" : "" ?>>作品</option>
                        <option value="6" <?= isset( $info[ 'relevance_type' ] ) && $info[ 'relevance_type' ] == '6' ? "selected='selected'" : "" ?>>课程内容</option>
                    </select>
                    <input type="hidden" id="iframe" class="iframe cboxElement" >
                    <input type="hidden" id="job"  class="job cboxElement">
                    <input type="hidden" id="test"  class="test cboxElement">
                    <input type="hidden" id="course_content"  class="course_content">
                </div>
                <div id="p"></div>
            </div>
            <div style="display:none" id="product_score">
            <div class="noticekatebox">
                <div class="addpwordn">作品总分：</div>
                <div class="addptimes"><input type="text" name="param[score]" value="<?= empty( $info[ 'relevance' ]['score'] ) ? '' : $info[ 'relevance' ]['score'] ?>"/>分（0-100）之间</div>
            </div>
            <div class="noticekatebox">
                <div class="addpwordn">总分相互可见：</div>
                <div class="addpnotwn">
                    &nbsp;<label><input name="param[score_status]" type="radio" value="1" <?=empty($info[ 'relevance' ]['score_status'])?"checked='checked'":"" ?> <?= !empty( $info[ 'relevance' ]['score_status'] ) && $info[ 'relevance' ]['score_status']=='1' ? 'checked="checked"' :""?>  />&nbsp;&nbsp;是</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="param[score_status]" value="2" <?= !empty( $info[ 'relevance' ]['score_status'] ) && $info[ 'relevance' ]['score_status']=='2' ? 'checked="checked"' :""?> />&nbsp;&nbsp;否</label>
                </div>
            </div>
            <div class="noticekatebox">
                <div class="addpwordn">分组：</div>
                <div class="addpnotwn" id="rad">
                    &nbsp;<label><input name="param[type]" type="radio" value="1" <?=empty($info[ 'relevance' ]['type'])?"checked='checked'":"" ?> <?= !empty( $info[ 'relevance' ]['type'] ) && $info[ 'relevance' ]['type']=='1' ? 'checked="checked"' :""?> onclick="changeweight()"/>&nbsp;&nbsp;不分组</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="param[type]"  value="2" <?= !empty( $info[ 'relevance' ]['type'] ) && $info[ 'relevance' ]['type']=='2' ? 'checked="checked"' :""?>  onclick="changeweight()"/>&nbsp;&nbsp;教师手动分组</label>
                    <input type="hidden" id="group" class="groups cboxElement">
                    <input type="hidden" name="group" id="group_name">
                </div>
            </div>
            <div class="noticekatebox" id="weight">
                <div class="addpwordn">学生评分权重：</div>
                <div class="addptimes"><input type="text" name='param[stu_weight]' value="<?= empty( $info[ 'relevance' ]['stu_weight'] ) ? '' : $info[ 'relevance' ]['stu_weight'] ?>"/>%</div>
            </div>
        </div>
            <div class="noticekatebox" id="sendbut" style="margin-top:10px; width:708px;">
                <div class="addbutdel"><input type="reset" onclick="location.href='/study_plan/index'"class="addbut" value="取消" /></div>
                <div class="addbutin"><input type="submit" class="addbut" value="提交" /></div>
            </div>
        </div>
    </form>
</div>

<link type="text/css" href="/resource/js/front/colorbox/colorbox.css" rel="stylesheet" />
<script src="/resource/js/front/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        $(".iframe").colorbox({iframe:true, innerWidth:419, innerHeight:264});
        $(".job").colorbox({iframe:true, innerWidth:402, innerHeight:203});
        $(".test").colorbox({iframe:true, innerWidth:402, innerHeight:203});
        $(".course_content").colorbox({iframe:true, innerWidth:420, innerHeight:420});
        $(".groups").colorbox({iframe:true, innerWidth:605, innerHeight:485});
        $("#click").click(function(){
            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
            return false;
        });
    });
</script>