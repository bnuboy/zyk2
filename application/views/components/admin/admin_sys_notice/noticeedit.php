<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<script src="/ckeditor/ckeditor.js" type="text/javascript"></script>
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
              "data[title]": {required:true},
              "data[target]": {required:true},
              "data[level]": {required:true},
              "data[comment]": {required:true}

          },
          messages: {
              "data[title]": {required : "请填写标题"},
              "data[target]": {required : "请选择接收对象"},
              "data[level]": {required : "请选择优先级"},
              "data[comment]": {required : "请填写公告内容"}

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
  })
</script>
<script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
<link rel="stylesheet" href="/resource/css/jquery-ui.css">
<form action="/admin_sys_notice/noticeedit" method="post" id="sub_form">
  <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
  <div class="noticewarp">

    <div class="noticetit">
      <h1>系统公告管理-<?php echo !empty($data['id'])?"编辑":"新增"; ?></h1>
    </div>

    <div class="noticenwarp">
	  <div class="noticekatebox">
        <div class="addpwordn">类别：</div>
        <div class="maddness">
          <select style="padding:6px;" name="data[type]" >
            <option value="相关新闻" <?php echo ((isset($data['type']) && $data['type'] == '相关新闻') ? 'selected' : '');?>>相关新闻</option>
            <option value="竞赛通知" <?php echo ((isset($data['type']) && $data['type'] == '竞赛通知') ? 'selected' : '');?>>竞赛通知</option>
            <option value="鉴定通知" <?php echo ((isset($data['type']) && $data['type'] == '鉴定通知') ? 'selected' : '');?>>鉴定通知</option>
            <option value="竞赛结果" <?php echo ((isset($data['type']) && $data['type'] == '竞赛结果') ? 'selected' : '');?>>竞赛结果</option>
            <option value="鉴定结果" <?php echo ((isset($data['type']) && $data['type'] == '鉴定结果') ? 'selected' : '');?>>鉴定结果</option>
          </select>
        </div>
      </div>
	
      <div class="noticekatebox">
        <div class="addpword">公告标题：</div>
        <div class="addptit"><input name="data[title]" value="<?=isset($data['title']) ? $data['title'] : '' ;?>" type="text"/></div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn">对象：</div>
        <div class="maddness">
          <select style="padding:6px;" name="data[target]" >
            <option value="">==请选择==</option>
            <option value="all" <?php echo ((isset($data['target']) && $data['target'] == 'all') ? 'selected' : '');?>>不限</option>
            <?php foreach($USER_TYPE as $key=>$value){ ?>
            <option value="<?=$key?>" <?=(isset($data['target']) && $data['target'] == $key) ? 'selected' : ''; ?>><?=$value?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      
      <div class="noticekatebox">
        <div class="addpwordn">置顶：</div>
        <div class="addpnotwn">
          &nbsp;<label><input name="data[top]" type="radio" value="1" <?=((isset($data['top']) && $data['top'] == '1') || !isset($data['top'])) ? 'checked' : ''; ?>/>&nbsp;&nbsp;是</label>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input  name="data[top]" type="radio" name="0" value="否" <?=(isset($data['top']) && $data['top'] == 0) ? 'checked' : ''; ?>/>&nbsp;&nbsp;否</label>
        </div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn">优先级：</div>
        <div class="maddness">
          <select style="padding:6px;" name="data[level]" >
            <option value="">==请选择==</option>
            <?php foreach($PUBLICNOTICE_LEVEL as $key => $value){ ?>
            <option value="<?=$key?>" <?=(isset($data['level']) && $data['level'] == $key) ? 'selected' : ''; ?>><?=$value?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="noticekatebox" style="height:184px;">
        <div class="addpwordn">内容：</div>
        <div class="addpease"><textarea name="data[comment]"><?=isset($data['comment']) ? $data['comment'] : '' ;?></textarea></div>
      </div>

      <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
        <div class="addbutin"><input type="submit" class="addbut" value="发布" /></div>
        <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
      </div>

    </div>

  </div>

</form>