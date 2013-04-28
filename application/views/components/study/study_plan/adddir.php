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
                var group_id=$('#group_id').val();
                var groupname=$('#groupname').val();
                if(group_id =='id'){
                        parent.getgroup(groupname);
                        parent.$('.iframe').colorbox.close();
                }else{
                      parent.rename(groupname,group_id);
                      parent.$('.iframe').colorbox.close();
                }
            }
        </script>
    </head>
    <body>
        <div class="pop">
            <div class="popTit">
                <span class="floatL"><?= empty( $group_id) ? '创建小组' : "修改"?></span>
            </div>
                <input name="group_id" id="group_id" type="hidden" value="<?= empty( $group_id ) ? 'id' : $group_id ?>"/>
                <div class="popCont popContts">
                    <ul>
                        <li><strong>小组名称</strong></li>
                        <li><input name="data[groupname]" id="groupname" type="text" value="" /></li>
                    </ul>
                </div>
                <div class="popDown">
                    <div class="dataadd"><a onclick="file_form()" title="创建"><?= empty(  $group_id ) ? '创建' : "保存"?></a></div>
                </div>
        </div>
    </body>
</html>

