<div class="noticewarp tea-cont">

    <div class="noticetit tearch-nav">
        <h2>学习档案 &gt; 作品</h2>
    </div>

    <div class="noticenwarp">
        <div class="noticekatebox">完成次数：<?= $count ?>次      &nbsp;   平均成绩：<?=$agv?>分      &nbsp;    总成绩：<?= $sum ?>分</div>

        <div class="databox">
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th >作品标题</th>
                        <th width="100">完成时间</th>
                        <th width="60">成绩</th>
                    </tr>
                </thead>
                <tbody id="resousdata">
                    <?php foreach ( $list as $val )
                    { ?>
                        <tr>
                            <td><?= $val[ 'name' ] ?> </td>
                            <td><?= $val[ 'up_time' ] ?></td>
                            <td><?= $val[ 'sumscore' ] ?></td>
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
