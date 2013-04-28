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
                    "data[organization_id]": {required:true},
                    "data[img]": {required:true},
                    "data[keywords]": {required:true}
                  },
          messages: {
                    "data[name]": {required:"请填写名称"},
                    "data[organization_id]": {required:"请选择所属院系"},
                    "data[img]": {required:"请选择上传图片"},
                    "data[keywords]": {required:"请填写关键词"}
                  }
      });
  });
</script>
<form action="/admin_resource_library/libraryedit" method="post" id="sub_form">
  <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
  <div class="noticewarp">

    <div class="noticetit">
      <h1><?php echo !empty($data['id'])?"编辑":"新增"; ?>资料库</h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox" style="padding-top:30px;">
        <div class="maddpword">项目名称：</div>
        <div class="maddness" style="width:500px;">
          <input name="data[name]" value="<?=empty($data['name']) ? '' : $data['name'] ?>" type="text"/>
          <span class="must_star" >&nbsp;*</span>
        </div>
      </div>

      <div class="noticekatebox" style="padding-top:5px;">
        <div class="maddpword">所属院系：</div>
        <select name="data[organization_id]" style="padding:6px;" <?=$this->type=='organization'?"disabled":""?>>
          <option value="">==请选择==</option>
          <?php foreach( $organizations as $k => $v ){ ?>
            <option value="<?=$v['id'];?>" <?=!empty($org)&&$org==$v['id']?'selected':''?>  <?= isset($data['organization_id']) && $v['id'] == $data['organization_id'] ? "selected" : "" ?>><?=$v['name'];?></option>
          <?php } ?>
        </select>
        <span class="must_star" >*</span>
      </div>

      <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">图片：</div>
        <div class="addfile" style="width:560px;height:60px;">
          <input name="data[img]" id="file_path_input" type="hidden" value="<?=empty($data['img']) ? '' : $data['img'] ?>"/>
          <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=file_path_input&defaultvalue=<?php echo empty($data['img']) ? '' : $data['img']?>&allowed_extensions=gif|jpg&overwrite=TRUE&encrypt_name=TRUE" width="400px" height="54px;"></iframe>
        </div>
      </div>

      <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">关键词：</div>
        <div class="maddness" style="width:500px;">
          <input name="data[keywords]" value="<?=empty($data['keywords']) ? '' : $data['keywords'] ?>" type="text"/>
          <span class="must_star" >&nbsp;*</span>
        </div>
      </div>

      <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">排序号：</div>
        <div class="maddness" style="width:500px;">
          <input name="data[order]" value="<?=empty($data['order']) ? '' : $data['order'] ?>" type="text"/>
        </div>
      </div>

      <div style="height:95px;" class="noticekatebox">
        <div class="maddpword">简介：</div>
        <div class="resease"><textarea name="data[description]"><?=empty($data['description']) ? '' : $data['description'] ?></textarea></div>
      </div>
      <div class="basebutbox">
       <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
       <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
     </div>
    </div>

  </div>

  
</form>