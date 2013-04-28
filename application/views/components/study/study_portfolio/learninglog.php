<div class="noticewarp">

    <div class="noticetit tearch-nav tearch-navts">
        <h1><?=$student["name"];?> <span><?=$class['name']?></span></h1>
        <div><a class="blue" onclick="javascript:history.go(-1)" href="#">返回</a></div>
    </div>

    <div class="noticenwarp">
        <div class="scTit">
            <div ><a href="/study_portfolio/cartogram/<?= $student["id"]; ?>">登陆记录</a></div>
            <div class="scHti"><a href="/study_portfolio/learninglog/<?= $student["id"];  ?>">学习日志</a></div>
            <div><a href="/study_portfolio/jobcount/<?= $student["id"];  ?>">作业</a></div>
        </div>
        <div class="databox databoxs" style="width:730px">
            <div class="scTitle">
						学习次数：<?= $study_count ?>次　　学习时长：<?= $study_time ?>分钟
            </div>
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="450">章节</th>
                        <th width="123">学习次数</th>
                        <th width="155">学习时长</th>
                    </tr>
                </thead>
                <tbody id="resousdatas">
                    <?php
                    foreach ( $list as $value )
                    {
                    ?>
                        <tr>
                            <td><?= $value[ 'content' ][ 'title' ] ?></td>
                            <td><?= $value[ 'read_num' ] ?></td>
                            <td><?= $value[ 'study_time' ] ?>分钟</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>