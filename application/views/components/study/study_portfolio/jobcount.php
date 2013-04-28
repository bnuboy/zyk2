<div class="noticewarp">

    <div class="noticetit tearch-nav tearch-navts">
        <h1>演好 <span>数控一班</span></h1>
        <div><a href="#">返回</a></div>
    </div>

    <div class="noticenwarp">
        <div class="scTit">
             <div ><a href="/study_portfolio/cartogram/<?= $student["id"]; ?>">登陆记录</a></div>
            <div><a href="/study_portfolio/learninglog/<?= $student["id"];  ?>">学习日志</a></div>
            <div class="scHti"><a href="/study_portfolio/jobcount/<?= $student["id"];  ?>">作业</a></div>
        </div>
        <div class="databox databoxs" style="width:730px">
            <div class="scTitle">
						完成次数：<?=$count?>次　　　优秀次数：<?=$good_work?>次　　　平均成绩：<?=$agv?>分　　　总成绩：<?=$sum?>分
            </div>
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="333">作业标题</th>
                        <th width="131">完成时间</th>
                        <th width="132">成绩</th>
                        <th width="132">优秀作业</th>
                    </tr>
                </thead>
                <tbody id="resousdatas">
                    <?php foreach($list as $val){?>
                    <tr>
                        <td><a href="#"><?=$user['name']?></a></td>
                        <td><?=$val['created']?></td>
                        <td><?=$val['score']?></td>
                        <td><?=$val['good_work']=='n'?"优秀":""?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>