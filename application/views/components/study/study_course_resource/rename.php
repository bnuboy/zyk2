<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
        <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
        <title>高等职业教育教学资源中心--个人中心</title>
        <script type="text/javascript">
            function file_form(){
                $('#file_form').submit();
            }
        </script>
    </head>
    <body>
        <div class="pop">
            <div class="popTit">
                <span class="floatL">课程修改</span>
            </div>
            <form action="" method="post" id="file_form">
                <input name="data[id]" type="hidden" value="<?= empty( $data[ 'id' ] ) ? '' : $data[ 'id' ] ?>"/>
                <div class="popCont popContts">
                    <ul>
                        <li><strong>课程名称</strong></li>
                        <li><input name="data[name]" type="text" value="<?=empty( $data[ 'name' ] ) ? '' : $data[ 'name' ] ?>" /></li>
                    </ul>
                </div>
                <div class="popDown">
                    <div class="dataadd"><a onclick="file_form()" title="保存">保存</a></div>
                </div>
            </form>
        </div>

        <script language="javascript" src="/resource/js/front/jquery-1.2.4a.js"></script>
        <script language="javascript" src="/resource/js/front/ui.base.min.js"></script>
        <script language="javascript" src="/resource/js/front/ui.tabs.min.js"></script>
        <script language="javascript">
            function windowclose(){
                parent.$('.iframe').colorbox.close();
            }
        </script>
        <script language="javascript">
            $(function(){
                //直接制作Tab菜单
                $("#container > ul").tabs();
            });
        </script>
    </body>
</html>
