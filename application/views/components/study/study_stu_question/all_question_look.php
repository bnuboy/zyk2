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
                    "reply": {required:true}
                   
                  },
          messages: {
                    "reply": {required:"请填写回答内容"}
                   
                  }
      });
  });
  
  function collect_count(obj,id)
    {
        $.post('/study_stu_question/get_collect/'+obj+'/'+id,function(ret){
            if(ret.status=='ok')
            {
                alert('收藏成功');
                location.reload();
            }else{
                alert(ret.data);
                ///location.reload();
            }
        },'json');
    }
</script>

<!--管理信息-->
<div class="noticesbox">
    <div class="noticewarp">
        <div class="noticetit tearch-nav tearch-navts">
            <h1>问题汇总 -> 回复</h1>
            <div><a href="/study_stu_question/question_list/">返回</a></div>
        </div>

        <div class="noticenwarp">
            <form action="/study_stu_question/reply/<?=$info['id']?>" method="post" name="dataform" id ="dataform">
            <div class="mailwrap mailwraps">                        	
                <div class="mailkact">
                    <div class="floatL" style="font-weight: bold;">提问人：<?= $info['username'] ?><span>浏览：<?= $info['browse_count'] ?></span><span>回答：<?= $answer_count ?></span><span>收藏：<?= $collect_count ?></span></div>
                    <div class="floatR"><a href="javascript:collect_count('add',<?= $info['id'] ?>);"><img src="/resource/images/report_add.png">收藏</a><a href="#"><img src="/resource/images/table_edit.png">编辑</a><a href="/study_stu_question/delete_one/<?= $info['id'] ?>"><img src="/resource/images/del.gif">删除</a></div>
                </div>
                <div class="wenda">
                    <?= $info['content'] ?>
                </div>
                <div class="floatR"><?=$info['qtime']?></div>
            </div>
            <?php foreach ($results as $key => $val) { ?>
                <div class="mailwrap mailwraps">                        	
                    <div class="mailkact">
                        <div class="floatL"><?=$val['username']?>:</div>
                    </div>
                    <div class="wenda">
                       <?=$val['reply']?>
                    </div>
                    <div class="floatR"><?=$val['atime']?></div>
               
            </div> <?php } ?>
            <div class="maildataword maildatawords"><textarea name="reply"></textarea></div>

            <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                <div class="addbutin"><input type="submit" class="addbut" value="回答问题" /></div>
                <div class="addbutdel addbutdel2"><input type="reset"  class="addbut" value="取消" onclick="location.href='/study_stu_question/question_list'"/></div>
            </div>
            </form>
        </div>

    </div>
</div>
<!--管理信息 end-->