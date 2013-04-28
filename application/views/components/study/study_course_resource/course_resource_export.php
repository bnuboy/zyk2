<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
        <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/resource/js/common.js"></script>
        <title>高等职业教育教学资源中心--个人中心</title>
        <script>
            function checkname(){
                var obj = $("#cname").val();
                if(/.*[\u4e00-\u9fa5]+.*$/.test(obj))
                {
                    alert("不能含有汉字！");
                    return false;
                }
               if(obj==""){
                   alert("导出的资源名称不能为空");
                   return false;
               }
                return true;
            }
        </script>
    </head>
    <body>
        <div class="pop">
            <div class="popTit">
                <span class="floatL">导出项目</span>
                <span class="floatR"></span>
            </div>
            <form action="/study_course_resource/exportfile" method="post" id="sub" onsubmit="return checkname()">
                <div class="popContdc">
                    <dl>
                        <dt><input type="checkbox" id="checkall" name="checkall" checked=""  disabled="true"/>基本信息</dt>
                        <dt><input  type="checkbox" value=""  checked="" disabled="true"/>课程大纲</dt>
                        <dd><input name="name" type="text" id="cname" value=""/></dd>
                        <?php foreach ( $LOAD_COURSE_FILE as $key => $value )
                        { ?>
                            <dd><input class="check" name="item_id[]" type="checkbox" value="<?= $key ?>" /><?= $value ?></dd>
                         <?php } ?>
                        <div class="clear"></div>

                        <input  type="hidden" value="<?= $course_id ?>"  name="course_id"/>
                    </dl>
                </div>
                <div class="popDown">
                    <span><a href="#this" onclick="clockwin()">取消</a></span>
                    <div class="dataadd"><a href="#this"  onclick="javascript:$('#sub').submit()" title="导出">导出</a></div>
                </div>
            </form>
        </div>
            <script type="text/javascript">
            function clockwin(){
            parent.$('.iframe').colorbox.close();
             }
        </script>
    </body>
</html>

