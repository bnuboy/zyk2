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
                    "pattern_id": {required:true},
                    'zsd'       : {required:true},
                    'harder'    : {required:true},
                    'title'     : {required:true},
                    'daan'      : {required:true}
                  },
          messages: {
                    "pattern_id": {required:"请选择题型"},
                    'zsd'       : {required:'请选择知识点'},
                    'harder'    : {required:'请选择难度系数'},
                    'title'     : {required:'请填写题干'},
                    'daan'      : {required:'请填写答案'}
                  }
      });
  });
</script>
<!--管理信息-->
<div class="noticesbox" id="child_3" >
    <div class="noticewarp">

        <div class="noticetit">
            <h1>编辑问答题目</h1>
        </div>

        <div class="noticenwarp">
            <form action="/study_question_bank/edit_wenda/<?=$patterntype_id?>/<?=$info['id']?>" method="post" id="dataform">
                <div class="noticekatebox">
                    <div class="addpword">题型：</div>
                    <div class="scselect">
                        <select name="pattern_id" id="pattern_id" >
                            <?php foreach ( $pattern as $key => $val )
                            { ?>
                                <option value="<?=$val[ 'id' ] ?>" <?=isset($info['tixing_id'] )&& $info['tixing_id'] ==$val['id'] ? 'selected' : ''?>><?=$val[ 'name' ] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">知识点：</div>
                    <div class="scselect">
                        <select name="zsd">
                           <option value="">请选择知识点</option>
                            <?php foreach($zsd as $key=>$val){?>
                            <option value="<?=$val['id']?>" <?=isset($info['zsd_id']) && $info['zsd_id'] = $val['id'] ? 'selected' :''?>><?=$val['title']?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">难度：</div>
                    <div class="scselect">
                       <select name="harder">
                           <option value="1" <?=isset($info['harder']) && $info['harder']==1 ? 'selected' : ''?>>0.1</option>
                            <option value="2" <?=isset($info['harder']) && $info['harder']==2 ? 'selected' : ''?>>0.2</option>
                            <option value="3" <?=isset($info['harder']) && $info['harder']==3 ? 'selected' : ''?>>0.3</option>
                            <option value="4" <?=isset($info['harder']) && $info['harder']==4 ? 'selected' : ''?>>0.4</option>
                            <option value="5" <?=isset($info['harder']) && $info['harder']==5 ? 'selected' : ''?>>0.5</option>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">题目：</div>
                    <div class="addpease"><textarea name="title"><?=$info['title']?></textarea></div>
                </div>
                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">答案：</div>
                    <div class="addpease"><textarea name="daan"><?=$info['daan']?></textarea></div>
                </div>

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">解答过程：</div>
                    <div class="addpease"><textarea name="jieda"><?=$info['jieda']?></textarea></div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset"  class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="submit"  class="addbut" value="保存" /></div>
                </div>

            </form>               
        </div>

    </div>
</div>

<!--管理信息 end-->