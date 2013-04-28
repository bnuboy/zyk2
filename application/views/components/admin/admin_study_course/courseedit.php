<link rel="stylesheet" href="/resource/css/jquery-ui.css">
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
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
         /* 
         //重写错误显示消息方法,以alert方式弹出错误消息
        showErrors: function(errorMap, errorList) {  
            var msg = "";  
            $.each( errorList, function(i,v){  
              msg += (v.message+"\r\n");  
            });  
            if(msg!="") alert(msg);  
        },  
        //失去焦点时不验证
        onfocusout: false  
        */
        
      });
  });

  $( "#birthday" ).datepicker({ dateFormat: 'yymmdd',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'] });
    $(function(){
    $( "#start_time" ).datepicker({ dateFormat: 'yy-mm-dd 00:00:00',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
    $( "#end_time" ).datepicker({ dateFormat: 'yy-mm-dd 00:00:00',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
  })
 </script>

<form action="/admin_study_course/courseedit" enctype="multipart/form-data" method="post" id="sub_form" >
  <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
  <div class="noticewarp" >

    <div class="noticetit">
      <h1>课程管理-<?php echo !empty($data['id'])?"编辑":"新增"; ?></h1>
    </div>

    <div class="noticenwarp">
      <table>
        <tr colspan='3'>
          <td class="maddpword">课程名称:</td> 
          <td class="maddness" style="width:400px;"> 
            <input name="data[name]" type="text" value="<?=isset($data['name']) ? $data['name'] : '' ;  ?>"/>
          </td>
          <td></td>
        </tr>
        
        <tr colspan='3'>
          <td class="maddpword">课程代码:</td> 
          <td class="maddness" style="width:400px;">
            <input name="data[course_uuid]" type="text" value="<?=isset($data['course_uuid']) ? $data['course_uuid'] : '' ;  ?>"/>
          </td>
        </tr>
        
        <tr colspan='3'>
          <td class="maddpword">所属院系:</td> 
          <td class="maddness" style="width:400px;"> 
            <select name="data[organization_id]" style="padding:6px;" <?=$this->type=='organization'?"disabled":""?>>
              <option value="">==请选择==</option>
              <?php foreach( $organizations as $k => $v ){ ?>
                <option value="<?=$v['id'];?>" <?=!empty($org)&&$org==$v['id']?'selected':''?> <?= isset($data['organization_id']) && $v['id'] == $data['organization_id'] ? "selected" : "" ?>><?=$v['name'];?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr colspan='3'>
          <td class="maddpword">课程分类:</td> 
          <td class="maddness" style="width:400px;"> 
            <select name="data[classify_cat_id]" style="padding:6px;">
              <option value="">==请选择==</option>
              <?php foreach( $cats as $k => $v ){ ?>
                <option value="<?=$v['id'];?>" <?= isset($data['classify_cat_id']) && $v['id'] == $data['classify_cat_id'] ? "selected" : "" ?>><?=$v['name'];?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr colspan='3'>
          <td class="maddpword">所属资源库:</td> 
          <td class="maddness" style="width:400px;"> 
            <select name="data[resource_id]" style="padding:6px;">
              <option value="">==请选择==</option>
              <?php foreach( $libs as $k => $v ){ ?>
                <option value="<?=$v['id'];?>" <?= isset($data['resource_id']) && $v['id'] == $data['resource_id'] ? "selected" : "" ?>><?=$v['name'];?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
        
        <tr colspan='3'>
          <td class="maddpword">课程教师:</td>
          <td class="maddnessk"  style="width:400px;">
            <div id="user_select_checkbox"></div>
          </td>
          <td></td>
        </tr>
        
        <tr colspan='3'>
          <td class="maddpword">开始时间:</td> 
          <td class="maddness" style="width:400px;">
            <input name="data[start_time]" type="text" value="<?=isset($data['start_time']) ? $data['start_time'] : '' ;  ?>" id="start_time"/>
          </td>
        </tr>
        <tr colspan='3'>
          <td class="maddpword">截止时间:</td> 
          <td class="maddness" style="width:400px;">
            <input name="data[end_time]" type="text" value="<?=isset($data['end_time']) ? $data['end_time'] : '' ;  ?>" id="end_time"/>
          </td>
        </tr>
        
        <tr colspan='3'>
          <td class="maddpword">课时:</td> 
          <td class="maddness" style="width:400px;"> 
            <input name="data[period]" type="text" value="<?=isset($data['period']) ? $data['period'] : '' ;  ?>"/>
          </td>
        </tr><tr>
          <td class="maddpword">学分:</td> 
          <td class="maddness" style="width:400px;"> 
            <input name="data[score]" type="text" value="<?=isset($data['score']) ? $data['score'] : '' ;  ?>"/></td>
        </tr>
        <tr>
          <td class="maddpword">学生人数:</td> 
          <td class="maddness" style="width:400px;"> 
            <input name="data[student_count]" type="text" value="<?=isset($data['student_count']) ? $data['student_count'] : '' ;  ?>"/></td>
        </tr>

      </table>

      <div class="noticekatebox" style="width:800px;height:58px;">
        <div class="maddpword">图片：</div>
        <div  class="maddness"  style="width:600px;height:58px;">
          <input name="data[img]" id="img" type="hidden" value="<?=isset($data['img']) ? $data['img'] : ''; ?>"/>
          <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=img&defaultvalue=<?php echo empty($data['img']) ? '' : $data['img']?>&allowed_extensions=gif|jpg|sql&overwrite=false&encrypt_name=false" width="400px" height="54px;"></iframe>
        </div>
      </div>


      <div style="padding:20px 10px 5px 10px;font-size:14px">简介：</div>
      <div >
         <?php Util::showFck(array('id'=>'description', 'name'=>'data[description]','value'=>empty($data['description'])?'':$data['description'],'width'=>'','height'=>'','toolbar'=>''));?>
      </div>
      <div class="basebutbox">
       <div class="addbutdel"><input type="button"  onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
       <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
     </div>
    </div>

  </div>

  
</form>

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