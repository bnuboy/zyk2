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
        <script>
            function uploadfile(){
                $("#sub").submit();
            }
        </script>
    </head>
    <body>
       <div class="pop" style="width:773px; min-height: 218px;">
            <div class="popTit">
                <span class="floatL">上传</span>
            </div>
            <form action="/study_teachinfo/upfile/<?=$cid?>"  enctype="multipart/form-data" method="post" id="sub">
                <div class="popCont popContts">
                    <ul>
                        <li><strong>请选择上传文件</strong></li>
                        <li style="padding-bottom: 20px;">
                           <input id="param" name="param" type="hidden" value=""/>
                           <input id="fileinfoid" name="allparam" type="hidden" value=""/>
                           <iframe style="border:0px;padding-bottom: 20px;" src="/Uploadfiles/uploadfileform?fileid=param&allowed_extensions=jpg|gif|remvb|flv|rm|mp4|doc|xls&overwrite=TRUE&encrypt_name=TRUE&fileinfoid=fileinfoid&uppath=<?=!empty($dir)? $dir['upload_url']:"/upload/teach_file/"?>" width="724px" height="50px;">
                           </iframe>
                        </li>
                    </ul>
                </div>
                <div class="popDown">
                    <div class="dataadd"><a href="#this" onclick="uploadfile()" title="上传">上传</a></div>
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
