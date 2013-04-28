<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<div class="noticewarp">
    <div class="noticetit tearch-nav tearch-navts">
        <h1>作品</h1>
        <div></div>
    </div>
    <div class="noticenwarp">
        <div class="noticekatebox" style="width:730px;padding-right:0;">
            <div class="dataediabox">
            </div>
            <form id="search_form" action="/study_plan/productlist/<?=$id?>/" onsubmit="return checkSearch(this);"  method="get">
            <div class="serchbox">
                <div class="serchninput"><input type="text"  value="<?= isset( $get[ 'name' ] ) ? $get[ 'name' ] . '" repeat_search = "1' : '请输入标题' ?>" onclick="search_input(this)" name="name"/></div>
                <div class="serchbut"><input type="submit" id="serchadd" value="搜索" /></div>
            </div>
           </form>
        </div>
        <div class="databox databoxs" style="width:730px">
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="226">上传者</th>
                        <th width="65">作品标题</th>
                        <th width="65">上传时间</th>
                        <th width="164">学生互评</th>
                        <th width="74">教师评分</th>
                        <th width="92">总分</th>
                        <th width="92">状态</th>
                        <th width="92">操作</th>
                    </tr>
                </thead>
                <tbody id="resousdatas">
                    <?php foreach ( $list as $value )
                    { ?>
                        <tr>
                            <td><?=$value['username']['name']?></td>
                            <td><a href=""><?= $value[ 'name' ] ?></a></td>
                            <td><?= $value[ 'up_time' ] ?></td>
                            <td><?= empty($value[ 'stuscore'])?"0":$value[ 'stuscore']?></td>
                            <td><?= empty($value[ 'teascore' ])?"0":$value[ 'teascore' ] ?></td>
                            <td><?= empty( $value[ 'sumscore' ])?"0": $value[ 'sumscore' ]?></td>
                            <td><?=$value['status']=='1'?"未批阅":"批阅"?></td>
                            <td><a href="/study_plan/product_view/<?=$value['id']?>">批阅</a></td>
                        </tr>
<?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
