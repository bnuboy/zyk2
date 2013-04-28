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
                    "data[code]": {required:true},
                    "data[img]": {required:true},
                    "data[enabled]": {required:true},
                    "data[order]": {required:true}
                  },
          messages: {
                    "data[name]": {required:"请填写院系名称"},
                    "data[code]": {required:"请填写院系代码"},
                    "data[img]": {required:"请上传图片"},
                    "data[enabled]": {required:"请选择启用状态"},
                    "data[order]": {required:"请填写排序号"}
                  }
      });
  });
</script>


<form action="/admin_school_organization/organizationedit" enctype="multipart/form-data" method="post" id="sub_form">
  <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
  <div class="noticewarp">

    <div class="noticetit">
      <h1>院系管理-<?php echo isset($data['id'])?"编辑":"新增"; ?></h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox" style="padding-top:30px;">
        <div class="maddpword">院系名称：</div>
        <div class="maddness" style="width:500px;">
          <input name="data[name]" value="<?=isset($data['name']) ? $data['name'] : '' ;  ?>" type="text"/>
          <span class="must_star" >*</span>
        </div>
      </div>

      <div class="noticekatebox" style="padding-top:5px;">
        <div class="maddpword">所属上级：</div>
        <select name="data[f_id]" style="padding:6px;">
          <option value="0">==顶级==</option>
          <?php foreach( $organizations as $k => $v ){ ?>
            <option value="<?=$v['id'];?>" <?= $v['id'] == $data['f_id'] ? "selected" : "" ?>><?=$v['tag'].$v['name'];?></option>
          <?php } ?>
        </select>
        <span class="must_star" >*</span>
      </div>

      <div class="noticekatebox">
        <div class="maddpword">院系代码：</div>
        <div class="maddness" style="width:500px;">
          <input name="data[code]" value="<?=isset($data['code']) ? $data['code'] : '' ;  ?>" type="text"/>
          <span class="must_star" >*</span>
        </div>
      </div>

      <div class="noticekatebox">
        <div class="maddpword">图片：</div>
        <div class="maddness" style="width:500px;">
          <input name="data[img]" id="img" type="hidden" value="<?=isset($data['img']) ? $data['img'] : ''; ?>"/>
          <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=img&defaultvalue=<?php echo empty($data['img']) ? '' : $data['img']?>&allowed_extensions=gif|jpg|png&overwrite=false&encrypt_name=false" width="400px" height="54px;"></iframe>
        </div>
      </div>

      <div class="noticekatebox">
        <div class="maddpword">是否启用：</div>
        <div class="maddness" style="width:500px">
          <select name="data[enabled]" style="padding:6px;" >
            <option value="">==请选择==</option>
            <option value="y" <?=(isset($data['enabled']) && $data['enabled'] == 'y') ? 'selected' : ''; ?>>启用</option>
            <option value="n" <?=(isset($data['enabled']) && $data['enabled'] == 'n') ? 'selected' : ''; ?>>禁用</option>
          </select>

          <span class="must_star" >&nbsp;*</span>
        </div>
      </div>
      <div class="noticekatebox">
        <div class="maddpword">排序号：</div>
        <div class="maddness" style="width:500px;">
          <input name="data[order]" value="<?=isset($data['order']) ? $data['order'] : '' ;  ?>" type="text"/>
          <span class="must_star" >*</span>
        </div>
      </div>
      <div class="noticekatebox" style="padding-bottom:150px;">
        <div class="maddpword">院系简介：</div>
        <div class="addpease">
          <textarea name="data[description]"><?=isset($data['description']) ? $data['description'] : '' ;  ?></textarea>
        </div>
      </div>
      <div class="basebutbox">
        <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
        <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
      </div>
    </div>

  </div>

  
</form>