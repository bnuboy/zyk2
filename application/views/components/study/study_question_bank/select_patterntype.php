<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
        <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
        <script>
            function close_win()
            {
                parent.$('.iframe').colorbox.close();
            }
            function check(id)
            {
                
                if(id){
                    var type_name = $('#type_'+id).text();                    
                    location.href='/study_question_bank/select_type/'+id+'?name='+type_name;
                   
                }
            }
        </script>
        <title>高等职业教育教学资源中心</title>
    </head>
    <body>
        <div class="Stc w400" style="width: 780px;">
            <div class="Stc-top"><h1>题库管理 -> 新建题库</h1></div>
            <div class="Stc-bottom zcjg">              
                    <table width="100%">
                        <?php foreach ( $list as $key => $val )
                        { ?>
                            <tr>
                                <td>基本类型：</td>
                                <td id="type_<?=$val[ 'id' ]?>">
                                    <input value="<?=$val['id']?>" type="hidden"/>&nbsp;
                                    <a href="/study_question_bank/select_type/<?=$val['id']?>?name=<?=$val[ 'name' ] ?>" ><font color="#0072C9"><?=$val[ 'name' ]?></font></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <br />               
            </div>
        </div>
    </body>
</html>

