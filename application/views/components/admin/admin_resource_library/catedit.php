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
                    "data[order]": {required:true}
                  },
          messages: {
                    "data[name]": {required:"请填写分类名称"},
                    "data[order]": {required:"请填写排序号"}
                  }
      });
  });
</script>
<form action="/admin_resource_library/catedit/<?php echo $library['id'];?>" method="post" id="sub_form">
  <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
  <input type="hidden" id="library_id" name="data[library_id]" value="<?=$library['id'];?>" />
  <div class="noticewarp">

    <div class="noticetit">
      <h1>资源库[<span style="color:red;"><?php echo $library['name'];?></span>]-<?php echo !empty($data['id'])?"编辑":"新增"; ?>分类</h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox" style="padding-top:30px;">
        <div class="maddpword">分类名：</div>
        <div class="maddness" style="width:500px;">
          <input name="data[name]" value="<?=empty($data['name']) ? '' : $data['name'] ?>" type="text"/>
          <span class="must_star" >&nbsp;*</span>
        </div>
      </div>

      <div class="noticekatebox" style="padding-top:5px;">
        <div class="maddpword">所属上级：</div>
        <select name="data[f_id]" style="padding:6px;">
          <option value="0">顶级分类</option>
          <?php foreach( $cats as $k => $v ){ ?>
            <option value="<?=$v['id'];?>" <?= $v['id'] == isset($data['f_id']) ? $data['f_id'] : 0 ? "selected" : "" ?>><?=$v['tag'].$v['name'];?></option>
          <?php } ?>
        </select>
      </div>

      <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">排序号：</div>
        <div class="maddness" style="width:500px;">
          <input name="data[order]" value="<?=empty($data['order']) ? '' : $data['order'] ?>" type="text"/>
          <span class="must_star" >&nbsp;*</span>
        </div>
      </div>


    </div>

  </div>

  <div class="basebutbox">
    <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
    <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
  </div>
</form>