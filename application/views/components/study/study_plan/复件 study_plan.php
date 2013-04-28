<script>
  function deleteItem( id ){
    if ( !confirm( "你确定要删除吗？" ) )
      return;
    location.href="/study_plan/delunit?id="+id;
  }
  
  function deleteItems( id ){
     if ( !confirm( "你确定要删除吗？" ) )
       return;
     location.href="/study_plan/delmun?id="+id;
  }
 
 function munschose(){
    var munid = $("#muns").val();
    window.location.href='/study_plan/updown?munid='+munid;
 }
</script>

   <div class="noticesbox kecheng">
<div class="noticewarp tea-cont">
    <div class="noticetit tearch-nav">
        <h2>课程计划 > <?php if(!empty($mun))echo $mun['title'];?></h2>
        <div>
            <a href="<?=!empty($mun['id'])?"/study_plan/move/".$mun['id']."/down":"" ?>">下移<img src="/resource/images/arrow_down.png"></a>
             <a href="<?=!empty($mun['id'])?"/study_plan/move/".$mun['id']."/up":"" ?>">上移<img src="/resource/im/down"ages/arrow_up.png"></a>
           <a href="/study_plan/index/<?php if(!empty($mun))echo$mun['id']?>?type=1">
              <img src="/resource/study/images/book.gif" width="16" height="16" />
               只显示有效目录
           </a>
           <a href="/study_plan/addfolder">
              <img src="/resource/study/images/report_add.png" width="16" height="16" />新建计划目录
           </a>
            <select name="muns" id='muns' onchange="munschose()">
                 <option value=''>
                       <img width="16" height="16" src="/resource/study/images/arrow_down.png" />下载计划目录
                 </option>
                 <option value='1'>
                       <img width="16" height="16" src="/resource/study/images/arrow_down.png" />下载有效目录
                 </option>
                 <option value='2'>
                       <img width="16" height="16" src="/resource/study/images/arrow_down.png" />下载全部计划目录
                 </option>
            </select>
        </div>
    </div>
    <div class="noticenwarp">
        <div class="work-cont">
            <h1>
                <span><?php if(!empty($mun))echo $mun['title'];?></span>
                <div class="fr">
                    <a href="/study_plan/addunit?cid=<?php if(!empty($mun))echo $mun['id']?>"><img src="/resource/study/images/report_add.png" width="16" height="16" />添加教学单元</a>
                    <a href="/study_plan/addfolder?id=<?php if(!empty($mun))echo $mun['id']?>"><img width="16" height="16" src="/resource/study/images/table_edit.png">编辑</a>
                    <a href="/study_plan/delunit?id=<?php if(!empty($mun))echo $mun['id']?>" onclick="javascript:return confirm('你确定要删除吗？')"><img width="16" height="17" src="/resource/study/images/del.gif">删除</a>
                </div>
            </h1>
            <?php
            if(!empty($infos)){
            foreach($infos as $key => $v) {?>
                <div class="wc-choice">
                    <h2><?=$key+1?>. <?=$v['title']?></h2>
                    <h4><?=$v['content']?></h4>
                    <?php
                      switch($v['relevance_type'] ){
                          case $v['relevance_type'] ='1':?>
                    
                                 <ul class="wc-list">
                                     <?php foreach($v['relevance'] as $key=>$val){
                                     if($key==0){
                                         echo "<h5>关联教学资料:<a href='/study_teachinfo/index/".$val['id']."'>".$val['name']."</a></h5>";
                                     }else{ ?>
                                       <li><a href="/study_teachinfo/index/<?=$val['id']?>"><?=$val['name']?></a></li>
                                     <?php
                                     }
                                     } break;?>
                                 </ul>

                          <?php case $v['relevance_type'] ='2': ?>
                    
                               <ul class="wc-list">
                                 <?php foreach($v['relevance'] as $key=>$val){
                                 if($key==0){
                                     echo "<h5>关联作业:<a href='/study_homework/test/".$val['type_id']."/".$val['id']."'>".$val['title']."</a></h5>";
                                 }else{ ?>
                                   <li><a href="/study_homework/test/"<?=$val["type_id"];?>/<?=$val['id']?>><?=$val['title']?></a></li>
                                 <?php
                                 }
                                 } break;?>
                              </ul>
                    
                         <?php  case $v['relevance_type'] ='3':?>
                              <ul class="wc-list">
                                 <?php foreach($v['relevance'] as $key=>$val){
                                 if($key==0){
                                     echo "<h5>关联自测:<a href='/study_mytest/get_look/".$val['id']."'>".$val['title']."</a></h5>";
                                 }else{ ?>
                                   <li><a href="/study_teachinfo/index/<?=$val['id']?>"><?=$val['title']?></a></li>
                                 <?php
                                 }
                                 } break;?>
                              </ul>

                          <?php case $v['relevance_type'] ='4':?>
                                 <h5>关联即时讨论:
                                     <a href="/study_plan/webchat/<?=$v['id']?>">进入讨论区</a>
                                 </h5>
                          <?php break;?>

                          <?php case $v['relevance_type'] ='5':?>
                              <h5>关联作品:
                                  <a href="/study_plan/upproduct/<?=$v['id']?>">上传作品</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                  <a href="/study_plan/productlist/<?=$v['id']?>">查看作品</a>
                              </h5>
                         <?php break;?>
                    
                         <?php  case $v['relevance_type'] ='6':?>
                               <ul class="wc-list">
                                     <?php foreach($v['relevance'] as $key=>$val){
                                     if($key==0){
                                         echo "<h5>关联课堂内容:<a href='/study_coursecontent/index/".$val['id']."'>".$val['title']."</a></h5>";
                                     }else{ ?>
                                       <li><a href="/study_coursecontent/index/<?=$val['id']?>"><?=$val['title']?></a></li>
                                     <?php
                                     }
                                     } break;?>
                               </ul>
                    <?php default: "";break; }?>
                    
                    <div class="Bjsc">
                        <a href="/study_plan/addunit?id=<?=$v['id']?>"><img width="16" height="16" src="/resource/study/images/table_edit.png">编辑</a>
                        <a href="javascript:deleteItem(<?=$v['id']?>);"><img width="16" height="17" src="/resource/study/images/del.gif">删除</a>
                    </div>
                    <div class="wc-line"></div>
                </div>
            <?php }} ?>
        </div>
    </div>
</div>
   </div>