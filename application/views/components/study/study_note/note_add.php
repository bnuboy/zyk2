<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<!--管理信息-->
                        <div class="noticesbox">
                <div class="noticewarp tea-cont">
                    
                <div class="noticetit tearch-nav">
                  <h2>笔记管理 -> 新建笔记</h2> 
                  <div><a href="/study_note" class="blue">&lt;&lt;返回</a></div>
                  </div>
                    
                    <div class="noticenwarp" style="height:560px;">
                    	                       
                        <form id="dataform" name="dataform" action="/study_note/add" method="post">
                        	<div class="noticekatebox">
                              <div class="addpword">标题：</div>
                                <div class="addptit"><input name="title" type="text"/></div>
                                <div class="addpnotw">50字以内</div>
                            </div>
                            
                       	  <div class="noticekatebox">
                            <div class="addpwordn">分类：</div>
                            <div class="addfile">
                              <label>
                                <select name="note_cat_id" id="select">
                                    <option value="">---选择分类---</option>
                                    <?php foreach($cat_list as $key=>$val){?>
                                    <option value="<?=$val['id']?>"><?=$val['name']?></option>
                                  <?php } ?>
                                </select>
                              </label>
                            </div>
                       	  </div>
                        	<div class="noticekatebox" style="height:284px;">
                              <div class="addpwordn">内容：</div>
                                <div class="addpease">
                                    <textarea name="content"></textarea>
                                </div>

                          </div>
                            
                            <div class="noticekatebox" id="sendbut" style="margin-top:10px; width:708px;">
                                <div class="addbutdel"><input type="reset"  class="addbut" value="取消" /></div>                        
                              <div class="addbutin"><input type="submit" class="addbut" value="提交" /></div>
                            </div>
                        
                        </form>
                    </div>
                    
                </div>
            </div>

            <!--管理信息 end-->
            
<script>
   $().ready(function() {
      $.validator.setDefaults({
          submitHandler: function(form){
              form.submit();
          }
      });
      $("#dataform").validate({
          errorPlacement: function(error, element) { //配置错误信息输出
              error.appendTo( element.parent() );
          },
          success: function(label) {
              label.text("正确").addClass("success"); //返回值
          },
          rules: {
                    "title": {required:true},
                    'note_cat_id':{required:true},
                    "content": {required:true}
                  },
          messages: {
                    "title": {required:"请填写标题"},
                    'note_cat_id':{required:'请选择分类'},
                    "content": {required:"请填写内容"}
                  }
      });
  });
</script>
