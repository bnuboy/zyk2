<script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<link rel="stylesheet" href="/resource/css/jquery-ui.css">
<script>
    $(function(){
        $( "#start_time" ).datepicker({ dateFormat: 'yy-mm-dd',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
        $( "#end_time" ).datepicker({ dateFormat: 'yy-mm-dd',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'] });
    })
</script>
<div class="noticewarp">

    <div class="noticetit tearch-nav tearch-navts">
        <h1><?=$student[ 'name' ] ?> <span><?= $class[ 'name' ] ?></span></h1>
    </div>

    <div class="noticenwarp">
        <div class="scTit">
            <div class="scHti"><a href="/study_portfolio/cartogram/<?= $student[ 'id' ]; ?>">登陆记录</a></div>
            <div><a href="/study_portfolio/learninglog/<?= $student[ 'id' ]; ?>">学习日志</a></div>
            <div><a href="/study_portfolio/jobcount/<?= $student[ 'id' ]; ?>">作业</a></div>
        </div>
        <div class="databox databoxs" style="width:730px">
            <form action="/study_portfolio/cartogram/<?= $student[ 'id' ] ?>" action="get" id="search_form" >
                <div class="scTitle">
                    <strong>起始时间：</strong>
                    <input type="text" onchange="submitSearch()" name="start_time" id="start_time" value="<?= isset( $get[ 'start_time' ] ) ? $get[ 'start_time' ] : "" ?>">
                    to
                    <input type="text" onchange="submitSearch()" name="end_time" id="end_time" value="<?= isset( $get[ 'end_time' ] ) ? $get[ 'end_time' ] : "" ?>" >
                    登记次数：<?= $count ?>次　　登陆时间：<?= $timecount[ 'timecount' ] ?>分钟
                </div>
            </form>
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="203">用户名</th>
                        <th width="167">登陆时间</th>
                        <th width="164">退出时间</th>
                        <th width="194">在线时长</th>
                    </tr>
                </thead>
                <tbody id="resousdatas">
                    <?php
                    foreach ( $log as $val )
                    {
                    ?>
                        <tr>
                            <td><a href=""><?= $student[ 'name' ]; ?></a></td>
                            <td><?= $val[ "login_time" ]; ?></td>
                            <td><?= isset($val[ "out_time" ])? $val[ 'out_time']:"未记录" ?></td>
                            <td><?= empty($val[ "timer" ])?'0':$val[ "timer" ] ?>分钟</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>