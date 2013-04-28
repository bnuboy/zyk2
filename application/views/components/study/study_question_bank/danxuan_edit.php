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
                    'title'     : {required:true}
                  },
          messages: {
                    "pattern_id": {required:"请选择题型"},
                    'zsd'       : {required:'请选择知识点'},
                    'harder'    : {required:'请选择难度系数'},
                    'title'     : {required:'请填写题干'}
                  }
      });
  });
</script>
<script>
    var abc_alias = <?=json_encode( $abc_array );?>;
    function addsubmit(){
        var count = $("#subject_id table tr td input").val().length;
        if(count ==0){
            alert('至少要有一个选项内容');
            return false;
        }
    }
    function addSubject()
    {
        var count = $("#subject_id table tr").length;
        if( count > 24)
        {
            alert('最多有26个选项');
            return;
        }
        $('#subject_id table').append( '<tr><td>\n\
        <span>'+abc_alias[count]+':</span>\n\
        <input type="text" name="subject_id[]" value="" />\n\
        <a href="javascript:;" onclick="delete_item_adjust(this)">删除</a></td></tr>' );
                $("#answer_id").append("<option value="+count+">"+abc_alias[count]+"</option>");
            }
            function delete_item_adjust( obj ){
                var count = $("#subject_id table tr ").length;
                if( count == 1 )
                {
                    alert("试题至少有一个答案");
                    return;
                }
                var item = $(obj).parent().parent();
                item.remove();
                $("#answer_id option").remove();
                $.each($("#subject_id table tr"),function(key,obj){
                    $(obj).find('span').text( abc_alias[key] + ":" );
                    $("#answer_id").append("<option value='"+key+"'>"+abc_alias[key]+"</option>");
                });
            }
</script>
<!--管理信息-->
<div class="noticesbox" id="child_1">
    <div class="noticewarp">    
        <div class="noticetit">
            <h1>编辑单选题目</h1>
        </div>

        <div class="noticenwarp">

            <form action="/study_question_bank/edit_danxuan/<?=$patterntype_id?>/<?=$info['id']?>" method="post" id="dataform" onSubmit="return addsubmit();" name="dataform">
                <div class="noticekatebox">
                    <div class="addpword">题型：</div>
                    <div class="scselect">
                        <select name="pattern_id" id="pattern_id" >
                            <?php foreach ( $pattern as $key => $val )
                            { ?>
                                <option value="<?= $val[ 'id' ] ?>" <?=isset($info['tixing_id']) && $info['tixing_id']==$val['id'] ? 'selected' : ''?>><?= $val[ 'name' ] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">知识点：</div>
                    <div class="scselect">
                        <select name="zsd" id="zsd">
                          <option value="">请选择知识点</option>
                            <?php  foreach($zsd as $key=>$val){?>
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
                    <div class="addpword">题干：</div>
                    <div class="addptit"><input name="title" type="text" value="<?=$info['title']?>"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">选项：</div>
                    <div class="addfile" style="height: auto;width:580px" id="subject_id">
                        <table>
                            <?php foreach(unserialize($info['xx'])  as $key=>$val){?>
                            <tr>
                                <td>
                                    <span><?=$abc_array[$key]?>:</span>
                                    <input type="text" name="subject_id[]" value='<?=$val?>' />     
                                    <a href="javascript:;" onclick="delete_item_adjust(this)">删除</a>
                                </td>  
                            </tr>
                            <?php } ?>
                        </table>   
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpword">　　　</div>
                    <div class="addptit"><a  href="javascript:;"id="add_subject" onclick="addSubject();"><img src="/resource/images/zj.gif" />&nbsp;新增选项</a></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">答案：</div>
                    <div class="scselect">
                        <select name="daan" id="answer_id">
                            <?php foreach(unserialize($info['xx']) as $key=>$val){?>
                            <option value="<?=$key?>" <?=isset($info['daan']) && $info['daan'] == $key ? 'selected' : ''?>><?=$abc_array[$key]?></option>
                            <?php } ?>
                        </select>
                    </div>
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
