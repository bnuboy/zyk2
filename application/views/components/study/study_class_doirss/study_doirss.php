<script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<link rel="stylesheet" href="/resource/css/jquery-ui.css">
<script>
    $(function(){
        $( "#start_time" ).datepicker({ dateFormat: 'yy-mm-dd',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
        $( "#end_time" ).datepicker({ dateFormat: 'yy-mm-dd',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'] });
    })
</script>
<div class="noticewarp tea-cont">

  <div class="noticetit tearch-nav"><h2>学习档案 &gt; 登录记录</h2></div>

    <div class="noticenwarp">
        <form action="/study_class_doirss" action="get">
            <div class="noticekatebox">
                <b>起始时间：</b>
                <input name="start_time" id="start_time" type="text"  value="<?= isset( $get[ 'start_time' ] ) ? $get[ 'start_time' ] : "" ?>"/>
                to
                <input name="end_time" id="end_time"  type="text"  value="<?= isset( $get[ 'end_time' ] ) ? $get[ 'end_time' ] : "" ?>"/>
                <input type="submit"  id="serchadd" value="统计" />
                登录次数：<?= $count ?>次     登录时间：<?=$timecount['timecount']?>分钟 
            </div>
        </form>

        <div class="databox">
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th >用户名</th>
                        <th >登录时间</th>
                        <th >退出时间</th>
                        <th width="80">在线时长</th>
                    </tr>
                </thead>
                <tbody id="resousdata">
                    <?php foreach ( $list as $value )
                    { ?>
                        <tr>
                            <td><?= $user['name'];?> </td>
                            <td><?= $value['login_time'];?></td>
                            <td><?= $value['out_time'];?></td>
                            <td><?= isset($value['timer'])?$value['timer']:0;?>分钟</td>
                        </tr>
<?php } ?>
                </tbody>
            </table>
        </div>

        <div class="noticekatebox">
<?= $pagination ?>

        </div>

    </div>

</div>
</div>