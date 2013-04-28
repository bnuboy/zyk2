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
                    alert('收藏成功');
                }
        },'json')
        //location.href ='/study_question/get_collect/'+obj+'/'+id;
    }
</script>
<!--管理信息-->
<div class="noticesbox">
    <div class="noticewarp">
        <div class="noticetit tearch-nav tearch-navts">
            <h1>回复</h1>
            <div><a href="/study_question/">返回</a></div>
        </div>

        <div class="noticenwarp">

            <div class="mailwrap mailwraps">                        	
                <div class="mailkact">
                    <div class="floatL" style="font-weight: bold;">提问人：<?= $info[ 'username' ] ?><span>浏览：<?=$info['browse_count']?></span><span>回答：<?=$answer_count?></span><span>收藏：<?=$collect_count?></span></div>
                    <div class="floatR"><a href="javascript:collect_count('add',<?=$info['id']?>);"><img src="images/report_add.png">收藏</a><a href="#"><img src="images/table_edit.png">编辑</a><a href="/study_question/delete_one/<?=$info['id']?>"><img src="images/del.gif">删除</a></div>
                </div>
                <div class="wenda">
								萨拉肯德基阿斯科利的拉萨的
                </div>
            </div>
            <div class="mailwrap mailwraps">                        	
                <div class="mailkact">
                    <div class="floatL">提问人：<a href="#">王丹</a><span>浏览：13</span><span>回答：13</span><span>收藏：13</span></div>
                    <div class="floatR"><a href="#"><img src="images/report_add.png">收藏</a><a href="#"><img src="images/table_edit.png">编辑</a><a href="#"><img src="images/del.gif">删除</a></div>
                </div>
                <div class="wenda">
								萨拉肯德基阿斯科利的拉萨的
                </div>

            </div>
            <div class="maildataword maildatawords"><textarea name="word">快速回复给&lt;teacher0091&gt;</textarea></div>

            <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                <div class="addbutin"><input type="button" name="send" class="addbut" value="回答问题" /></div>
                <div class="addbutdel addbutdel2"><input type="reset" name="reset" class="addbut" value="取消" /></div>
            </div>
        </div>

    </div>
</div>
<!--管理信息 end-->