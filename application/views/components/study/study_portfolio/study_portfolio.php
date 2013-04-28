<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<div class="noticewarp">

    <div class="noticetit tearch-nav tearch-navts">
        <h1>学生档案</h1>
        <div></div>
    </div>

    <div class="noticenwarp">
        <div class="noticekatebox">
            <form action="/study_portfolio/index" method="get" id="search_form" onsubmit="return checkSearch(this);" >
                <div class="dataediabox">
                    <div class="datadel datadelno">
                        <select onchange="submitSearch()" name="class_id">
                            <option value="">所有班级</option>
                            <?php
                            foreach ( $class as $val )
                            {
                            ?>
                                <option value="<?= $val[ 'id' ] ?>" <?= isset( $get[ 'class_id' ] ) && $get[ 'class_id' ] == $val[ 'id' ] ? "selected=''" : "" ?>><?= $val[ 'name' ] ?></option>
<?php } ?>
                        </select>
                    </div>
                    <div class="dataadd"><a href="/study_portfolio/loadfile" title="导Excel文件">导Excel文件</a></div>
                </div>
            </form>
        </div>
        <div class="databox databoxs" style="width:730px">
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>

                        <th width="94">姓名</th>
                        <th width="84">学号</th>
                        <th width="83">学习时长</th>
                        <th width="104">作业次数</th>
                        <th width="80">自测次数</th>
                        <th width="86">提问/回答</th>
                        <th width="78">发帖/回帖</th>
                        <th width="69">操作</th>
                    </tr>
                </thead>
                <tbody id="resousdatas">
                    <?php
                            foreach ( $students as $value )
                            {
                    ?>
                                <tr>
                                    <td><a href="#"><?= $value[ 'user' ]['name'] ?></a></td>
                                    <td><?= $value[ 'user' ]['student_id'] ?></td>
                                    <td><?= isset($value[ 'time' ][ 'timecount' ])? $value['time']['timecount']:"0" ?>分钟</td>
                                    <td><?=isset($value['homework'])?$value['homework']:"0"?></td>
                                    <td><?=isset($value['counttest'])?$value['counttest']:"0"?></td>
                                    <td><?= $value[ "question_count" ] ?>/<?= $value[ "answer_count" ] ?></td>
                                    <td>12/111</td>
                                    <td><a href="/study_portfolio/cartogram/<?=$value['user']['id']?>">统计图</a></td>
<?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
