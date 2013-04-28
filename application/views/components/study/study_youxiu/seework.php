<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<style>
          .wc-line {
    border-bottom: 1px dotted #CCCCCC;
    height: 20px;
    margin-bottom: 15px;}
          .wc-choice h2 {
    font-size: 12px;}
          .wc-choice p {
    line-height: 24px;
    padding-left: 15px;
    padding-top: 5px;}
</style>
 <!--管理信息-->
      <div class="noticesbox">
        <div class="noticewarp tea-cont">
          <div class="noticetit tearch-nav">
            <h2>作业测试 > 作业 > <?=$info['title']?>&nbsp;</h2>
            <div><a href="/study_youxiu/index" class="blue">&lt;&lt;返回</a></div>
          </div><!--$attr[1] 是题型ID，$a['id']是试题ID-->
          <form action="/study_homework/jiaojuan/<?=$info['id']?>" method="post" enctype="multipart/form-data" >
          <div class="noticenwarp">
            <div class="work-cont">
              <h1><?=$info['title']?><em>(总分<?=$info['score']?>分)</em></h1>            
              <div class="wc-choice">
               <?php foreach($event as $key=>$val){?>
                  <?php foreach($val as $ke=>$va){?>
                    <?php $attr=  explode( '_', $ke );?>
                    <h2 style="line-height:30px; font-size:13px;"> <?= $attr[0] ?>（共有 <?= count( $va ) ?> 道题目，共计<?= $info[ 'scores' ][ $attr[1] ] ?>分）</h2>
                    <?php if($key=='danxuan' || $key=='duoxuan'){?>
                     <?php foreach($va as $k=>$v){?>        
                        <?php $a=unserialize($v['shiti_info']);?> 
                            <span style="margin-left: 10px; display: block;margin-top: 10px;margin-bottom: 10px;">
                               <h4><?=$k+1?>.<?=$a['title']?></h4>          
                                   <ul style="margin-left: 15px;">                           
                                <?php  foreach ($a['xx'] as $ks=>$vs){?>
                                     <li  style="line-height:25px;">
                                         <?=$abc_array[$ks]?>. <?=$vs?></li>
                                <?php }?>  
                                     我的答案：<?php if($key=='danxuan'){?><?=isset($answer[$key][$attr[1]][$a['id']]) ? $abc_array[$answer[$key][$attr[1]][$a['id']]] : '无'?><?php }else{ 
                                       if(isset($answer[$key][$attr[1]][$a['id']])){  foreach($answer[$key][$attr[1]][$a['id']] as $ak=>$av ){?>
                                     <?=$abc_array[$av]?>、<?php } } }?>
                                   </ul>
                             </span>
                     <?php }?>
                    <?php }elseif($key=='wanxingtiankong' ){?><!--danxuan & duoxuan end--><!--$attr[1] 是题型ID，$a['id']试题ID， $ks是第几个题目-->
                        <?php foreach($va as $k=>$v){?>
                          <?php $a=unserialize($v['shiti_info']);?>
                            <span style="margin-left: 10px;display: block;margin-top: 10px;margin-bottom: 10px;">
                            <h4><?=$k+1?>.<?=$a['title']?></h4>          
                                <ul style="margin-left: 15px;">                           
                                <?php  foreach ($a['timu'] as $ks=>$vs){?>
                                    <li style="line-height:25px;"><?=$ks?>.
                                    <?php  foreach($vs as $kss=>$vss){?>
                                        <?=$abc_array[$kss]?>. <?=$vss?>&nbsp;&nbsp;      
                                    <?php }?>          
                                   </li>
                                <?php }?>  
                                    我的答案：
                                    <?php  foreach ($a['timu'] as $ks=>$vs){?>
                                        <?=isset($answer[$key][$attr[1]][$a['id']][$ks]) ? $ks.'. &nbsp;'.$abc_array[$answer[$key][$attr[1]][$a['id']][$ks]].'. &nbsp;' : $ks.'.&nbsp; 没选择';?>
                                     <?php }?>  
                                </ul>
                            </span>
                        <?php }?>    
                    <?php }elseif($key=='pipei'){?><!-- wanxingtiankong end-->
                        <?php foreach($va as $k=>$v){?>
                             <span style="margin-left: 10px;display: block;margin-top: 10px;margin-bottom: 10px;">
                            <?php $a=unserialize($v['shiti_info']);?>                          
                            <h4 style="padding-bottom:8px; display:block"><?=$k+1?>.<?=$a['title']?></h4>          
                                <ul style="margin-left: 15px;">                           
                                <?php  foreach ($a['timu'] as $ks=>$vs){?>
                                    <li style="line-height:25px;"><?=$ks?>. <?=$vs?>&nbsp;&nbsp; &nbsp; <?=$abc_array[$ks-1]?>.<?=$a['xuanxiang'][$ks]?></li>
                                <?php }?>                           
                                </ul>
                            我的答案：
                                    <?php $num=count($a['timu']); for($i=0;$i<$num;$i++){?>
                                    <?=isset($answer[$key][$attr[1]][$a['id']][$i]) ? ($i+1).'. &nbsp;'.$abc_array[$answer[$key][$attr[1]][$a['id']][$i]].'&nbsp;' : ($i+1).'. &nbsp;无'?>
                                    <?php }?>
                            </span>
                        <?php }?>
                    <?php }elseif($key=='yuedulijie'){?><!-- pipei end--><!--$attr[1] 是题型ID，$a['id']试题ID， $ks是第几个题目-->
                        <?php foreach($va as $k=>$v){?>
                            <?php $a=unserialize($v['shiti_info']);?>
                            <span style="margin-left: 10px;display: block;margin-top: 5px;margin-bottom: 5px;">
                            <h4  style="padding-bottom:8px;"><?=$k+1?>.<?=$a['title']?></h4> 
                               <?php  foreach ($a['timu'] as $ks=>$vs){?>
                                <span style="margin-left: 10px;"><?=$ks?>.    <?=$vs?></span>
                                <ul style="margin-left: 25px;display: block;"> 
                                    <li  style="line-height:25px;">                           
                                        <?php  foreach($a['xuanxiang'][$ks] as $ki=>$vi ){?>    
                                            <?=$abc_array[$ki]?>.<?=$vi?>&nbsp;&nbsp;
                                        <?php }?> 
                                       <p>我的答案：<?=isset($answer[$key][$attr[1]][$a['id']][$ks]) ? $ks.'. &nbsp;'.$abc_array[$answer[$key][$attr[1]][$a['id']][$ks]] : $ks.'. &nbsp; 没选择'?>
                                        </p>
                                    </li>                  
                                </ul>
                               <?php }?>
                             </span>
                        <?php }?>
                    <?php }elseif($key=='tiankong' || $key=='wenda'){?><!-- yuedulijie end-->
                        <?php foreach($va as $k=>$v){?>
                          <?php if($key=='tiankong'){$a=unserialize($v['shiti_info']);}else{$a=unserialize($v['shiti_info']);}?>
                            <span style="margin-left: 10px;display: block;margin-top: 10px;margin-bottom: 10px;">
                            <h4 style="padding-bottom:8px;"><?=$k+1?>.<?=$a['title']?></h4>  
                                <?php if($key=='tiankong'){ echo '我的答案：'; foreach($a['daan'] as $k_da=>$v_da){?>                                   
                                   空<?=$k_da?>:&nbsp;&nbsp; 
                                         <?=isset($answer[$key][$attr[1]][$a['id']][$k_da]) ? $answer[$key][$attr[1]][$a['id']][$k_da] : ''?>
                                   &nbsp;&nbsp;&nbsp;
                                <?php } }else{?>                         
                                   <?=isset($answer[$key][$attr[1]][$a['id']]) ? $answer[$key][$attr[1]][$a['id']] : '没有做本题'?>
                                <?php }?>
                            </span>
                        <?php }?>    
                    <?php }?>
                  <?php }?>
               <?php }?>
              </div>         
            </div>
          </div>
        </form>
          <div class="wc-line"></div>
          <div class="wc-choice" style="padding: 10px;">
              <h2>批阅结果</h2>
            <p><b>评分：</b><?=$pingjia['pingfen']?> 分   &nbsp; &nbsp; &nbsp; 
                <img src="/resource/images/flag.jpg" width="16" height="16" /> 优秀作业<br />
            <b>评语：</b><?=$pingjia['pingyu']?></p>
            <p align="right"><?=$pingjia['created']?></p>
          </div>
         </div>
        </div>
      </div>
      <!--管理信息 end-->
      