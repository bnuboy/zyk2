<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>  
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
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
                    "name": {required:true}
                   
                  },
          messages: {
                    "name": {required:"请填写标题"}
                  
                  }
      });
  });
</script>
<!--管理信息-->
                        <div class="noticesbox" >
                <div class="noticewarp tea-cont" >
                    
                <div class="noticetit tearch-nav tearch-navts" >
                  <h2>班级管理->添加班级</h2> 
                 
                  </div>
                    
                    <div class="" style="height:560px;" >
                    	                       
                        <form action="/study_class_manage/add_class" method="post" name="dataform" id="dataform">
                        	<div class="noticekatebox" >
                              <div class="addpword">标题：</div>
                                <div class="addptits" style="width: 380px;"><input name="name" type="text"/></div>
                                
                            </div>
                   
                            <div class="noticekatebox" id="sendbut" style="margin-top:10px; width:424px;">
                                
                                <div class="addbutdel" style="margin-right:0"><input type="reset"  class="addbut" value="取消" onclick="location.href='/study_class_manage/index'"/></div>                                <div class="addbutin"><input type="submit" class="addbut" value="提交" /></div>
                              
                            </div>
                        
                        </form>
                    </div>
                    
                </div>
            </div>

            <!--管理信息 end-->