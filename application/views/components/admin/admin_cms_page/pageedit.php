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
              "data[subject]": {required:true},
              "data[school_org_id]": {required:true},
              "data[menu_id]": {required:true},
              "data[order]": {required:true}
          },
          messages: {
              "data[subject]": {required : "请填写名称"},
              "data[school_org_id]": {required: "请选择所属院系"},
              "data[menu_id]": {required : "请选择所属菜单"},
              "data[order]": {required: "请填写排序号"}
          }
      });
  });
</script>
<form action="/admin_cms_page/pageedit" method="post" id="sub_form">
  <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
  <div class="noticewarp">

    <div class="noticetit">
      <h1>单页管理-<?php echo !empty($data['id'])?"编辑":"新增"; ?></h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox">
        <div class="addpword" >单页名称：</div>
        <div class="addfile" style="width:600px">
          <input name="data[subject]" type="text" value="<?=isset($data['subject']) ? $data['subject'] : '' ;  ?>"/>
          <span class="must_star" >*</span>
        </div>
      </div>
      <div class="noticekatebox">
        <div class="addpword" >所属院系：</div>
        <div class="addfile" style="width:600px">
          <select name="data[school_org_id]" style="padding:6px;"  <?=$this->type=='organization'?"disabled":""?> onchange="getCmsMenus(this.options[this.selectedIndex].value);">
            <option value="">==请选择==</option>
            <?php foreach($orgs as $k => $v){ ?>
            <option value="<?=$v['id'];?>" <?=!empty($org)&&$org==$v['id']?'selected':''?> <?=(isset($data['school_org_id']) && $data['school_org_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?></option>
            <?php } ?>
          </select>
          <span class="must_star" >*</span>
        </div>
      </div>
      <div class="noticekatebox">
        <div class="addpword" >所属菜单：</div>
        <div class="addfile" style="width:600px">
          <select style="padding:6px;" name="data[menu_id]" id="menu_id">
            <option value="">==请选择==</option>
          </select>
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
      <div style="padding:40px 10px 5px 10px;font-size:14px">内容：</div>
      <div>
         <?php Util::showFck(array('id'=>'content', 'name'=>'data[content]','value'=>empty($data['content'])?'':$data['content'],'width'=>'','height'=>'','toolbar'=>''));?>
      </div>

      <div class="basebutbox">
        <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
        <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
      </div>
    </div>

  </div>

  
</form>

<script>
 /*
  * 院系下菜单 
  */
  function getCmsMenus(id,defaultid){
      var strurl = "/common/getCmsMenus";
      var whr = "`type` = 'page'";
      $.post(strurl, {id: id,defaultid:defaultid,whr:whr}, function(data){
          $("#menu_id").empty();
          $("#menu_id").append(data);
      });
  }
  getCmsMenus(<?=empty($data['school_org_id'])?'0':$data['school_org_id'];?>, <?=empty($data['menu_id'])?'0':$data['menu_id'];?>);
  
</script>