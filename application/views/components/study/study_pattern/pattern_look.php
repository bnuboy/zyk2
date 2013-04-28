<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<script>
    function win_close(){
        parent.$('.iframe').colorbox.close();
       
    }
</script>
<!--管理信息-->
<div class="noticesbox" style="width: 484px;padding-bottom: 0;">
    <div class="noticewarp" style="width: 484px;">

        <div class="noticetit tearch-nav tearch-navts" style="width: 484px;">
            <h1>题型管理 -> 查看题型</h1>
            
        </div>

        <div class="" style="width: 484px; height:147px;padding-bottom: 25px;">
            <form>
                
                <?php foreach($list as $key=>$val){?>
                                &nbsp;&nbsp;&nbsp;&nbsp;题目<?=$key+1?>.<?=$val['title']?><br/>
                <?php }?>
                 <div class="noticekatebox" id="sendbut" style="margin-top:10px;width: 327px; padding-left: 48px;" >
                    <div class="addbutdel"><input type="reset" class="addbut" value="返回" onClick="return win_close();"/></div>

                </div>

            </form>               
        </div>

    </div>
</div>
<!--管理信息 end-->
<!--中间内容 end-->