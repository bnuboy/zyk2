<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<script>
    function tuike(param,param1)
    {
        $.post('/ucenter_course/tuike/'+param+'/'+param1,function(ret)
        {
            if(ret.status=='ok')
               {
                    alert('退赛成功');
                    location.reload();
               }
        },'json');
    }
</script>
<div class="noticewarp">

  <div class="noticetit">
    <h1 style="float: left;"><img src="/resource/images/book.gif" />我的大赛</h1>
    <!--<h1 style="float: left;padding-left: 100px;"><a href="/ucenter_course/courseedit" style='color: #1E8DD2;'>新建大赛</a></h1>-->
  </div>


    <div class="noticekatebox" id="sendbut">      
      <div class="addbutinn" style="float:right;line-height: 30px;"></div>            
      <div class="addbutin" ><a class="addbut" href="/ucenter_course/courseedit" > 新建大赛</a></div>
    </div>

    
    <div class="noticekatebox" style="display: none;">
         <div class="dataediabox">
            <div class="notiness">共有<span>426</span>门大赛</div>
         </div>
         <div class="serchbox">
            <div class="serchninput"><input type="text" name="serch" value="搜索标题" /></div>
            <div class="serchbut"><input type="button" id="serchadd" value="搜索" /></div>
         </div>
     </div>
    
    <div class="databox">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="30%">大赛名称</th>
            
            <th width="10%">大赛角色</th>
            <th width="15%">创建时间</th>
            <th width="15%">参赛状态</th>
            <th width="20%">操作</th>
          </tr>
        </thead>
        <tbody id="resousdata">
         <?php 
         foreach($list as $k => $v){ 
             $url ="#this";
             if($v['status'] == 'audit'){
                 $url = "/study/index?course_id=".$v['course_id'];
             }
         ?>
          <tr>
            <td><a href="<?=$url;?>"><?=$v['name'];?></a></td>
            
            <td><?=isset($v['part_name']) ? $v['part_name'] : '教师'?></td>
            <td><?=date('Y-m-d', strtotime($v['created']));?></td>
            <td>
             <?
             if($v['status'] == 'wait'){
                 echo "待审核";
             }else if($v['status'] == 'audit'){
                 echo "<span class='greenm'>审核通过</span>";
             }
             ?>
            </td>
            <td><?php if($v['status']=='wait'){?><span>退赛</span>&nbsp;&nbsp;&nbsp;<?php }else{?>
                <span><a href="javascript:tuike(<?=$v['course_id']?>,<?=$v['user_id']?>);" >退赛</a></span>&nbsp;&nbsp;&nbsp;<?php }?><span><a href="<?=$url;?>">进入大赛</a></span></td>
          <?php } ?>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!--<div class="noticekatebox">
       <div class="datapkate">
         <div class="datajump">
             <div class="datajumpin"><input type="text" name="page" maxlength="4" value="1"/></div>
             <div class="datajumpbut"><input type="button" id="pagego" class="jumpcolor" value="转到"/></div>
         </div>
            <div class="pagenext"><a href="#"><strong>下一页</strong></a></div>
            <div class="pagenum">1/2</div>
            <div class="pageup"><a href="#"><strong>上一页</strong></a></div>
            <div class="pagenum"><a href="#" title="末页">末页</a></div>
            <div class="pagenum"><a href="#" title="首页">首页</a></div>
         </div>
    </div>-->

  </div>

</div>