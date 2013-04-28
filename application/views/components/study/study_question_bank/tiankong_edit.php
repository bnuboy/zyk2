<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<script>
   
    var count=1;
    function addSubject()
    {
        //返回 object HTMLDivelement 对象
        var container=document.getElementById("title");  
       
        //TODO remove all empty <br>
        var img=document.createElement("img");
        img.setAttribute("src","/resource/images/test.jpg");
        img.setAttribute("id","id"+count);
        container.appendChild(img);

        var t=document.getElementById("answer_id");
        t.innerHTML=t.innerHTML.concat('<lable id="cat_'+count+'"><span >'+count+'</span>.<input type="text" name="daan[]" ><a href="javascript:;" onClick="return delete_item_adjust('+count+')">删除</a></br></lable>');
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
        $.each($('#answer_id lable'),function(key,obj){
            $(obj).find('span').text(key+1);
        });
    }
    function check()
    {
        var sttr = $('#title').html();
        $('#sttr').val(sttr);
    }
</script>
<!--管理信息-->
<div class="noticesbox" id="child_6">
    <div class="noticewarp">

        <div class="noticetit">
            <h1>编辑填空题</h1>
        </div>
        <div class="noticenwarp">
            <form action="/study_question_bank/edit_tiankong/<?=$patterntype_id?>/<?=$info['id']?>" method="post" onSubmit="return check();" >
                <input type="hidden" name="title" value="" id="sttr" />
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
                    <div class="addpease">
                        <div contenteditable="true" style="width: 500px; height: 200px; 
                             background: none repeat scroll 0% 0% white; border: 1px solid black; text-align: left ! important;" id="title" name="title">
                               <?=unserialize($info['title'])?>                        
                        </div> 
                    </div>
                </div>
                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutin addbutin2" style="margin-top: 10px;">
                        <a href="javascript:;" onClick="return addSubject()">
                        <input type="button" class="addbut" value="添加填空选项" />
                        </a>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">答案：</div>
                    <div class="addfile" style="width:580px;height: auto;" id="answer_id">
                        <?php foreach(unserialize($info['daan']) as $key=>$val){?>
                        <lable id="cat_<?=$key+1?>"><span ><?=$key+1?></span>.<input type="text" name="daan[]" value="<?=$val?>" >
                                <a href="javascript:;" onClick="return delete_item_adjust(<?=$key+1?>)">删除</a></br></lable>
                        <?php }?>
                    </div>
                </div>                            

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">解答过程：</div>
                    <div class="addpease"><textarea name="jieda"><?=$info['jieda']?></textarea></div>
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