<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script>
    function collect_count(obj,id)
    {
        $.post('/study_question/get_collect/'+obj+'/'+id,function(ret){
            if(ret.status=='ok')
            {
                $('#collect').text('收藏：'+ret.data['collect_count']);
            }
        },'json');
    }
    function guanbi()
    {
        parent.$('.iframe').colorbox.close();
    }
</script>
<title>高等职业教育教学资源中心--个人中心</title>
</head>
<!--管理信息-->
<body>
<div class="noticesbox">
    <div class="noticewarp">
        <div class="noticetit tearch-nav tearch-navts">
            <h1>查看问题</h1>
           
        </div>

        <div class="noticenwarp">
            <form action="/study_question/reply/<?=$info['id']?>" method="post">
            <div class="mailwrap mailwraps">                        	
                <div class="mailkact">
                    <div class="floatL" style="font-weight: bold;">提问人：<?= $info['username'] ?><span>浏览：<?= $info['browse_count'] ?></span><span>回答：<?= $answer_count ?></span><span id="collect">收藏：<?= $info['collect_count'] ?></span></div>
                    <div class="floatR"><a href="javascript:collect_count('add',<?= $info['id'] ?>);"><img src="/resource/images/report_add.png">收藏</a><a href="#"><img src="/resource/images/table_edit.png">编辑</a><a href="/study_question/delete_one/<?= $info['id'] ?>"><img src="/resource/images/del.gif">删除</a></div>
                </div>
                <div class="wenda">
                    <?= $info['content'] ?>
                </div>
                <div class="floatR"><?=$info['qtime']?></div>
            </div>
            <?php foreach ($results as $key => $val) { ?>
                <div class="mailwrap mailwraps">                        	
                    <div class="mailkact">
                        <div class="floatL"><?=$val['username']?>:</div>
                    </div>
                    <div class="wenda">
                       <?=$val['reply']?>
                    </div>
                    <div class="floatR"><?=$val['atime']?></div>
               
            </div> <?php } ?>
           
            <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
               
                <div class="addbutdel addbutdel2"><input type="reset"  class="addbut" value="返回" onClick="return guanbi();"/></div>
            </div>
            </form>
        </div>

    </div>
</div>
<!--管理信息 end-->
</body>
</html>