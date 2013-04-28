<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" href="/resource/study/group/style/center.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/group/style/center_data.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/group/style/teacher.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/group/style/webcss.css" rel="stylesheet" />
        <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
        <title>高等职业教育教学资源中心--个人中心</title>
        <style type="text/css">
            <!--
            .guotable2{margin-left:50px;}
            .guo_gjc{ height:18px; line-height:18px; width:376px;}
            .syxs_kuai2{ margin-top:15px; overflow:hidden; padding-bottom:30px; zoom:1}
            .syxs_kuai3{ margin-left:0px; width:200px; float:left; display:inline}
            .syxs_kuai3 h2{ font-size:12px; font-weight:normal; color:#33; line-height:40px;}
            .syxs_kuai3 h2 span{ color:#F00;}
            .scorll{ width:200px; height:304px; overflow-y:scroll;}
            .syxs_yd{ width:130px; float:left;margin:80px 10px 0 10px; }
            .an_an{ display:inline;}
            .fpxs_table{ padding:10px 0 10px 30px;}
            .sx_tc{ width:152px;}
            .fpxs_submit{ padding-left:230px;margin-top:30px;}
            -->
        </style>
        <style>
            .selcted_tr{
                background:#eee;
                border-left: 1px solid #D2DCE9;
                border-top: 1px solid #D2DCE9;
                height: 30px;
                line-height: 28px;
            }        
            .group_tr{
                background:red;
                border-left: 1px solid #D2DCE9;
                border-top: 1px solid #D2DCE9;
                height: 30px;
                line-height: 28px;
            }
        </style>
        <script>
            function selected_user( obj ){
                if( $( obj ).attr( 'class' ) == 'selcted_tr' ){
                    $( obj ).attr('class','');
                }else{
                    $( obj ).attr('class','selcted_tr');
                }
            }
            function selected_group( obj ){
                if( $( obj ).attr( 'class' ) == 'group_tr' ){
                    $( obj ).attr('class','selcted_tr');
                    $('#group_id').val($(obj).next().attr('id'));
                    $.each( $("#rightresousdata").find("div"), function(key, val){
                        if(val.id!= $(obj).next().attr('id')+"div"){
                            $( "#"+val.id ).attr('class','group_tr');
                        }
                    });
                }else{
                    $( obj ).attr('class','group_tr');
                }
            }
            function user_move_to_right(){
                var id=$('#group_id').val();
                if(id==''){
                    alert('请选择分组');
                }
                var selected_tr = $('#leftresousdata tr.selcted_tr');
                if( !selected_tr )
                    return ;
                 var student='';
                 $.each( selected_tr.find('input'), function(key, val){
                      student+=$(val).val()+',';
                    });
                $("#div"+id).val(student);
                $('#'+id).append( selected_tr );
            }

            function user_move_to_left(){
                var id=$('#group_id').val();
                var selected_tr = $('#'+id+' tr.selcted_tr');
                if( !selected_tr )
                    return ;
                selected_tr.find('input').attr('name','users[]');
                $('#leftresousdata').append( selected_tr );
            }
            var i=0;
            function getgroup(obj){
                i++;
                $('#rightresousdata').append("<div onclick='selected_group(this)' id='"+i+"div' class='group_tr' >"+obj+"<input type='hidden' id='div"+i+"'></div><table width='98%' cellpadding='0'cellspacing='0' id="+i+" ></table>");
            }
            function changename(){
                var id=$('#group_id').val();
                if(id==0){
                    alert("请新建分组或选择分组");
                    $("#rename").removeClass();
                }else{
                    $("#rename").attr('class','group cboxElement');
                    $("#rename").attr('href', "/study_plan/adddir?id="+id);
                }
            }
            function rename(groupname,group_id){
                $("#"+group_id+"div").text(groupname);
            }
            function deletegroup(){
                var id=$('#group_id').val();
                if(id==0){
                    alert("请选择分组");
                }else{
                    $("#"+id+"div").remove();
                    $("#"+id).remove();
                }
            }
            function returnsub(){
                var data='';
                $.each( $("#rightresousdata").find("div"), function(key, val){
                     var group_name=$("#"+val.id).text();
                     var students= $("#"+val.id).find('input').val();
                     //  组名.学生id,学生id,:组名.学生id,学生id
                      data+=group_name+"."+students+":";
                    });
                 parent.putdata(data);
                 parent.$('.iframe').colorbox.close();
            }
        </script>
    </head>
    <body>
        <div class="Stc w600">
            <div class="Stc-top">
                <h1>作品分组</h1>
            </div>
            <div class="Stc-bottom kcnr">
                <div class="syxs_kuai2">
                    <div class="syxs_kuai3">
                        <div class="scorll">
                            <table width="98%" cellpadding="0" cellspacing="0" class="table_data">
                                <thead>
                                    <tr>
                                        <th width="232">学生列表</th>
                                    </tr>
                                </thead>
                                <tbody id="leftresousdata">
                                    <?php foreach ( $student_info as $val )
                                    {
 ?>
                                        <tr onclick="selected_user(this)">
                                            <td><input type="hidden" name="user[]" value="<?= $val[ 'id' ] ?>" /><?= $val[ 'name' ] ?></td>
                                        </tr>
<?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="syxs_yd">
                        <div class="an_an" style=" margin-top:15px;"><a title="移动" href="#this" onclick="user_move_to_right()">移动&gt;&gt;</a></div>
                        <div class="an_an" style=" margin-top:15px;"><a title="移除" href="#this" onclick="user_move_to_left()">&lt;&lt;移除</a></div>     
                    </div>


                    <div class="syxs_kuai3">
                        <div class="scorll">
                            <table width="98%" cellpadding="0" cellspacing="0" class="table_data">
                                <thead>
                                    <tr>
                                        <th width="232">小组列表</th>
                                    </tr>
                                </thead>
                                <tbody id="rightresousdata">
                                    <input type="hidden" id="group_id"/>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <p align="right" style="padding-right:20px; padding-bottom:20px;">
                    <a href="/study_plan/adddir" class="group cboxElement" >新建</a>
                    <a href="#this" onclick="changename()" id="rename" class="group cboxElement">重命名</a>
                    <a href="#this" onclick="deletegroup()">删除</a></p>
                <p align="right">
                    <input type="button" class="remove" onclick="clockwin()" value="取消" />
                    <input type="button" class="save" onclick="returnsub()"value="确定" />
                </p>
            </div>
        </div>
    </body>
</html>
<link type="text/css" href="/resource/js/front/colorbox/colorbox.css" rel="stylesheet" />
<script src="/resource/js/front/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        $(".iframe").colorbox({iframe:true, innerWidth:420, innerHeight:264});
        $(".group").colorbox({iframe:true, innerWidth:420, innerHeight:264});
        $("#click").click(function(){
            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
            return false;
        });
    });
    function clockwin(){
        parent.$('.iframe').colorbox.close();
    }
</script>