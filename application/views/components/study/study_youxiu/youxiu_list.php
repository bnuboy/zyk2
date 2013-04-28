<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>

<!--管理信息-->
<div class="noticesbox">
    <div class="noticewarp tea-cont">    
        <div class="noticetit tearch-nav">
            <h2>作文测试 > 优秀作业&nbsp;</h2>      
        </div>

        <div class="noticenwarp">
            <div class="noticekatebox">
                <div class="dataediabox">
                    <div class="notiness">  共有<span><?= $count ?></span>条优秀作业</div>

                </div>
                <form action="/study_youxiu/index" method="get" id="search_form">
                <div class="serchbox">
                    <div class="serchninput"><input type="text" name="name" value="" onclick="search_input(this)" /></div>
                    <div class="serchbut"><input type="submit" id="serchadd" value="搜索" /></div>
                </div>
                </form>
            </div>

            <div class="databox">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th colspan="2" width="100">标题</th>
                            <th width="">提交时间</th>
                            <th width="60">评分</th>
                        </tr>
                    </thead>
                    <tbody id="resousdata">
                        <?php foreach ( $list as $key => $val )
                        { ?>
                            <tr>
                                <td colspan="2"><a href="/study_youxiu/test/<?=$val['type_id']?>/<?=$val['shijuan_id']?>"><?= $val[ 'title' ] ?></a></td>
                                <td ><?= $val[ 'created' ] ?></td>
                                <td ><?= $val[ 'pingfen' ] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>                
                </table>
            </div>

            <div class="noticekatebox">

                <div class="datapkate">
                    <div class="datajump">                                  
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<!--管理信息 end-->