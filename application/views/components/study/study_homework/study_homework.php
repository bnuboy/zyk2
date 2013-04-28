<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<script>
    function deleteItems( )
    {
        if( $("#resousdata input[type=checkbox]:checked").length == 0 ){
            alert( "请至少选择一条记录" );
            return;
        }
        if ( !confirm( "你确定要删除吗？" ) )
            return;

        var post_str = $("#resousdata input[type=checkbox]").serialize();
        $.post("/study_homework/delete/", post_str , function(ret){
            if ( ret.status == "ok" ) {
                alert("删除成功");
                location.reload();
            } else {
                alert(ret.data);
            }
        },"json");
    }
    function select_all()
    {
        if( $("#select_all:checked").length == 0 ){
            $("#resousdata input[type=checkbox]").attr("checked",false);
        }else{
            $("#resousdata input[type=checkbox]").attr("checked","checked");
        }
    }
   
</script>
<!--管理信息-->
      <div class="noticesbox">
    	<div class="noticewarp">
        	
            <div class="noticetit">
            	<h1>作业管理</h1>
            </div>
            
            <div class="noticenwarp">
            	
                <div class="noticekatebox">
                	
                    <div class="dataediabox">
                    	<div class="ediacheck"><input type="checkbox" id="select_all" onClick="select_all();"/></div>
                        <div class="ediacheckw">全选</div>
                        <div class="datadel"><a href="javascript:;" title="删除" onClick="deleteItems();">删除</a></div>
                        <div class="dataadd"><a href="/study_homework/select_type" title="新建作业">新建作业</a></div>
                        <div class="dataadd"><a href="/study_homework/piyue" title="批阅作业">批阅作业</a></div>
                    </div>
                    
                     
                    <form action="/study_homework/index" method="get" id="search_form">
                        <div class="serchbox">
                            <div class="serchninput"><input type="text" name="name" value="" onclick="search_input(this)" /></div>
                            <div class="serchbut"><input type="submit" id="serchadd" value="搜索" /></div>
                        </div>
                    </form>
                </div>
                
                <div class="databox">
                	<table width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="36">&nbsp;</th>
                                <th width="181">标题</th>
                                <th width="91">开始日期</th>
                                <th width="91">截止日期</th>
                                <th width="69">类型</th>
                                <th width="67">提交数量</th>
                                <th width="65">答题情况</th>
                                <th width="73" style='display:none;'>操作</th>
                            </tr>
                        </thead>
                        <tbody id="resousdata">
                            <?php foreach($list as $key=>$val){?>
                            <tr>
                                <td><input type="checkbox" name="item_id[]" value="<?=$val['id']?>"/></td>
                                <td><a href="/study_homework/see_zuoye/<?=$val['type_id']?>/<?=$val['id']?>"><?=$val['title']?></a></td>
                                <td><?=$val['start_time']?></td>
                                <td><?=$val['end_time']?></td>
                                <td><?=$WORK_TYPE[$val['type_id']]?></td>
                                <td><?=$val['ceshi_count']?>/<?=$val['stu_count']['student_count']?></td>
                                <td><span class="dataedia"><a href="/study_homework/tongji/<?=$val['id']?>">查看</a></span></td>
                                <td style='display:none;'>修改<span class="dataedia" style="display: none;"><a href="/study_homework/edit/<?=$val['id']?>" title="修改">修改</a></span>
                                    <a href="/study_homework/test/<?=$val['type_id']?>/<?=$val['id']?>" title="查看">答题</a>
                                </td>
                            </tr>
                         <?php }?>
           
                        </tbody>                
                    </table>
                </div>               
            </div>
            
        </div>
    </div>

            <!--管理信息 end-->