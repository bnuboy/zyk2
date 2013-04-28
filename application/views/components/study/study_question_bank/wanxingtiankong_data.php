<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<script>
var count=1;
 function addsubject()
 {
     //返回 object HTMLDivelement 对象
       var container=document.getElementById("title");  
       
	//TODO remove all empty <br>
	var img=document.createElement("img");
	img.setAttribute("src","/resource/images/test.jpg");
	img.setAttribute("id","id"+count);
	container.appendChild(img);

	var tm = document.getElementById("tmxx");
	$('#tmxx').append("<tr id='tmxx_"+count+"'><td class='addptits addptits2'><span>"+count+"</span>. A<input name='timu["+count+"][]' type='text'/></td><td class='addptits addptits2'>B<input name='timu["+count+"][]' type='text'/></td>\n\
<td class='addptits addptits2'>C<input name='timu["+count+"][]' type='text'/></td><td class='addptits addptits2'>D<input name='timu["+count+"][]' type='text'/><a href='javascript:;' onClick='delete_sub("+count+")'>删除</a></td>\n\
</tr>");
    $('#answer_id').append("<dl id='select_"+count+"' style='float:left'><span>"+count+"</span>.<select id='daan_"+count+"' name='daan["+count+"]'><option value=0>A</option><option value=1>B</option><option value=2>C</option><option value=3>D</option></select></dl>")
	count++;
 }
 
 function delete_sub(id)
 {
     
//delete tr
     var a=document.getElementById("tmxx_"+id);
     a.parentNode.removeChild(a);
//delete img in editable div.
$('#id'+id).remove();
$('#select_'+id).remove();
$.each($('#tmxx tr'),function(key,obj){
    $(obj).find('span').text(key+1);
})
$.each($("#answer_id dl"),function(key,obj){
    $(obj).find('span').text(key+1);
})
     //var b=document.getElementById("id"+id);
    // b.parentNode.removeChild(b);
 }
function check()
{
    var sttr = $('#title').html();
    $('#sttr').val(sttr);
}
    </script>
<!--管理信息-->
<div class="noticesbox" id="child_5" >
    <div class="noticewarp">

        <div class="noticetit">
            <h1>新建题目</h1>
        </div>

        <div class="noticenwarp">
            <form action="/study_question_bank/wanxingtiankong" method="post" onsubmit="return check();" enctype="multipart/form-data" >
                <input type="hidden" name="title" value="" id="sttr">
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
                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">题干：</div>
                    <div class="addpease">
                        <div contenteditable="true" style="width: 500px; height: 200px; 
                             background: none repeat scroll 0% 0% white; border: 1px solid black; text-align: left ! important;" id="title" name="title"></div>                      
                    </div>
                </div>
                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutin addbutin2">
                        <a href="javascript:;" onClick="return addsubject()">
                        <input type="button" class="addbut" value="添加填空选项" />
                        </a>
                    </div>
                </div>
                <div class="noticekatebox" style="height:auto;">
                    <div class="addpword" >题目：</div>
                    <table id="tmxx">
                       
                    </table>
                    
                </div>
               
                <div class="noticekatebox">
                    <div class="addpwordn">答案：</div>
                    <div class="scselect" id="answer_id" style="width: 600px;">                      
                    </div>                   
                </div>

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">解答过程：</div>
                    <div class="addpease"><textarea name="jieda"></textarea></div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset"  class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
                </div>

            </form>               
        </div>

    </div>
</div>

<!--管理信息 end-->