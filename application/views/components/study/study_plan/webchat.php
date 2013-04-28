<link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/webchat/ajax.js"></script>
<div class="exchange">
    <div class="Etop"><img src="../images/group.gif" width="16" height="16" /> 课堂交流学习区</div>
    <div class="Emain">
        <div class="Em-left">
            <div class="Eml_text" id="chat"><ul></ul></div>
            <div class="Eml-submit">
                <textarea name="" cols="" rows="" id="intext" ></textarea>
                <input type="hidden" id="plan_id" value="<?=$id?>" />
                <p align="right">
                    <span style="float:left">输入200字符以内的信息</span>
                    <input type="button" onclick="javascript:history.go(-1)" value="返回" />
                    <input  onclick="writechart()" type="button" value="发送" />
                </p>
            </div>
        </div>
        <div class="Em-right">
            <div class="Emrinfor">
                <h3>简介</h3>
                <p><?=$plan_info['content']?></p>
            </div>
            <div class="Emr_people">
                <h2>参与人数<em id="count"></em></h2>
                <div id="user">
                   
                </div>
            </div>
        </div>
    </div>
</div>