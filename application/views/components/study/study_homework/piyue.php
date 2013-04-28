<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<script>
    function enabled( id,enable_value ){
    var msg = "你确定要取消吗？";
    if( enable_value=='y' )
      var msg = "你确定要设为优秀作业吗？";
    if ( !confirm( msg ) )
      return ;
    $.post("/study_homework/enable/"+id, "enabled="+enable_value , function(ret){
      if ( ret.status == "ok" ) {
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
            	<h1 style="float:left">批阅作业</h1>
              <span style="float:right; padding-right: 10px; line-height: 35px;"><a href="/study_homework/index"><<返回</a></span>
            </div>
            
            <div class="noticenwarp">
            	 <div class="noticekatebox">
                	
                    <div class="dataediabox">
                    	<div class="ediacheck"><input type="checkbox" id="select_all" onClick="select_all();"/></div>
                        <div class="ediacheckw">全选</div>
                        <div class="datadel"><a href="#" title="删除">删除</a></div>
                        <div class="dataadd"><a href="/study_homework/select_type" title="新建作业">新建作业</a></div>
                        <div class="dataadd"><a href="/study_homework/piyue" title="批阅作业">批阅作业</a></div>
                    </div>
                    
                     
                    <div class="serchbox">
                     	<div class="serchninput"><input type="text" name="serch" value="" /></div>
                        <div class="serchbut"><input type="button" id="serchadd" value="搜索" /></div>
                    </div>
                </div>
                
                <div class="databox">
                	<table width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="54">&nbsp;</th>
                                <th width="120">姓名</th>
                                <th width="179">提交时间</th>
                                <th width="108">状态</th>
                                <th width="110">操作</th>
                                <th width="95">优秀作业</th>
                            </tr>
                        </thead>
                        <tbody id="resousdata">
                            <?php foreach($list as $key=>$val){?>
                            <tr>
                                <td><input type="checkbox" name="item_id[]" value="<?=$val['id']?>"/></td>
                                <td><?=$val['username']?></td>
                                <td><?=$val['created']?></td>
                                <td><?=$PIYUE[$val['status']]?></td>
                                <td><span class="dataedia"><a href="/study_homework/pi_work/<?=$val['id']?>" title="批阅">批阅</a></span></td>
                                <td><span class="dataedia"><?php if($val['good_work']=='n'){?>
                                        <a href="javascript:;" title="设为优秀作业" onclick="return enabled(<?=$val['id']?>,'y')">设为优秀作业</a>
                                        <?php }else{?>
                                        <a href="javascript:;" title="取消" onclick="return enabled(<?=$val['id']?>,'n')">取消</a>
                                        <?php }?>
                                    </span></td>
                            </tr>
                            <?php } ?>
                        </tbody>                
                    </table>
                </div>               
            </div>
            
        </div>
    </div>

            <!--管理信息 end-->