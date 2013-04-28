<script type="text/javascript">
    function setScores( score ){
        var imgs = $('#scoresArea img');
        imgs.attr('src','/resource/images/starbg.jpg');
        for(i=0;i<score;i++){
            $( imgs[i] ).attr('src','/resource/images/starcf1.jpg');
        }
        $('#score').val( score );
    }
    function upProductComment(product_id){
        var contents=$('#sub_form').find('textarea[name=content]').val();
        if(contents==""){alert("评论不能为空");return;}
        $.post("/study_plan/product_comment_addup/"+ product_id,
        {score:$('#sub_form').find('input[name=score]').val(),content :contents},
        function(ret){
            if(ret.status == "ok"){
                alert("评论成功");
                location.reload();
            }else{
                alert("评论失败");
            }
        },"json");
    }
</script>
<div class="noticesbox kecheng">
    <div class="noticewarp tea-cont">
        <div class="noticetit tearch-nav">
            <h2><?= $product[ 'name' ] ?></h2>
            <div><a href="javascript:history.go(-1)">返回</a></div>
        </div>
        <form id="sub_form">
            <div class="noticenwarp">
                <div class="noticekatebox1">
                    <div class="dataediabox">
                        <div class="qyxg_k1">上传者：第一小组 &nbsp;&nbsp;&nbsp;&nbsp;上传时间：<?= $product[ 'up_time' ] ?></div>
                    </div>
                </div>
                <div class="lericon">
                    <div class="workle floatL"><img src="<?= $product[ 'demo_path' ] ?>" style="width:242px;height: 180px"/></div>
                    <div class="intrri floatL">
                        <div class="workbs"><span><b>作品描述：</b><?= $product[ 'info' ] ?></span><p><?= $product[ 'content' ] ?></p></div>
                        <p><b>附件：</b><a href="<?= $product[ 'file_path' ] ?>">下载</a></p>
                        <p class="star81" id="scoresArea">
                            <b>我的评分：</b>
                            <input type="hidden" id="score" name="score" value="3">
                            <img width="23" height="24" onclick="setScores(1)" src="/resource/images/starcf1.jpg">
                            <img width="23" height="24" onclick="setScores(2)" src="/resource/images/starcf1.jpg">
                            <img width="23" height="24" onclick="setScores(3)" src="/resource/images/starcf1.jpg">
                            <img width="23" height="24" onclick="setScores(4)" src="/resource/images/starbg.jpg">
                            <img width="23" height="24" onclick="setScores(5)" src="/resource/images/starbg.jpg">
                        </p>
                    </div>
                </div>
                <div class="warning">
                    <?php if($product_set['score_status']==1 || $user_type['part_id']=='10003'){?>
                    <span>教师评分：<?= $teascore?></span>
                    <span>学生互评：<?=$stuscore?></span>
                    <span>总评分：<?=$sumcount?></span>
                    <?php }?>
                </div>
                <div class="allcomcon">
                    <?php foreach($comment as  $val){?>
                    <div class="already">
                        <div class="alrcon floatL"><img src="<?=$val['user']['face']?>" /><p><?=$val['user']['name']?></p><p><?=$val['content']?></p></div>
                        <div class="altime floatR"><?=$val['comment_time']?></div>
                    </div>
                    <?php } ?>
                    <div class="commentcon"><textarea name="content" id="content"></textarea> </div>
                    <div class="noticekatebox" id="sendbut" style="margin-top:10px; width:708px;">
                        <div class="addbutin" style="float:left; margin-left:10px">
                            <input type="button" class="addbut" onclick="upProductComment(<?= $product[ 'id' ] ?>)" value="保存" />
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>