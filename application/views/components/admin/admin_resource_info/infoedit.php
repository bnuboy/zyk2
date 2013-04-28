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
              "data[library_id]": {required:true},
              "data[cat_id]": {required:true},
              "data[author]": {required:true},
              "data[copyright]": {required:true},
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
              "data[copyright]": {required: "请填写版权"},
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
<form action="/admin_resource_info/infoedit" method="post" id="sub_form">
  <input type="hidden" id="id" name="data[id]" value="<?=empty($data['id']) ? '' : $data['id'] ?>" />
  <div class="noticewarp">

    <div class="noticetit">
      <h1>新增资源</h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox">
        <div class="addpword" >名称：</div>
        <div class="addptit" style="width:600px;">
          <input name="data[name]" type="text" value="<?=isset($data['name']) ? $data['name'] : '' ;  ?>"/>
        </div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn" style="margin-bottom:10px;">资源库：</div>
        <div class="addfile" style="width:210px">
          <select name="data[library_id]" style="padding:6px;" onchange="resource_cat_select_checkbox(this.options[this.selectedIndex].value);">
            <option value="">==请选择==</option>
            <?php foreach($librarys as $k => $v){ ?>
            <option value="<?=$v['id'];?>" <?=(isset($data['library_id']) && $data['library_id'] == $v['id']) ? 'selected' : ''; ?>><?=$v['name'];?></option>
            <?php } ?>
          </select>
        </div>
      </div>


      <div class="noticekatebox">
        <div class="addpwordn">资源分类：</div>
        <div class="addptit" style="width:600px; line-height:30px;">
          <div id="resource_cat_select_checkbox"></div>
        </div>
      </div>
      <div class="noticekatebox">
        <div class="addpwordn" style=" width:80px;">作者：</div>
        <div class="maddness" style=" width:260px;">
          <input name='data[author]' type="text"  value="<?=isset($data['author']) ? $data['author'] : '' ;  ?>"/>
          <span class="must_star" >*</span>
        </div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn" style=" width:80px;">版权：</div>
        <div class="maddness" style=" width:260px;">
          <input name='data[copyright]' type="text"  value="<?=isset($data['copyright']) ? $data['copyright'] : '' ;  ?>"/>
          <span class="must_star" >*</span>
        </div>

        <div class="addpwordn" style=" width:80px;">语言：</div>
        <div class="maddness" style=" width:260px;">
            <div style="padding-top:6px" class="maddness">
          <label><input type="radio" value="中文" name="data[language]" style="width:30px;height:12px;"  <?=!isset($data['language'])?"checked=''":""?> <?=isset($data['language']) &&$data['language']=='中文' ? "checked=''" : '' ;  ?>><span style="font-size:14px">中文</span></label>
          &nbsp;<label><input type="radio" value="英文" name="data[language]" style="width:30px;height:12px;" <?=isset($data['language']) &&$data['language']=='英文' ? "checked=''" : '' ;  ?> ><span style="font-size:14px">英文</span></label>
        </div>
        </div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn" style=" width:80px;">下载次数：</div>
        <div class="maddness"  style=" width:260px;"><input name='data[download]' type="text"  value="<?=isset($data['download']) ? $data['download'] : '' ;  ?>"/></div>

        <div class="addpwordn" style=" width:80px;">点击次数：</div>
        <div class="maddness" style=" width:260px;"><input name="data[view]" type="text" value="<?=isset($data['view']) ? $data['view'] : '' ;  ?>"/></div>
      </div>



      <div class="noticekatebox">
        <div class="addpwordn" style=" width:80px;">适用对象：</div>
        <div class="addfile" style=" width:287px;">
          <input name="data[target]" type="text" value="<?=isset($data['target']) ? $data['target'] : '' ;  ?>"/>
          <span class="must_star" >*</span>
        </div>

        <div class="reswordw">来源：</div>
        <div class="maddness" style=" width:260px;" >
          <input name="data[resource_source]" type="text" value="<?=isset($data['resource_source']) ? $data['resource_source'] : '' ;  ?>"/>
          <span class="must_star" >*</span>
        </div>
      </div>

      <div class="noticekatebox">
        <div class="addpwordn" style=" width:80px;">关键词：</div>
        <div class="addfile" style="width:287px;">
          <input name="data[meta_keywords]" type="text" value="<?=isset($data['meta_keywords']) ? $data['meta_keywords'] : '' ;  ?>"/>
        </div>

        <div class="reswordw">状态：</div>
        <div class="maddness" style=" width:260px;">
          <select style="padding:6px;" name="data[status]" >
            <option value="">==请选择==</option>
            <option value="wait" <?=(isset($data['status']) && $data['status'] == 'wait') ? 'selected' : ''; ?>>未审核</option>
            <option value="succeed" <?=(isset($data['status']) && $data['status'] == 'succeed') ? 'selected' : ''; ?>>已发布</option>
            <!--<option value="fail" <?=(isset($data['status']) && $data['status'] == 'fail') ? 'selected' : ''; ?>>审核失败</option>-->
          </select>
        </div>
      </div>

      <div class="noticekatebox" style="width:800px;">
        <div class="addpwordn" style=" width:80px;">缩略图：</div>
        <div  class="addfile"  style="width:600px;">
          <input name="data[img]" id="img" type="hidden" value="<?=isset($data['img']) ? $data['img'] : ''; ?>"/>
          <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=img&defaultvalue=<?php echo empty($data['img']) ? '' : $data['img']?>&allowed_extensions=gif|jpg|sql&overwrite=false&encrypt_name=false" width="450px" height="54px;" frameBorder="no" style="border:0px;" scrolling="no"></iframe>
        </div>
      </div>

      <div class="noticekatebox" style="width:800px;height:58px;">
        <div class="addpwordn" style=" width:80px;">源文件：</div>
        <div  class="addfile" style="width:600px;height:58px;">
          <input name="data[file_path]" id="file_path_input" type="hidden" value="<?=isset($data['file_path']) ? $data['file_path'] : '' ;  ?>"/>
          <input name="filepathinfo" id="filepathinfo" type="hidden" value=""/>
          <iframe src="/Uploadfiles/uploadfileform?fileid=file_path_input&defaultvalue=<?php echo empty($data['file_path']) ? '' : $data['file_path']?>&fileinfoid=filepathinfo&allowed_extensions=flv|swf|gif|7z|zip|rar|jpg|png|xls|xlsx|doc|docx|ppt|pptx|pdf|mp3|mp4|avi|rm|rmvb|mov|mp4|m4a|3gp|wma|wmv&overwrite=false&encrypt_name=true&chagetoswf=true&chagetoflv=true" width="450px" height="54px;"  scrolling="no" frameBorder="no" style="border:0px;"></iframe>
        </div>
      </div>

      <div style="height:95px;" class="noticekatebox">
        <div class="addpwordn" style=" width:80px;">简介：</div>
        <div class="resease"><textarea name="data[description]"><?=isset($data['description']) ? $data['description'] : '' ;  ?></textarea></div>

      </div>
      <div class="basebutbox">
       <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1);" class="addbut" value="取消" /></div>
       <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
      </div>
    </div>

  </div>

  
</form>

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