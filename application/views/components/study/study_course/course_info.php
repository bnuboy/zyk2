<script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
<link rel="stylesheet" href="/resource/css/jquery-ui.css"/>
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<link rel="stylesheet" href="/resource/css/jquery-ui.css">
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<script charset="utf-8" src="/resource/updata/kindeditor.js"></script>
<script charset="utf-8" src="/resource/updata/lang/zh_CN.js"></script>
<script>
    var editor;
        KindEditor.ready(function(K) {
                editor = K.create('#description', {
                        themeType : 'simple',
                        afterBlur: function() {
                            $("#description").html(editor.html());
                      }
                });
        });
</script>
<script>
   $().ready(function() {
      $.validator.setDefaults({
          submitHandler: function(form){
              form.submit();
          }
      });
      $("#sub_form").validate({
          errorPlacement: function(error, element) { //配置错误信息输出
              error.appendTo( element.parent() );
          },
          success: function(label) {
              label.text("正确").addClass("success"); //返回值
          },
          rules: {
              "data[name]": {required:true},
              "data[course_uuid]": {required:true},
              "data[organization_id]": {required:true},
              "data[classify_cat_id]": {required:true},
              "data[resource_id]": {required:true},
              "data[start_time]": {required:true},
              "data[end_time]": {required:true},
              "data[period]": {required:true},
              "data[score]": {required:true},
              "data[student_count]": {required:true},
              "data[img]": {required:true}
          },
          messages: {
              "data[name]": {required : "请填写课程名称"},
              "data[course_uuid]": {required : "请填写课程代码"},
              "data[organization_id]": {required : "请选择所属院系"},
              "data[classify_cat_id]": {required : "请选择课程分类"},
              "data[resource_id]": {required : "请选择资源库"},
              "data[start_time]": {required : "请选择开始时间"},
              "data[end_time]": {required : "请选择结束时间"},
              "data[period]": {required : "请填写课时"},
              "data[score]": {required : "请填写学分"},
              "data[student_count]": {required : "请填写学生人数"},
              "data[img]": {required : "请上传图片"}
          }
      });
  });
 </script>
<script>
    $(function(){
        $( "#starttime" ).datepicker({ dateFormat: 'yy-mm-dd 00:00:00',yearRange:'c-50:c+10',
            changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
        $( "#endtime" ).datepicker({ dateFormat: 'yy-mm-dd 00:00:00',yearRange:'c-50:c+10',
            changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
   })
</script>
<style>
    form {
        margin: 0;
    }
    textarea {
        display: block;
    }
</style>

<!--管理信息-->
<div class="noticesbox">
    <div class="noticewarp">

        <div class="noticetit"><h1>课程信息</h1></div>

        <div class="noticenwarp">
            <form action="/study_course/edit/<?= $course_info[ 'id' ] ?>" method="post"  id="sub_form" enctype="multipart/form-data">
                <div class="noticekatebox">
                    <div class="addpword">课程名称：</div>
                    <div class="scselect">
                        <span class="addptit"><input name="data[name]" type="text" value="<?= $course_info[ 'name' ]; ?>"/></span>
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpword">课程代码：</div>
                    <div class="scselect">
                        <span class="addptit"><input name="data[course_uuid]" type="text" value="<?= $course_info[ 'course_uuid' ] ?>"/></span>
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">所属院系：</div>
                    <div class="scselect" name="data[organization_id]">
                       <select name="data[organization_id]" style="padding:6px;">
                          <option value="">==请选择==</option>
                          <?php foreach( $organizations as $k => $v ){ ?>
                            <option value="<?=$v['id'];?>" <?= isset($course_info['organization_id']) && $v['id'] == $course_info['organization_id'] ? "selected" : "" ?>><?=$v['name'];?></option>
                          <?php } ?>
                       </select>
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">课程分类：</div>
                    <div class="scselect" name="data[classify_cat_id]">
                       <select name="data[classify_cat_id]" style="padding:6px;">
                          <option value="">==请选择==</option>
                          <?php foreach( $course_cats as $k => $v ){ ?>
                            <option value="<?=$v['id'];?>" <?= isset($course_info['classify_cat_id']) && $v['id'] == $course_info['classify_cat_id'] ? "selected" : "" ?>><?=$v['name'];?></option>
                          <?php } ?>
                       </select>
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">关联资料库：</div>
                    <div class="scselect" name="data[resource_id]">
                       <select name="data[resource_id]" style="padding:6px;">
                          <option value="">==请选择==</option>
                          <?php foreach( $libs as $k => $v ){ ?>
                            <option value="<?=$v['id'];?>" <?= isset($course_info['resource_id']) && $v['id'] == $course_info['resource_id'] ? "selected" : "" ?>><?=$v['name'];?></option>
                          <?php } ?>
                        </select>
                    </div>
                </div>
                
                <div class="noticekatebox">
                    <div class="addpwordn">课程教师：</div>
                          <div id="user_select_checkbox" class="scselect"></div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">开始时间：</div>
                    <div class="addfile"><input name="data[start_time]" type="text" id="starttime" value="<?= $course_info[ 'start_time' ]; ?>"/></div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">结束时间：</div>
                    <div class="addfile"><input name="data[end_time]" type="text" value="<?= $course_info[ 'end_time' ]; ?>" id="endtime"/></div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">课时：</div>
                    <div class="scselect"><span class="addptit"><input name="data[period]" type="text" value="<?= $course_info[ 'period' ]; ?>"/></span></div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">学分：</div>
                    <div class="scselect"><span class="addptit"><input name="data[score]" type="text" value="<?= $course_info[ 'score' ]; ?>"/></span></div>
                </div>

                <div class="noticekatebox">
                    <div class="addpword">学生人数：</div>
                    <div class="addptit"><input name="data[student_count]" type="text" value="<?= $course_info[ 'student_count' ]; ?>"/></div>
                </div>

                <div class="noticekatebox" style="padding-bottom:20px;">
                    <div class="addpword">图片：</div>
                    <div class="addfile">
                        <input id="file_path_input" name="data[img]" type="hidden" value="<?= $course_info[ 'img' ]; ?>"/>
                       <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=file_path_input&defaultvalue=<?=$course_info['img']?>&allowed_extensions=jpg|gif&overwrite=TRUE&encrypt_name=TRUE" width="760px" height="54px;">
                       </iframe>
                </div>
                </div>

                <div class="noticekatebox" style="height:auto;">
                    <div class="addpwordn">简介：</div>
                    <div class="addpease" style="height:auto;">
                        <textarea  id="description"  name="data[description]"><?= $course_info[ 'description' ]; ?></textarea>
                    </div>
                </div>
                    
                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="button" onclick="location.href='/study_course'" class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="submit"  class="addbut" value="保存" /></div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$teacherids = '';
if(!empty($teachers)){
    $ids = array();
    foreach($teachers as $k => $v){
        $ids[] = $v['id'];
    }
    $teacherids = implode(',', $ids);
}
?>
<script>
    function user_select_checkbox(){
        var strurl     = '/common/user_select_checkbox';
        var where      = "`type` = 'teacher' AND `enabled` = 'y'";
        var inputid    = 'teacher_ids';
        var inputname  = 'teacher_ids';
        var defaultval = "<?=$teacherids;  ?>";
        $.post(strurl, {where:where,inputid:inputid,inputname:inputname,defaultval:defaultval}, function(data){
            $('#user_select_checkbox').html(data);
        });
    }
    user_select_checkbox();
</script>

<!--管理信息 end-->