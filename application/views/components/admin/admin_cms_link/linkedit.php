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
              "data[url]": {required:true},
              "data[order]": {required:true},
              "data[school_org_id]": {required:true}             
          },
          messages: {
              "data[name]": {required : "请填写名称"},
              "data[url]": {required : "请填写链接地址"},
              "data[order]": {required: "请填写排序号"},
              "data[school_org_id]": {required: "请选择所属院系"}         
          }
      });
  });
</script>
<form action="/admin_cms_link/linkedit" method="post" id="sub_form">
  <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
  <div class="noticewarp">

    <div class="noticetit">
      <h1>友情链接管理-<?php echo !empty($data['id'])?"编辑":"新增"; ?></h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox">
        <div class="addpword" >友情链接名称：</div>
        <div class="addfile" style="width:600px">
          <input name="data[name]" type="text" value="<?=isset($data['name']) ? $data['name'] : '' ;  ?>"/>
          <span class="must_star" >*</span>
        </div>
      </div>

      
      <div class="noticekatebox">
        <div class="addpwordn">链接地址：</div>
        <div class="maddness"  style="width:400px;">
          <input name='data[url]' type="text"  value="<?=isset($data['url']) ? $data['url'] : '' ;  ?>"/>
          <span class="must_star" >*</span>
        </div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn">排序号：</div>
        <div class="maddness" style="width:400px;">
          <input name="data[order]" type="text" value="<?=isset($data['order']) ? $data['order'] : '' ;  ?>"/>
          <span class="must_star" >*</span>
        </div>
      </div>
      
      <div class="noticekatebox">
        <div class="addpwordn">所属院系：</div>
        <div class="addfile" style="width:300px">
          <select name="data[school_org_id]" style="padding:6px;" <?=$this->type=='organization'?"disabled":""?>>
            <option value="">==请选择==</option>
            <?php foreach($orgs as $k => $v){ ?>
            <option value="<?=$v['id'];?>"<?=!empty($org)&&$org==$v['id']?'selected':''?> <?=(isset($data['school_org_id']) && $data['school_org_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?></option>
            <?php } ?>
          </select>
        </div>
      </div>
       <div class="basebutbox">
        <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
        <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
      </div>
    </div>

  </div>

  
</form>










