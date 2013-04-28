<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
    function timer(){
        $.get("/study_coursecontent/addtimer/<?= !empty($content) ? !empty($content) ? $content[ 'id' ]:"" :"" ?>",function(msg){})
    }
    window.setInterval("timer()",6*10000);
    
</script>


<!--管理信息-->
<div class="noticesbox">
    <div class="noticewarp">
        <div class="noticetit tearch-nav tearch-navts">
            <h2></h2>
            <div>
                <a href="<?= !empty($content) ? "/study_coursecontent/nodeadd/".$content[ 'id' ]:""  ?>"><img src="/resource/images/script_add.png">添加子节</a>
                <a href="<?= !empty($content) ? "/study_coursecontent/move/".$content[ 'id' ]."/down":"" ?>"><img src='/resource/images/arrow_down.png'>下移</a>
                <a href="<?= !empty($content) ? "/study_coursecontent/move/".$content[ 'id' ]."/up":"" ?>"><img src='/resource/images/arrow_up.png'>上移</a>
                <a href="<?= !empty($content) ? "/study_coursecontent/edit/".$content[ 'id' ]:""  ?>"><img src="/resource/images/ediapen.gif">编辑</a>　
                <a href="<?= !empty($content) ? "/study_coursecontent/delete/".$content[ 'id' ]:"" ; ?>" onclick="javascript:return confirm('您确定要删除吗?');"><img src="/resource/images/del.gif">删除</a>
            </div>
        </div>
        <div class="noticenwarp">
            <?php if(!empty($content)){?>
            <div class="centnoticetit">
                <h1 class="zj"><?= $content[ 'title' ] ?></h1>
            </div>
            <div class="centnoticebox">
                <p>
                    <?= isset( $content[ 'content' ] ) ? $content[ 'content' ] : "" ?>
                    <?php
                    if(isset($content['resource'])){
                        foreach($content['resource'] as $val){
                              if(!empty($val['swf_path'])){
                                   Util::showplayer($val['swf_path']);
                              }else if(!empty($val['file_path'])){
                                 Util::showplayer($val['file_path']);
                              }else{
                               echo "无可执行的文件";
                              }
                        }
                    }
                     ?>
                </p>
            </div>
           <?php } ?>
        </div>
    </div>
</div>
<!--管理信息 end-->




<!--中间内容 end-->