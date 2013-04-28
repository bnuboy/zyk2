<script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<link rel="stylesheet" href="/resource/css/jquery-ui.css">
<script>
  $(function(){
    $( "#start_time" ).datepicker({ dateFormat: 'yy-mm-dd 00:00:00',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
    $( "#end_time" ).datepicker({ dateFormat: 'yy-mm-dd 00:00:00',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'] });
  })
</script>
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
              "data[library_id]": {required:true},
              "data[cat_id]": {required:true},
              "data[author]": {required:true},
              "data[author_address]": {required:true},
              "data[copyright]": {required:true},
              "data[language]": {required:true},
              "data[target]": {required:true},
              "data[resource_source]": {required:true},
              "data[meta_keywords]": {required:true},
              "data[status]": {required:true},
              "data[img]": {required:true},
              "data[file_path]": {required:true},
              "data[description]": {required:true}
          },
          messages: {
              "data[name]": {required : "请填写名称"},
              "data[library_id]": {required : "请选择资源库"},
              "data[cat_id]": {required : "请选择资源分类"},
              "data[author]": {required: "请填写作者"},
              "data[author_address]": {required: "请填写联系方式"},
              "data[copyright]": {required: "请填写版权"},
              "data[language]": {required: "请填写语言"},
              "data[target]": {required: "请填写适用对象"},
              "data[resource_source]": {required: "请填写来源"},
              "data[meta_keywords]": {required: "请填写关键词"},
              "data[status]": {required: "请选择状态"},
              "data[img]": {required: "请选择缩略图"},
              "data[file_path]": {required: "请选择源文件"},
              "data[description]": {required: "请填写简介"}
          }
      });
  });
</script>
<div class="noticewarp">

  <div class="noticetit">
    <h1><img src="/resource/images/resour.gif" />上传资源-<?php echo !empty($data['id'])?"编辑":"新增"; ?></h1>
  </div>

  <div class="noticenwarp" style="height:670px;">



  <form action="/study_teachinfo/resourcestore_add/" method="post" id="sub_form" >
    <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
    <input type="hidden" id="user_id" name="data[user_id]" value="<?=empty($this->user['id']) ? '' : $this->user['id'] ?>" />

    <div class="resourkate">
      <div class="addpword">名称：</div>
      <div class="addptit">
        <input name="data[name]" type="text" value="<?=isset($data['name']) ? $data['name'] : '' ;  ?>"/>
        <input id="resource_store_id" type="hidden" value=""/>
      </div>
      <div class="addpnotw"><span class="must_star">*</span></div>
    </div>

      <div class="noticekatebox">
        <div class="addpwordn">所属资源库：</div>
        <div class="addfile" style="width:600px">
          <select name="data[library_id]" style="padding:6px;" onchange="resource_cat_select_checkbox(this.options[this.selectedIndex].value);">
            <option value="">==请选择==</option>
            <?php foreach($librarys as $k => $v){ ?>
            <option value="<?=$v['id'];?>" <?=(isset($data['library_id']) && $data['library_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="resourkate">
        <div class="addpwordn" style="margin-bottom:10px;">资源分类：</div>
        <div id="addfile" class="zyfl">
         <div id="resource_cat_select_checkbox"></div>
        </div>
      </div>

    <div class="resourkate">
      <div class="addpwordn">适用对象：</div>
      <div class="addfile">
        <input name="data[target]" type="text" value="<?=isset($data['target']) ? $data['target'] : '' ;  ?>"/>
      </div>
      <div class="addpnotw"><span class="must_star">*</span></div>
      <div class="reswordw">语言：</div>
      <div class="addfile">
        <input name="data[language]" type="text" value="<?=isset($data['language']) ? $data['language'] : '' ;  ?>"/>
      </div>
      <div class="addpnotw"><span class="must_star">*</span></div>
    </div>

    <div class="resourkate">
      <div class="addpwordn">作者：</div>
      <div class="addfile">
        <input name="data[author]" type="text" value="<?=isset($data['author']) ? $data['author'] : '' ;  ?>"/>
      </div>
      <div class="addpnotw"><span class="must_star">*</span></div>
      <div class="reswordw">版权：</div>
      <div class="addfile">
        <input name="data[copyright]" type="text" value="<?=isset($data['copyright']) ? $data['copyright'] : '' ;  ?>"/>
      </div>
      <div class="addpnotw"><span class="must_star">*</span></div>
    </div>

    <div class="resourkate">
      <div class="addpwordn">作者联系方式：</div>
      <div class="addfile">
        <input name="data[author_address]" type="text" value="<?=isset($data['author_address']) ? $data['author_address'] : '' ;  ?>"/>
      </div>
      <div class="addpnotw"><span class="must_star">*</span></div>
      <div class="reswordw">关键词：</div>
      <div class="addfile">
        <input name="data[meta_keywords]" type="text" value="<?=isset($data['meta_keywords']) ? $data['meta_keywords'] : '' ;  ?>"/>
      </div>
      <div class="addpnotw"><span class="must_star">*</span></div>
    </div>

    <div class="resourkate">
      <div class="addpwordn">来源：</div>
      <div class="addfile">
        <input name="data[resource_source]" type="text" value="<?=isset($data['resource_source']) ? $data['resource_source'] : '' ;  ?>"/>
      </div>
      <div class="addpnotw"><span class="must_star">*</span></div>
    </div>

      <div class="noticekatebox" style="width:800px;height:58px;">
        <div class="addpwordn">缩略图：</div>
        <div  class="addfile"  style="width:600px;height:58px;">
          <input name="data[img]" id="img" type="hidden" value="<?=isset($data['img']) ? $data['img'] : ''; ?>"/>
          <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=img&defaultvalue=<?php echo empty($data['img']) ? '' : $data['img']?>&allowed_extensions=gif|jpg|sql&overwrite=false&encrypt_name=false" width="490px" height="54px;"></iframe>
        </div>
      </div>

      <div class="noticekatebox" style="width:800px;height:58px;">
        <div class="addpwordn">源文件：</div>
        <div  class="addfile" style="width:600px;height:58px;">
          <input name="data[file_path]" id="file_path_input" type="hidden" value="<?=isset($data['file_path']) ? $data['file_path'] : '' ;  ?>"/>
          <input name="filepathinfo" id="filepathinfo" type="hidden" value=""/>
          <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=file_path_input&defaultvalue=<?php echo empty($data['file_path']) ? '' : $data['file_path']?>&fileinfoid=filepathinfo&allowed_extensions=gif|jpg|png|xls|xlsx|doc|docx|pdf|mp3|mp4|avi|rm|rmvb|mov|mp4|m4a|3gp|wma&overwrite=false&encrypt_name=true&chagetoswf=true&chagetoflv=true" width="450px" height="54px;"></iframe>
        </div>
      </div>

    <div class="resourkate" style="height:95px;">
      <div class="addpwordn">简介：</div>
      <div class="resease">
        <textarea name="data[description]"><?=isset($data['description']) ? $data['description'] : '' ;  ?></textarea>
      </div>
    </div>
    <div class="resourkate" id="sendbut" style="margin-top:10px; width:705px;">
      <div class="addbutdel"><input type="button" onclick="location.href='/study_teachinfo/resourcestore'" class="addbut" value="取消" /></div>
      <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
    </div>
  </form>



  </div>

</div>

<script>
    function resource_cat_select_checkbox(library_id){
        var strurl     = '/common/resource_cat_select_checkbox';
        var inputid    = 'cat_id';
        var inputname  = 'data[cat_id]';
        var defaultval = "<?=isset($data['cat_id']) ? $data['cat_id'] : '' ;  ?>";
        $.post(strurl, {library_id:library_id,inputid:inputid,inputname:inputname,defaultval:defaultval}, function(data){
            $('#resource_cat_select_checkbox').html(data);
        });
    }
    resource_cat_select_checkbox(<?=isset($data['library_id']) ? $data['library_id'] : '' ;  ?>);
</script>