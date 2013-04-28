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
    function add_subject()
    {
        count = $('#timu tbody').length;
        count +=1;
        $('#timu').append("<tbody id='xuanxiang_"+count+"'><tr><td><div class='noticekatebox'><div class='addptit' style='width:580px;'><span>"+count+"</span>　<input name='tigan["+count+"]' type='text' value=''/><a href='javascript:;' onClick='return delete_item("+count+");'>删除</a></div></div></td></tr>\n\
 <tr><td><div class='noticekatebox'><div class='addfile' style='width:580px;height: auto;'>　A<input name='daan["+count+"][]' type='text'/><br/>B<input name='daan["+count+"][]' type='text'/><br/>\n\
C<input name='daan["+count+"][]' type='text'/><br/>D<input name='daan["+count+"][]' type='text'/></div></div></td></tr></tbody>");
     $("#answer_id").append("<lable id='lable"+count+"'><span>"+count+".</span><select name='answer["+count+"]' id='answer"+count+"'><option value='0'>A</option><option value='1'>B</option><option value='2'>C</option><option value='3'>D</option></select></lable>")
    }
    
    function delete_item(obj)
    {
        //var item = $(obj).parent().parent().parent().parent().parent();
        if($('#timu tbody').length ==1)
            {
                alert('最少要有个题干');
                return false;
            }
        $('#xuanxiang_'+obj).remove();
        $('#lable'+obj).remove();
        $.each($('#timu tbody'),function(key,obj){
            $(obj).find('span').text(key+1);          
        })
        $.each($('#answer_id lable'),function(key,obj){
            $(obj).find('span').text(key+1);
        })
    }
    
    
    function checktigan()
    {
//        var item =$("#timu tbody");
//        var attr =new Array();
//        $.each(item,function(key,obj){
//            attr.push(obj);
//        })
//        for(key in attr)
//            {
//                var obj = attr[key];
//               if($(obj).find('input').val()=='') {
//                   
//                   alert(key+'没写题干');
//                   return false;
//               }
//            }
       if($('#timu tbody').find('input:eq(0)').val()=='')
           {
               alert('第一题必须填写！');
               return false;
           }
        
    }
    </script>
<!--管理信息-->
<div class="noticesbox">
    <div class="noticewarp">
        <div class="noticetit">
            <h1>新建题目</h1>
        </div>
        <div class="noticenwarp">
            <form action="/study_question_bank/edit_yuedulijie/<?=$patterntype_id?>/<?=$info['id']?>" method="post" id="dataform" onSubmit="return checktigan();">
                <div class="noticekatebox">
                    <div class="addpword">题型：</div>
                    <div class="scselect">
                         <select name="pattern_id" id="pattern_id" >
                            <?php foreach ( $pattern as $key => $val )
                            { ?>
                                <option value="<?= $val[ 'id' ] ?>" <?=$info['tixing_id']==$val['id'] ? 'selected' : ''?>><?= $val[ 'name' ] ?></option>
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
                    <div class="addpword">题干：</div>
                    <div class="addptit"><input name="title" type="text" value="<?=$info['title']?>"/></div>
                </div>
                <div class="noticekatebox" style="height:auto;" >  
                
                    <table>
                        <tr>
                            <td align="right" valign="top"> <div class="addpword" style="margin-top:15px;">题目：</div></td><td>
                                <table id="timu">
                                    <?php foreach($info['timu_xuanxiang'] as $key=>$val){?>
                                    <tbody id="xuanxiang_<?=$key?>">
                                        <tr>
                                            <td>
                                                <div class="noticekatebox">
                                                    <div class="addptit" style="width:580px;">
                                                        <span><?=$key?></span>　<input name="tigan[<?=$key?>]" type="text" value="<?=$val['timu']?>"/>
                                                        <a href="javascript:;" onClick="return delete_item(<?=$key?>);">删除</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="noticekatebox" >
                                                    <div class="addfile" style="width:580px;height: auto;">　
                                                        A<input name="daan[<?=$key?>][]" type="text" value="<?=$val['xuanxiang'][0]?>"/><br/>
                                                        B<input name="daan[<?=$key?>][]" type="text" value="<?=$val['xuanxiang'][1]?>"/><br/>
                                                        C<input name="daan[<?=$key?>][]" type="text" value="<?=$val['xuanxiang'][2]?>"/><br/>
                                                        D<input name="daan[<?=$key?>][]" type="text" value="<?=$val['xuanxiang'][3]?>"/>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php }?>
                                </table>

                            </td>
                        </tr>

                    </table></div>

                <div class="noticekatebox">
                    <div class="addpword">　　　</div>
                    <div class="addptit"><a href="javascript:;" onClick="return add_subject();">
                            <img src="/resource/images/zj.gif" />&nbsp;新增题目</a></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">答案：</div>
                    <div class="scselect" id="answer_id">
                        <?php foreach(unserialize($info['daan']) as $key=>$val){?>
                        <lable id="lable<?=$key?>">
                        <span><?=$key?></span>.   <select name="answer[<?=$key?>]" id="answer<?=$key?>">
                            <option value="0" <?=$val==0 ? 'selected' : ''?>>A</option>
                            <option value="1" <?=$val==1 ? 'selected' : ''?>>B</option>
                            <option value="2" <?=$val==2 ? 'selected' : ''?>>C</option>
                            <option value="3" <?=$val==3 ? 'selected' : ''?>>D</option>
                        </select>
                     </lable>
                        <?php }?>
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