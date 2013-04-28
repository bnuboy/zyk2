<div class="noticewarp tea-cont">
    <div class="noticetit tearch-nav tearch-navts">
        <h2></h2>
        <div>
            <?= isset( $prev[ 0 ][ 'id' ] ) ? "<a href='/study_coursenotice/view/{$prev[ 0 ][ 'id' ]}'>上一条</a>" : "上一条" ?>　
            <a href="/study_coursenotice/index">返回</a>　
            <?= isset( $next[ 0 ][ 'id' ] ) ? "<a href='/study_coursenotice/view/{$next[ 0 ][ 'id' ]}'>下一条</a>" : "下一条" ?>
        </div>
    </div>
    <div class="noticenwarp">
        <div class="noticenwarp">
            <div class="centnoticetit"><h1><?= $notice[ 'title' ] ?><br/><span><?= $notice[ 'created' ] ?></span></h1></div>

            <div class="centnoticebox">
                <p><?= $notice[ 'content' ] ?></p>
            </div>

            <div class="noticekateboxts">

                <div class="datadel"><a href="javascript:deleteItem(<?= $notice[ "id" ] ?>);" title="删除">删除</a></div>
                <div class="dataadd"><a href="/study_coursenotice/edit/<?= $notice[ 'id' ] ?>" title="修改">修改</a></div>
            </div>

        </div>
    </div>
</div>
</div>