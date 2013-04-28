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
              "data[title]": {required:true},
              "data[img_url]": {required:true},
              //"data[url]": {required:true},
              "data[enabled]": {required:true},
              "data[org_id]": {required:true}
          },
          messages: {
              "data[title]": {required : "请填写名称"},
              "data[img_url]": {required : "请上传缩略图"},
              //"data[url]": {required : "请填写链接地址"},
              "data[enabled]": {required: "请填写是否可用"},
              "data[org_id]": {required: "请选择所属院系"}
          }
      });
  });
</script>
<form action="/admin_cms_logo/logoedit" method="post" id="sub_form">
  <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
  <div class="noticewarp">

    <div class="noticetit">
      <h1>LOGO管理-<?php echo !empty($data['id'])?"编辑":"新增"; ?></h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox">
        <div class="addpword" >LOGO名称：</div>
        <div class="addfile" style="width:600px">
          <input name="data[title]" type="text" value="<?=isset($data['title']) ? $data['title'] : '' ;  ?>"/>
          <span class="must_star" >*</span>
        </div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn">所属院系：</div>
        <div class="addfile" style="width:300px">
          <select name="data[org_id]" style="padding:6px;" <?=$this->type=='organization'?"disabled":""?>>
            <option value="">==请选择==</option>
            <?php foreach($orgs as $k => $v){ ?>
            <option value="<?=$v['id'];?>" <?=(isset($data['org_id']) && $data['org_id'] == $v['id']) ? 'selected' : ''; ?><?=!empty($org)&&$org==$v['id']?'selected':''?>><?=$v['name'];?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      
      <div class="noticekatebox" style="width:800px;height:58px;">
        <div class="addpwordn">LOGO图标：</div>
        <div  class="addfile"  style="width:600px;height:58px;">
          <input name="data[img_url]" id="img" type="hidden" value="<?=isset($data['img_url']) ? $data['img_url'] : ''; ?>"/>
          <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=img&defaultvalue=<?php echo empty($data['img_url']) ? '' : $data['img_url']?>&allowed_extensions=gif|jpg|png&overwrite=false&encrypt_name=false" width="400px" height="54px;"></iframe>
        </div>
      </div>
     <div class="noticekatebox">
        <div class="addpwordn">是否启用：</div>
        <div style="width:500px" class="maddness">
          <select style="padding:6px;" name="data[enabled]">
            <option value="">==请选择==</option>
            <option value="y" <?=(isset($data['enabled']) && $data['enabled']=='y')?"selected=''":""?>>启用</option>
            <option value="n" <?=(isset($data['enabled']) && $data['enabled']=='n')?"selected=''":""?>>禁用</option>
          </select>

          <span class="must_star">&nbsp;*</span>
        </div>
      </div>
      <div class="basebutbox">
       <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
       <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
     </div>
    </div>

  </div>

  
</form>










