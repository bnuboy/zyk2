<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<script>

    function get_sub()
    {
        if($('#name').val()=='')
        {
            alert('请填写名称');
            return false; 
        }
        if($('#typeid').val()=='')
        {
            alert('请选择类型');
            return false;
        }     
    }
    
    function win_close(){
        parent.$('.iframe').colorbox.close();      
    }
</script>
<!--管理信息-->
<div class="noticesbox" style="width: 484px;padding-bottom: 0;" >
    <div class="noticewarp" style="width: 484px;" >

        <div class="noticetit tearch-nav tearch-navts" style="width: 484px;">
            <h1>题型管理 -> 新建题型</h1>
        </div>

        <div class="noticenwarp" style="width: 484px;min-height:100px; padding-bottom: 25px;">
            <form action="/study_pattern/add" method="post" onSubmit="return get_sub();" name="dataform" id="dataform">
                <div class="noticekatebox" style="width: 454px;">
                    <div class="addpword">题型：</div>
                    <div class="maddness" ><input name="name" type="text" style="width: 350px;" id="name"/></div>
                </div>

                <div class="noticekatebox" style="width: 456px;">
                    <div class="addpwordn">基本类型：</div>
                    <div class="scselect">
                        <select name="patternType_id" id="typeid">
                            <option value="">---选择类型---</option>
                            <?php foreach ( $pattern_type as $key => $val )
                            { ?>
                                <option value="<?= $val[ 'id' ] ?>"><?= $val[ 'name' ] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;width: auto;" >
                    <div class="addbutdel" style="margin-right: 160px;"><input type="reset" class="addbut" value="取消" onClick="return win_close();"/></div>
                    <div class="addbutin"><input type="submit" class="addbut" value="确定" /></div>
                </div>

            </form>               
        </div>

    </div>
</div>
<!--管理信息 end-->
<!--中间内容 end-->