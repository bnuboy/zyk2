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
              "data[menu_id]": {required:true},
              "data[img]": {required:true},
              "data[content_date]": {required:true},
              "data[school_org_id]": {required:true}
          },
          messages: {
              "data[subject]": {required : "请填写文章标题"},
              "data[menu_id]": {required : "请选择所属菜单"},
              "data[img]": {required : "请上传图片"},
              "data[content_date]": {required : "请填写发表时间"},
              "data[school_org_id]": {required : "请选择所属院系"}
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
<form action="/admin_cms_article/articleedit" method="post" id="sub_form">
  <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
  <div class="noticewarp">

    <div class="noticetit">
      <h1>文章管理-<?php echo !empty($data['id'])?"编辑":"新增"; ?></h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox" style="padding-top:30px;">
        <div class="maddpword">文章标题：</div>
        <div class="maddness" style="width:245px;">
          <input name="data[subject]" type="text" value='<?=isset($data['subject']) ? $data['subject'] : '' ;  ?>'/>
          <span class="must_star" >*</span>
        </div>
      </div>

      <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">发表时间：</div>
        <div class="maddness"><input name="data[content_date" type="text" id="start_time" value='<?=isset($data['content_date']) ? $data['content_date'] : date('Y-m-d H:i:s', time()) ;  ?>'/></div>
      </div>

      <div class="noticekatebox">
        <div class="maddpword">所属院系：</div>
        <div class="maddness" style="width:210px">
          <select name="data[school_org_id]" style="padding:6px;"  <?=$this->type=='organization'?"disabled":""?>  onchange="getCmsMenus(this.options[this.selectedIndex].value);">
            <option value="">==请选择==</option>
            <?php foreach($orgs as $k => $v){ ?>
            <option value="<?=$v['id'];?>" <?=!empty($org)&&$org==$v['id']?'selected':''?> <?=(isset($data['school_org_id']) && $data['school_org_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?></option>
            <?php } ?>
          </select>
          <span class="must_star" >*</span>
        </div>
        <div class="maddpword">所属菜单：</div>
        <div class="maddness">
          <select style="padding:6px;" name="data[menu_id]" id="menu_id">
            <option value="">==请选择==</option>
          </select>
          <span class="must_star" >*</span>
        </div>
      </div>
      
      <div class="noticekatebox" style="width:800px;height:58px;">
        <div class="maddpword">图片：</div>
        <div  class="maddness"  style="width:600px;height:58px;">
          <input name="data[img]" id="img" type="hidden" value="<?=isset($data['img']) ? $data['img'] : ''; ?>"/>
          <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=img&defaultvalue=<?php echo empty($data['img']) ? '' : $data['img']?>&allowed_extensions=gif|jpg|sql&overwrite=false&encrypt_name=false" width="400px" height="54px;"></iframe>
        </div>
      </div>

      
      <div class="noticekatebox">
        <div class="maddpword">文章简介：</div>
        <div class="maddness">
          <textarea name="data[intro]" style="width:400px;height:80px;"><?=isset($data['intro']) ? $data['intro'] : '' ;  ?></textarea>
        </div>
      </div>

      <div style="padding:40px 10px 5px 10px;font-size:14px">文章内容：</div>
      <div >
         <?php Util::showFck(array('id'=>'content', 'name'=>'data[content]','value'=>empty($data['content'])?'':$data['content'],'width'=>'','height'=>'','toolbar'=>''));?>
      </div>

    </div>
    <div class="basebutbox">
      <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
      <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
    </div>
  </div>

</form>

<script>
 /*
  * 院系下菜单 
  */
  function getCmsMenus(id,defaultid){
      var strurl = "/common/getCmsMenus";
      var whr = "`type` = 'article'";
      $.post(strurl, {id: id,defaultid:defaultid,whr:whr}, function(data){
          $("#menu_id").empty();
          $("#menu_id").append(data);
      });
  }
  getCmsMenus(<?=empty($data['school_org_id'])?'0':$data['school_org_id'];?>, <?=empty($data['menu_id'])?'0':$data['menu_id'];?>);
  
</script>