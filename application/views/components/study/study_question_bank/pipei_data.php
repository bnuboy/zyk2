<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<script>
    var abc_arr = <?= json_encode( $data ); ?>;
    function add_subject()
    {
        var count = $('#xuanxiang tr').length;
        count +=1;
        $('#xuanxiang').append('<tr id="timu'+count+'"><td class="addptits"><span>'+count+'</span>. <input name="timu['+count+']" type="text"/></td>\n\
<td class="addptits"><span>'+abc_arr[count-1]+'</span>.<input name="xuanxiang['+count+']" type="text"/><a href="javascript:;" onclick="delete_sub('+count+')">删除</a></td></tr>');  
        $('#answer_id').append('<dl id="cat_'+count+'"style="float:left;"><span>'+count+'</span>. <select name="daan[]" id="daan_'+count+'"></select></dl>');
        $('#answer_id select option').remove(); 
        for(var i=0; i< $('#xuanxiang tr').length; i++){          
            $('#answer_id select').each(function(){              
                $(this).append('<option value="'+i+'">'+abc_arr[i]+'</option>');
            });
        }
    }
    function delete_sub(obj)
    {
        if($('#xuanxiang tr').length==1)
        {
            alert('至少有一项');
            return false;
        }
        $('#timu'+obj).remove();
        $('#cat_'+obj).remove();
        $.each($('#xuanxiang tr'),function(key,val){
            $(val).find('span:eq(0)').text(key+1);
            $(val).find('span:eq(1)').text(abc_arr[key]);      
        });
        
        $.each($('#answer_id dl'),function(key,obj){
            $(obj).find('span').text(key+1);         
        });
        $('#answer_id select option').remove(); 
        for(var i=0; i<$('#xuanxiang tr').length; i++){
             $('#answer_id select').each(function(){
                $(this).append('<option value="'+i+'">'+abc_arr[i]+'</option>');
            });
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
            <form action="/study_question_bank/pipei" method="post" >
                <div class="noticekatebox">
                    <div class="addpword">题型：</div>
                    <div class="scselect">
                        <select name="pattern_id" id="pattern_id" >
                            <?php foreach ( $pattern as $key => $val )
                            { ?>
                                <option value="<?= $val[ 'id' ] ?>"><?= $val[ 'name' ] ?></option>
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
                            <option value="<?=$val['id']?>"><?=$val['title']?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">难度：</div>
                    <div class="scselect">
                        <select name="harder">
                            <option value="1">0.1</option>
                            <option value="2">0.2</option>
                            <option value="3">0.3</option>
                            <option value="4">0.4</option>
                            <option value="5">0.5</option>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">题干：</div>
                    <div class="addptit"><input name="title" type="text" value=""/></div>
                </div>
                <div class="noticekatebox" style="height: auto">
                    <table id="xuanxiang" style="height: auto; padding-left:82px">
                        <tr id="timu1">
                            <td class="addptits"><span>1</span>. <input name="timu[1]" type="text"/></td>
                            <td class="addptits"><span>A</span>.<input name="xuanxiang[1]" type="text"/><a href="javascript:;" onclick="delete_sub(1)">删除</a></td>
                        </tr>
                    </table>
                </div>
                <div class="addptit" style=" padding-left:95px;padding-top:10px;"><a  href="javascript:;" id="add_subject" onclick="return add_subject();">
                        <img src="/resource/images/zj.gif" />&nbsp;新增选项</a></div>

                <div class="noticekatebox">
                    <div class="addpwordn">答案：</div>
                    <div class="scselect" id='answer_id' style="width: 600px;">
                        <dl id="cat_1" style="float:left;">
                            <span>1</span>.
                            <select name='daan[]' id='daan_1'>
                                <option value="0">A</option>
                            </select>
                        </dl>
                    </div>
                </div>

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">解答过程：</div>
                    <div class="addpease"><textarea name="jieda"></textarea></div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset"  class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="submit"  class="addbut" value="保存" /></div>
                </div>

            </form>  
        </div>           
    </div>

</div>
</div>

<!--管理信息 end-->