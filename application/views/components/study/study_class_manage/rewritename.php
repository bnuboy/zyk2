<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script src="/resource/colorbox/jquery.colorbox.js"></script>
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
                    "name": {required:"请填写班级名称"}
                  
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
</script>

<!--管理信息-->
<div class="noticesbox kecheng">
    <div class="noticewarp">
        <div class="noticetit tearch-nav tearch-navts">
            <h1>班级管理->重命名</h1>
            <div></div>
        </div>
        <div class="noticenwarp">
            <form action="/study_class_manage/rewritename/<?=$id?>" method="post"  name="dataform" id="dataform">
                <div class="databox databoxs" style="width:730px">
                    <table width="100%" cellpadding="0" cellspacing="0">                      
                        <tbody id="resousdata">
                            <?php foreach ( $list as $key => $val )
                            { ?>
                                <tr>
                                    <td>班级名称：<input type="hidden" name="id" value="<?= $val[ 'id' ] ?>" /></td>
                            <input type="hidden" name="id" value="<?= $val[ 'id' ] ?>" />
                            <td><input type="text" name="name" value="<?= $val[ 'name' ] ?>" id="class_name"/></td>
                            </tr>
                            <?php } ?>                   
                        </tbody>                
                    </table>
                </div>
                <div class="noticekatebox" id="sendbut" style="margin-top:10px; width:708px;">
                    <div class="addbutdel"><input type="reset"  class="addbut" value="取消" onclick="location.href='/study_class_manage/index'"/></div>                        
                    <div class="addbutin"><input type="submit" class="addbut" value="提交" /></div>
                </div>
            </form>
        </div>

    </div>
</div>
<!--管理信息 end-->