<link type="text/css" href="/resource/css/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/css/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/css/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/css/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script language="javascript" src="/resource/js/ui.base.min.js"></script>
<script language="javascript" src="/resource/js/ui.tabs.min.js"></script>
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<script src="/resource/colorbox/jquery.colorbox.js"></script>
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
                    "title"   : {required:true},
                    'plan_id' : {required:true},
                    'content' : {required:true}
                   
                  },
          messages: {
                    "title"  : {required:"请填写标题"},
                    "plan_id": {required:"请选择章节"},
                    "content": {required:"请填写内容"}
                   
                  }
      });
  });
  
  
   $(document).ready(function(){
        $(".iframe").colorbox({iframe:true, innerWidth:502, innerHeight:440});
        $(".callbacks").colorbox({
            onOpen:function(){ alert('onOpen: colorbox is about to open'); },
            onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
            onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
            onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
            onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
        });
				
				
        $("#click").click(function(){ 
            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
            return false;
        });
    });
      
    $(document).ready(function(){
	
        $("#resousdata>tr:odd,#ediaresousdata>tr:odd").addClass('layodd');
        $("#resousdata>tr:even,#ediaresousdata>tr:even").addClass('layeven');
    });
    
    function get_shuju()
    {
        var title   = $('#title').val();
        var plan_id = $('#plan_id').val();
        var content = $('#content').val();
        var sttr = $('#class').val();
        if(title=='' || plan_id=='' || content=='')
            {
                alert('内容没有填完整，请检查后再提交');
                $('#tijiao').removeAttr('class');
                return false;
            }
            if(!$('#tijiao').attr('class'))
                {
                    $('#tijiao').addClass(sttr);
                }
        $('#tijiao').attr('href','/study_question/my_tiwen?title='+title+'&plan_id='+plan_id+'&content='+content);
    }
</script>

<!--管理信息-->
                <div class="noticesbox">
                <div class="noticewarp tea-cont">
                    
                <div class="noticetit tearch-nav">
                  <h2>在线答疑 > 我的问题 &gt; 提问&nbsp;</h2>                  
                  </div>
                    
                    <div class="noticenwarp" style="height:560px;">
                    	  <input id="class" type="hidden" value="iframe cboxElement" />                     
                        <form action="/study_question/my_tiwen" method="post" id="dataform">
                        	<div class="noticekatebox">
                              <div class="addpword">标题：</div>
                                <div class="addptit"><input name="title" type="text" id ="title" value=""/></div>
                                <div class="addpnotw">50字以内</div>
                            </div>
                            
                       	  <div class="noticekatebox">
                            <div class="addpwordn">关联章节：</div>
                            <div class="addfile">
                              <label>
                                <select name="plan_id" id="plan_id">
                                    <option value="">--请选择章节--</option>
                                    <?php foreach($plan as $key=>$val){?>
                                    <option value="<?=$val['id']?>"><?=$val['title']?></option>
                                    <?php }?>
                                </select>
                              </label>
                            </div>
                       	  </div>
                        	<div class="noticekatebox" style="height:284px;">
                              <div class="addpwordn">问题：</div>
                                <div class="addpease"><textarea name="content" id="content"></textarea></div>
                          </div>
                            
                            <div class="noticekatebox" id="sendbut" style="margin-top:10px; width:708px;">
                                <div class="addbutdel"><input type="reset" class="addbut" value="取消" /></div>                        
                                <div class="addbutin"> <a href="javascript:;" onclick="return get_shuju();" class="iframe" id="tijiao"><input type="submit"  class="addbut" value="提问" /></a></div>
                
                            </div>
                        
                        </form>
                    </div>
                    
                </div>
            </div>

            <!--管理信息 end-->