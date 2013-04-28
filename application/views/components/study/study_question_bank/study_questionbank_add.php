<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<script type="text/javascript">
  
    function check_type(obj)
    {   
        $.post('/study_question_bank/check/'+obj,function(ret){
            if(ret.status=='ok')
            {
                $.each(ret.data, function(key,val){
                    // if(val.name == ));
                    $('#select_id').val(val.id)
                    if(val.id == 2)
                    {
                        $('#child_2').css('display','block');
                        $('#child_1').css('display','none');
                    }                   
                });               
            }
        },'json');
    }
</script>
<!--管理信息-->
<div class="noticesbox" id="child_1">
    <div class="noticewarp">
        <input type="hidden" id="select_id" value='0' />
        <div class="noticetit">
            <h1>新建题目</h1>
        </div>

        <div class="noticenwarp">

            <form>
                <div class="noticekatebox">
                    <div class="addpword">题型：</div>
                    <div class="scselect">
                        <select name="pattern_id" id="pattern_id" onChange="check_type(this.value)">
                            <?php foreach ( $list as $key => $val )
                            { ?>
                                <option value="<?= $val[ 'id' ] ?>"><?= $val[ 'name' ] ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">知识点：</div>
                    <div class="scselect">
                        <select>
                            <option>学习单元一</option>
                        </select>
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">难度：</div>
                    <div class="scselect">
                        <select>
                            <option>0.1</option>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">题干：</div>
                    <div class="addptit"><input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">选项：</div>
                    <div class="addptit" style="width:580px;">A　<input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">　　　</div>
                    <div class="addptit" style="width:580px;">B　<input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">　　　</div>
                    <div class="addptit"><a href="#"><img src="images/zj.gif">&nbsp;新增选项</a></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">答案：</div>
                    <div class="scselect">
                        <select>
                            <option>A</option>
                        </select>
                    </div>
                </div>

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">解答过程：</div>
                    <div class="addpease"><textarea name="word"></textarea></div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset" name="reset" class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="button" name="send" class="addbut" value="保存" /></div>
                </div>

            </form>               
        </div>

    </div>
</div>

<!--管理信息 end-->
<!--***********************多项|||选择题************************************-->       

<!--管理信息-->
<div class="noticesbox" id="child_2" style="display: none">
    <div class="noticewarp">

        <div class="noticetit">
            <h1>新建题目</h1>
        </div>

        <div class="noticenwarp">
            <form>
                <div class="noticekatebox">
                    <div class="addpword">题型：</div>
                    <div class="scselect">
                        <select name="pattern_id" id="pattern_id" onChange="check_type(this.value)">
                            <?php foreach ( $list as $key => $val )
                            { ?>
                                <option value="<?= $val[ 'id' ] ?>" <?php $ss = "<script>$('#selected_id').val();</script>";
                            $ss == $val[ 'id' ] ? 'selected' : '' ?>><?= $val[ 'name' ] ?></option>
                                    <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">知识点：</div>
                    <div class="scselect">
                        <select>
                            <option>学习单元一</option>
                        </select>
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">难度：</div>
                    <div class="scselect">
                        <select>
                            <option>0.1</option>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">题干：</div>
                    <div class="addptit"><input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">选项：</div>
                    <div class="addptit" style="width:580px;">A　<input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">　　　</div>
                    <div class="addptit" style="width:580px;">B　<input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">　　　</div>
                    <div class="addptit"><a href="#"><img src="images/zj.gif">&nbsp;新增选项</a></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">答案：</div>
                    <div class="scselects">
                        <input name="" type="checkbox" value="" />　A　<input name="" type="checkbox" value="" />　B
                    </div>
                </div>

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">解答过程：</div>
                    <div class="addpease"><textarea name="word"></textarea></div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset" name="reset" class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="button" name="send" class="addbut" value="保存" /></div>
                </div>

            </form>               
        </div>

    </div>
</div>

<!--管理信息 end-->


<!--***********************问答|||题************************************-->   


<!--管理信息-->
<div class="noticesbox" id="child_3" style="display: none">
    <div class="noticewarp">

        <div class="noticetit">
            <h1>新建题目</h1>
        </div>

        <div class="noticenwarp">
            <form>
                <div class="noticekatebox">
                    <div class="addpword">题型：</div>
                    <div class="scselect">
                        <select>
                            <option>选择题</option>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">知识点：</div>
                    <div class="scselect">
                        <select>
                            <option>学习单元一</option>
                        </select>
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">难度：</div>
                    <div class="scselect">
                        <select>
                            <option>0.1</option>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">题目：</div>
                    <div class="addpease"><textarea name="word"></textarea></div>
                </div>
                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">答案：</div>
                    <div class="addpease"><textarea name="word"></textarea></div>
                </div>

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">解答过程：</div>
                    <div class="addpease"><textarea name="word"></textarea></div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset" name="reset" class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="button" name="send" class="addbut" value="保存" /></div>
                </div>

            </form>               
        </div>

    </div>
</div>

<!--管理信息 end-->

<!--***************************匹配题*************************************-->
<!--管理信息-->
<div class="noticesbox" id="child_4" style="display: none;">
    <div class="noticewarp">

        <div class="noticetit">
            <h1>新建题目</h1>
        </div>

        <div class="noticenwarp">
            <form>
                <div class="noticekatebox">
                    <div class="addpword">题型：</div>
                    <div class="scselect">
                        <select>
                            <option>选择题</option>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">知识点：</div>
                    <div class="scselect">
                        <select>
                            <option>学习单元一</option>
                        </select>
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">难度：</div>
                    <div class="scselect">
                        <select>
                            <option>0.1</option>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">题干：</div>
                    <div class="addptit"><input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">　　　</div>
                    <div class="addptits">1.　<input name="tit" type="text"/></div>
                    <div class="addptits">A.　<input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">　　　</div>
                    <div class="addptits">2.　<input name="tit" type="text"/></div>
                    <div class="addptits">B.　<input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">　　　</div>
                    <div class="addptits">3.　<input name="tit" type="text"/></div>
                    <div class="addptits">C.　<input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">答案：</div>
                    <div class="scselect">
                        <select>
                            <option>A</option>
                        </select>
                    </div>
                    <div class="scselect">
                        <select>
                            <option>A</option>
                        </select>
                    </div>
                    <div class="scselect">
                        <select>
                            <option>A</option>
                        </select>
                    </div>
                </div>

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">解答过程：</div>
                    <div class="addpease"><textarea name="word"></textarea></div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset" name="reset" class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="button" name="send" class="addbut" value="保存" /></div>
                </div>

            </form>               
        </div>

    </div>
</div>

<!--管理信息 end-->

<!--******************************完型填空***********************************************-->

<!--管理信息-->
<div class="noticesbox" id="child_5" style="display: none;">
    <div class="noticewarp">

        <div class="noticetit">
            <h1>新建题目</h1>
        </div>

        <div class="noticenwarp">
            <form>
                <div class="noticekatebox">
                    <div class="addpword">题型：</div>
                    <div class="scselect">
                        <select>
                            <option>选择题</option>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">知识点：</div>
                    <div class="scselect">
                        <select>
                            <option>学习单元一</option>
                        </select>
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">难度：</div>
                    <div class="scselect">
                        <select>
                            <option>0.1</option>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">题干：</div>
                    <div class="addpease"><textarea name="word"></textarea></div>
                </div>
                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutin addbutin2"><input type="button" name="send" class="addbut" value="添加填空选项" /></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">题目：</div>
                    <div class="addptits addptits2">1.　A<input name="tit" type="text"/></div>
                    <div class="addptits addptits2">B <input name="tit" type="text"/></div>
                    <div class="addptits addptits2">C <input name="tit" type="text"/></div>
                    <div class="addptits addptits2">D <input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">　　　</div>
                    <div class="addptits addptits2">2.　A <input name="tit" type="text"/></div>
                    <div class="addptits addptits2">B <input name="tit" type="text"/></div>
                    <div class="addptits addptits2">C <input name="tit" type="text"/></div>
                    <div class="addptits addptits2">D <input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">答案：</div>
                    <div class="scselect">
                        <select>
                            <option>A</option>
                        </select>
                    </div>
                    <div class="scselect">
                        <select>
                            <option>A</option>
                        </select>
                    </div>
                    <div class="scselect">
                        <select>
                            <option>A</option>
                        </select>
                    </div>
                </div>

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">解答过程：</div>
                    <div class="addpease"><textarea name="word"></textarea></div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset" name="reset" class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="button" name="send" class="addbut" value="保存" /></div>
                </div>

            </form>               
        </div>

    </div>
</div>

<!--管理信息 end-->

<!--*************************填空题**************************************-->

<!--管理信息-->
<div class="noticesbox" id="child_6" style="display: none;">
    <div class="noticewarp">

        <div class="noticetit">
            <h1>新建题目</h1>
        </div>

        <div class="noticenwarp">
            <form>
                <div class="noticekatebox">
                    <div class="addpword">题型：</div>
                    <div class="scselect">
                        <select>
                            <option>选择题</option>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">知识点：</div>
                    <div class="scselect">
                        <select>
                            <option>学习单元一</option>
                        </select>
                    </div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">难度：</div>
                    <div class="scselect">
                        <select>
                            <option>0.1</option>
                        </select>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">题干：</div>
                    <div class="addpease"><textarea name="word"></textarea></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">选项：</div>
                    <div class="addptit" style="width:580px;">A　<input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">　　　</div>
                    <div class="addptit" style="width:580px;">B　<input name="tit" type="text"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">答案：</div>
                    <div class="scselects">
                        <input name="" type="checkbox" value="" />　A　<input name="" type="checkbox" value="" />　B
                    </div>
                </div>

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">解答过程：</div>
                    <div class="addpease"><textarea name="word"></textarea></div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset" name="reset" class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="button" name="send" class="addbut" value="保存" /></div>
                </div>

            </form>               
        </div>

    </div>
</div>

<!--管理信息 end-->