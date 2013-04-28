<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<script>
    var abc_alias = <?= json_encode( $data ); ?>;
    var count=1;
    function addSubject()
    {
        //返回 object HTMLDivelement 对象
        var container=document.getElementById("title");  
       
        //TODO remove all empty <br>
       // var img=document.createElement("img");
        //img.setAttribute("src","/resource/images/test.jpg");
       // img.setAttribute("id","id"+count);
       // container.appendChild(img);

        var t=document.getElementById("answer_id");
        t.innerHTML=t.innerHTML.concat('<dl id="cat_'+count+'"><span >'+count+'</span>.<input type="text" name="daan['+count+']" ><a href="javascript:;" onClick="return delete_item_adjust('+count+')">删除</a></br></dl>');
       // $('#answer_id').append("<lable id='select_"+count+"'><span>"+count+"</span>.<select id='daan_"+count+"' name='daan[]'><option value=0>A</option><option value=1>B</option><option value=2>C</option><option value=3>D</option></select></lable>")
        count++;
    }
     
    function addcontent()
    {
        count = $('#title').find('span').length;
        if(count==0)
        {
            count=1;
        }else{
            count+=1;
        }
        $('#title').append("<span id='"+count+"'contentedittable=true>___</span>");
        $('#daan').append('<span id="cat_'+count+'">'+count+'.<input type="text" name="daan[]" ><a href="javascript:;" onClick="return delete_item_adjust(this)">删除</a></br></span>');
    }
            
    function delete_item_adjust( id ){           
        //delete tr      
        $('#cat_'+id).remove();
        $('#id'+id).remove();
        $.each($('#answer_id dl'),function(key,obj){
            $(obj).find('span').text(key+1);
        });
    }
    function check()
    {
        var sttr = $('#title').html();
        $('#sttr').val(sttr);
    }
    
    var num=1;
	var numString = num.toString();
        function Onclick(){
        	 document.getElementById('title').focus();
             insertHtmlAtCaret("<img src='/resource/images/test.jpg' id='id"+num+"'>");
			 num++;
		}

       function insertHtmlAtCaret(html) {
            var sel, range;
            if (window.getSelection) {
				
            // IE9 and non-IE
           	 	sel = window.getSelection();
            if (sel.getRangeAt && sel.rangeCount) {
            	range = sel.getRangeAt(0);
            	range.deleteContents();
            // Range.createContextualFragment() would be useful here but is
            // non-standard and not supported in all browsers (IE9, for one)
           		 var el = document.createElement("div");
           		 el.innerHTML = html;
            	var frag = document.createDocumentFragment(), node, lastNode;
          		 while ( (node = el.firstChild) ) {
            		lastNode = frag.appendChild(node);
            	}
            	range.insertNode(frag);
				// Preserve the selection
				if (lastNode) {
					range = range.cloneRange();
					range.setStartAfter(lastNode);
					range.collapse(true);
					sel.removeAllRanges();
					sel.addRange(range);
				}
            }
            } else if (document.selection && document.selection.type != "Control") {
            // IE < 9
            document.selection.createRange().pasteHTML(html);
            }
            }
</script>
<!--管理信息-->
<div class="noticesbox" id="child_6">
    <div class="noticewarp">

        <div class="noticetit">
            <h1>新建题目</h1>
        </div>
        <div class="noticenwarp">
            <form action="/study_question_bank/tiankong" method="post" onSubmit="return check();" enctype="multipart/form-data" >
                <input type="hidden" name="title" value="" id="sttr" />
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
                            <?php }?>>
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
                    <div class="addpease">
                        <div contenteditable="true" style="width: 537px; height: 200px; 
                             background: none repeat scroll 0% 0% white; border: 1px solid #c4cfe1; border-radius:3px; text-align: left ! important;" id="title" name="title">
                            
                        </div> 
                    </div>
                </div>
                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutin addbutin2" style="margin-top: 20px;">
                        <a href="javascript:;" onClick="Onclick();return addSubject();">
                        <input type="button" class="addbut" value="添加填空选项" />
                        </a>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">答案：</div>
                    <div class="addfile" style="width:580px;height: auto;" id="answer_id">
                        
                    </div>
                </div>                            

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">解答过程：</div>
                    <div class="addpease"><textarea name="jieda"></textarea></div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset" class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
                </div>

            </form>               
        </div>

    </div>
</div>

<!--管理信息 end-->