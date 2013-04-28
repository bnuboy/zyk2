<script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
<link rel="stylesheet" href="/resource/css/jquery-ui.css">
<script>
  $(function(){
    $( "#start_time" ).datepicker({ dateFormat: 'yy-mm-dd 00:00:00',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
    $( "#end_time" ).datepicker({ dateFormat: 'yy-mm-dd 00:00:00',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'] });
  })
</script>
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
              "data[start_time]": {required:true},
              "data[end_time]": {required:true},
              "data[content]": {required:true}
          },
          messages: {
              "data[name]": {required : "请填写标题"},
              "data[start_time]": {required : "请填写开始时间"},
              "data[end_time]": {required : "请填写结束时间"},
              "data[content]": {required : "请填写内容"}
          }
      });
  });
</script>

<div class="noticewarp">

  <div class="noticetit">
    <h1><img src="/resource/images/date.gif" />日程安排-<?php echo !empty($data['id'])?"编辑":"新增"; ?></h1>
  </div>

  <div class="noticenwarp" style="height:560px;">

    <form action="/ucenter_user_agenda/agendaedit" method="post" id="sub_form">
      <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
      <div class="noticekatebox">
        <div class="addpword">日程安排：</div>
        <div class="addptit"><input name="data[name]" type="text" value="<?=isset($data['name']) ? $data['name'] : '' ;  ?>"/></div>
        <span class="must_star">*</span>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn">起始时间：</div>
        <div class="addfile"><input readonly name="data[start_time]" type="text"  id="start_time" value="<?=isset($data['start_time']) ? $data['start_time'] : '' ;  ?>"/></div>
        <div class="addpnotwn">（年－月－日  时：分）</div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn">截止时间：</div>
        <div class="addfile"><input readonly name="data[end_time]" type="text" id="end_time" value="<?=isset($data['end_time']) ? $data['end_time'] : '' ;  ?>"/></div>
        <div class="addpnotwn">（年－月－日  时：分）</div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn">状态：</div>
        <div class="maddness">
          <select style="padding:6px;" name="data[status]" >
            <?php foreach ( $CALENDER_STATUS as $key => $value ) { ?>
              <option value="<?= $key ?>" <?=(isset($data['status']) && $data['status'] == $key) ? 'selected' : ''; ?>><?= $value ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="noticekatebox" style="height:184px;">
        <div class="addpwordn">内容：</div>
        <div class="addpease"><textarea name="data[content]"><?=isset($data['content']) ? $data['content'] : '' ;  ?></textarea></div>
      </div>

      <div class="noticekatebox" id="sendbut" style="margin-top:10px; width:708px;">
        <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
        <div class="addbutin"><input type="submit"  class="addbut" value="确定" /></div>
      </div>

    </form>
  </div>

</div>
