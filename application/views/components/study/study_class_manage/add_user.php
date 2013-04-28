<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" href="/resource/css/center.css" rel="stylesheet" />
        <link type="text/css" href="/resource/css/center_data.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
        <link type="text/css" href="/resource/css/webcss.css" rel="stylesheet" />

        <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>   
        <script >
            function check()
            {
                if($('#course_part_id').val()==''){
                    alert('选择角色不能为空');
                    return false;
                }
            }
            function hite()
            {
                parent.$('.iframe').colorbox.close();
            }
        </script>
        <title>高等职业教育教学资源中心</title>
    </head>

   <body>
        <div class="Stc w400" style="width: 500px; border: 1px solid #C3D0E1; background: none repeat scroll 0 0 #F2F4F7;">
            <div class="Stc-top" style=" background: url(../../../../../resource/images/pagetitbg.jpg) repeat-x"><h1 style="padding-left:10px;">导入用户</h1></div>
            <p>&nbsp;</p>
            <div class="Stc-bottom zcjg">
                <form action="/study_class_manage/insert_user/<?=$id?>" method="post" onSubmit="return check();">
                    <table width="100%">
                        <tr>
                            <td width="15%" align="right">选择角色：</td>
                            <td>
                                <label>
                                    <select name="part_id" class="p5" id="course_part_id">
                                        <option value="">--选择角色--</option>
                                        <?php foreach ( $part as $key => $val )
                                        { ?>
                                            <option value="<?= $val[ 'id' ] ?>" ><?= $val[ 'name' ] ?></option>
<?php } ?>
                                    </select>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td nowrap="nowrap" width="15%" align="right">填写用户：</td>
                            <td width="25">
                                <label>
                                    <textarea name="users" id="textarea" cols="35" rows="5" style="width:360px;"></textarea>
                                </label>
                                <br /><span style="color:red; font-weight: bold"> * 用户名之间用 , 分隔开</span>
                            </td>
                        </tr>
                    </table>
                    <br />

                    <p align="right" style="padding-right:50px;">
                         <input type="submit" class="save" value="添加" />
                        <input type="reset" class="remove"  value="取消" onclick="hite();"/> 
                       
                    </p> 
                </form>
            </div>
        </div>
    </body>
</html>

