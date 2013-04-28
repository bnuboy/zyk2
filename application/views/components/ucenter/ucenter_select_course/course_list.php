<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script src="/resource/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        $(".iframe").colorbox({iframe:true, innerWidth:502, innerHeight:210});
        $(".callbacks").colorbox({
            onOpen:function(){ alert('onOpen: colorbox is about to open'); },
            onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
            onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
            onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
            onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
        });


        $("#click").click(function(){
            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
            return false;
        });
    });

    $(document).ready(function(){

        $("#resousdata>tr:odd,#ediaresousdata>tr:odd").addClass('layodd');
        $("#resousdata>tr:even,#ediaresousdata>tr:even").addClass('layeven');
    });
</script>

<div class="resourrdbox">
    <form action="/ucenter_select_course/index"  method="get">
        <div class="resourkate">
            <div class="notiness">共有课程<span><?= $count ?></span>条</div>
            <div class="" style=" float:right">
                <div class="serchninput">
                    <input type="text" value="<?= isset( $get[ 'name' ] ) ? $get[ 'name' ] : '' ?>" onclick="$('#searchname').val('')" id="searchname" name="name" />
                </div>
                <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
            </div>
    </form>
</div>

<div class="databox1" style=" padding-top:8px;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th width="193">大赛标题</th>
                <th width="234">主办单位</th>
                <th width="75">大赛类型</th>
                <th width="176">指导教师</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody id="resousdata">
            <?php foreach ( $list as $k => $v )
            { ?>
                <tr>

                    <td><a href="/ucenter_select_course/view/<?=$v['id']?>"><?= $v[ 'name' ]; ?></a></td>
                    <td><?= $v[ 'organization' ][ 'name' ]; ?></td>
                    <td><?= $v[ 'cat' ][ 'name' ]; ?></td>
                    <td>
                    <?php
                    if ( !empty( $v[ 'teachers' ] ) )
                    {
                        foreach ( $v[ 'teachers' ] as $teacher )
                        {
                            echo $teacher[ 'name' ] . "、";
                        }
                    }
                    ?>
                </td>
                <td><?php if ( !empty( $v[ 'xuanke' ] ) )
                    {
 ?>
<?= $SELECT_COURSE_STATUS[ $v[ 'xuanke' ][ 'status' ] ] ?>
            <?php }
                    else
                    { ?>
                                <a href="/ucenter_course/select_course/<?= $v[ 'id' ] ?>" class="iframe">报名参赛</a>
<?php } ?>
                        </td>
                    </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="resourkate">
<?= $pagination ?>
</div>


<div class="clear"></div>