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
                    "title": {required:true,maxlength:20},
                    "priority":{required:true}
                  },
          messages: {
                    "title": {required:"标题不能为空",maxlength:"不能超过20个字"},
                    "priority":{required:"请选择优先级"}
                  }
      });
  });
</script>
<div class="noticewarp">

    <div class="noticetit tearch-nav tearch-navts">
        <h1>发布公告</h1>
        <div><a href="/study_coursenotice">返回</a></div>
    </div>

    <div class="noticenwarp">
        <form action="/study_coursenotice/add" method="post" id="sub_form">
            <div class="noticekatebox">
                <div class="addpword">公告标题：</div>
                <div class="addptit"><input name="title" type="text" style="width:487px;" /><span class="must_star" >*</span></div>
                
            </div>

            <div class="noticekatebox">
                <div class="addpwordn">优先级：</div>
                <div class="scselect">
                    <select name="priority"  class="p5">
                        <option value="">选择优先级</option>
                        <?php
                        foreach ( $PUBLICNOTICE_LEVEL as $key => $value )
                        {
                        ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="noticekatebox" style="height:184px;">
                <div class="addpwordn">内容：</div>
                <style type="text/css">
                    .Elaber label{ display: block;}
                </style>
                <div class="addpease Elaber"><textarea name="content"></textarea><span class="must_star" >*</span></div>
            </div>

            <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                <div class="addbutdel"><input type="button" onclick="location.href='/study_coursenotice'"  class="addbut" value="取消" /></div>
                <div class="addbutin"><input type="submit" class="addbut" value="发布" /></div>
            </div>

        </form>
    </div>

</div>
</div>