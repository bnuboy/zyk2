<div class="noticewarp tea-cont">

    <div class="noticetit tearch-nav">
        <h2>学习档案 &gt; 学习记录</h2>
    </div>

    <div class="noticenwarp">
        <div class="noticekatebox">学习次数：<?=$study_count?>次   &nbsp;&nbsp;      学习时长：<?=$study_time?>分钟           </div>

        <div class="databox">
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th >章节</th>
                        <th colspan="2" width="100">学习次数</th>
                        <th width="80">学习时长</th>
                    </tr>
                </thead>
                <tbody id="resousdata">
                    <?php
                    foreach ( $list as $value )
                    {
                    ?>
                        <tr>
                            <td><?= $value[ 'content' ][ 'title' ] ?></td>
                            <td colspan="2"><?= $value[ 'read_num' ] ?></td>
                            <td><?= $value[ 'study_time' ] ?>分钟</td>
                        </tr>
<?php } ?>
                    <tr>

                </tbody>
            </table>
        </div>

        <div class="noticekatebox">
<?= $pagination ?>
        </div>

    </div>

</div>
</div>