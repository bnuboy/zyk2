<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<div class="noticewarp">

    <div class="noticetit tearch-nav tearch-navts">
        <h1>资源库</h1>
        <div></div>
    </div>

    <div class="noticenwarp">

        <div class="noticekatebox">
            <div class="dataediabox">
                <div class="dataadd"><a href="/study_teachinfo/resourcestore_add" title="上传资源">上传资源</a></div>
            </div>
            <form id="search_form" action="/study_teachinfo/resourcestore/" onsubmit="return checkSearch();"  method="get">
                <div style="float:right">

                    <div class="notiness" style=" float:left; margin-right:3px;">
                        <select name="cat_id" class="p5" onchange="submitSearch()">
                            <option value="">选择资源分类</option>
                            <?php
                            foreach ( $cat_list as $value )
                            {
                            ?>
                                <option value="<?= $value[ "id" ] ?>"  <?= isset( $get[ 'cat_id' ] ) && $get[ 'cat_id' ] == $value['id']? 'selected' : '' ?>><?= $value[ 'tag' ] ?><?= $value[ 'name' ] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="serchninput">
                        <input type="text" value="<?= isset( $get[ 'name' ] ) ? $get[ 'name' ] . '" repeat_search = "1' : '请输入资源名称' ?>" onclick="search_input(this)" name="name">
                    </div>
                    <div class="serchbut">
                        <input type="submit" id="serchadd" value="搜索" />
                    </div>
                </div>
            </form>
        </div>





        <div class="databox databoxs" style="width:730px">
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="194">名称</th>
                        <th width="74">格式</th>
                        <th width="79">大小</th>
                        <th width="162">更新时间</th>
                        <th width="96">下载次数</th>
                        <th width="82">操作</th>
                    </tr>
                </thead>
                <tbody id="resousdatas">
                    <?php
                            foreach ( $list as $val )
                            {
                    ?>
                                <tr>
                                    <td><a href="/study_teachinfo/resourcestore_view/<?= $val[ "id" ] ?>"><?= $val[ 'name' ] ?></a></td>
                                    <td><?= $val[ 'file_type' ] ?></td>
                                    <td><?= $val[ 'file_size' ] ?></td>
                                    <td><?= $val[ 'update_time' ] ?></td>
                                    <td><?= $val[ 'download' ] ?></td>
                                    <td><a href="<?= $val[ 'file_path' ] ?>">下载</a></td>
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