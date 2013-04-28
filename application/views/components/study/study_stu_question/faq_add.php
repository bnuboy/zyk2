<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
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
                    "title": {required:true},
                    'plan_id':{required:true},
                    "content": {required:true}
                  },
          messages: {
                    "title": {required:"请填写标题"},
                    'plan_id':{required:'请选择关联章节'},
                    "content": {required:"请填写内容"}
                  }
      });
  });
</script>


<!--管理信息-->
<div class="noticesbox kecheng">
    <div class="noticewarp">

        <div class="noticetit tearch-nav tearch-navts">
            <h1>常见问题 -> 添加常见问题</h1>
            <div><a href="/study_question/faq_question">返回</a></div>
        </div>

        <div class="noticenwarp">
            <form action="/study_question/faq_addup" method="post" id="dataform" name="dataform">
                <div class="noticekatebox">
                    <div class="addpword">标题：</div>
                    <div class="addptit"><input name="title" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">关联章节：</div>
                    <div class="scselect">
                        <select id="plan_id" name="plan_id">
                            <option value="">--选择章节--</option>
                            <?php foreach ($list as $key => $val) {?>
                                <option value="<?=$val['id']?>"><?=$val['title']?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>					
                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">问题：</div>
                    <div class="addpease"><textarea name="content"></textarea></div>
                </div>		
                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">问答：</div>
                    <div class="addpease"><textarea name="reply"></textarea></div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset"  class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="submit"  class="addbut" value="提交" /></div>
                </div>

            </form>               
        </div>

    </div>
</div>
<!--管理信息 end-->
