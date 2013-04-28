
<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<!--管理信息-->
<div class="noticesbox kecheng">
    <div class="noticewarp tea-cont">
        <div class="noticetit tearch-nav tearch-navts">
            <h1><?= $info[ 'title' ] ?> <span>（总分<?= $info[ 'score' ] ?>分）</span></h1>
            <div><a href="/study_mytest/index">返回</a></div>
        </div>
        <div class="noticenwarp">
            <div class="work-cont">
                <div class="wc-choice wc-choices dcti">
                    <!--$ke 题型名 $key 是基本类型-->
                  <?php foreach($list as $key=>$val){?>
                  <?php foreach($val as $ke=>$va){?>   
                    <?php if($key=='danxuan' || $key=='duoxuan'){?>
                     <?php foreach($va as $k=>$v){?> 
                        <h2> <?= $ke ?>（共有 <?= count( $v ) ?> 道题目，共计<?= $info[ 'scores' ][ $k ] ?>分）</h2>
                        <?php foreach($v as $ks=>$vs){?>         
                            <?php  $a=unserialize($vs['xx']);?> 
                               <span style="margin-left: 10px; display: block;margin-top: 5px;margin-bottom: 5px;">
                                 <h4><?=$ks+1?>.<?=$vs['title']?></h4>          
                                   <ul style="margin-left: 15px;">                           
                                    <?php  foreach ($a as $kss=>$vss){?>
                                         <li><?=$abc_array[$kss]?>. <?=$vss?></li>
                                    <?php }?>                           
                                   </ul>
                             </span>
                        <?php }?>
                     <?php }?>
                    <?php }elseif($key=='wanxingtiankong' ){?><!--danxuan & duoxuan end-->
                        <?php foreach($va as $k=>$v){?>
                            <h2> <?= $ke ?>（共有 <?= count( $v ) ?> 道题目，共计<?= $info[ 'scores' ][ $k ] ?>分）</h2>
                            <?php foreach($v as $ks=>$vs){?>
                               <?php $a=unserialize($vs['timu']);?>
                                    <span style="margin-left: 10px;display: block;margin-top: 5px;margin-bottom: 5px;">
                                     <h4><?=$ks+1?>.<?=unserialize($vs['title']);?></h4>          
                                        <ul style="margin-left: 15px;">                           
                                        <?php  foreach ($a as $kss=>$vss){?><?=$kss?>.
                                            <li>
                                            <?php foreach($vss as $ksss=>$vsss){?>
                                                <?=$abc_array[$ksss]?>. <?=$vsss?>&nbsp;
                                            <?php }?>
                                            </li>
                                        <?php }?>                           
                                        </ul>
                                    </span>
                            <?php }?>
                        <?php }?>    
                    <?php }elseif($key=='pipei'){?><!-- wanxingtiankong end-->
                        <?php foreach($va as $k=>$v){?>
                     <h2> <?= $ke ?>（共有 <?= count( $v ) ?> 道题目，共计<?= $info[ 'scores' ][ $k ] ?>分）</h2>
                            <?php foreach($v as $ks=>$vs){?>
                                 <span style="margin-left: 10px;display: block;margin-top: 5px;margin-bottom: 5px;">
                                <?php $a=unserialize($vs['timu']);$xuanxiang=unserialize($vs['xuanxiang']);?>                          
                                <h4><?=$ks+1?>.<?=$vs['title']?></h4>          
                                    <ul style="margin-left: 15px;">                           
                                    <?php  foreach ($a as $kss=>$vss){?>
                                        <li><?=$kss?>. <?=$vss?>&nbsp;&nbsp; &nbsp; <?=$abc_array[$kss-1]?>.<?=$xuanxiang[$kss]?></li>
                                    <?php }?>                           
                                    </ul>
                                </span>
                            <?php }?>
                        <?php }?>
                    <?php }elseif($key=='yuedulijie'){?><!-- pipei end-->
                        <h2> <?= $ke ?>（共有 <?= count( $v ) ?> 道题目，共计<?= $info[ 'scores' ][ $k ] ?>分）</h2>
                        <?php foreach($va as $k=>$v){?>
                            <?php foreach($v as $ks=>$vs){?>
                                <?php $a=unserialize($vs['timu']);$xuanxiang=unserialize($vs['xuanxiang']);?>
                                <span style="margin-left: 10px;display: block;margin-top: 5px;margin-bottom: 5px;">
                                <h4 ><?=$ks+1?>.<?=$vs['title']?></h4> 
                                   <?php  foreach ($a as $kss=>$vss){?>
                                    <span style="margin-left: 10px;"><?=$kss?>.    <?=$vss?></span>
                                    <ul style="margin-left: 25px;display: block;"> 
                                        <li>                           
                                            <?php foreach($xuanxiang[$kss] as $ki=>$vi ){?>
                                                <?=$abc_array[$ki]?>.<?=$vi?>&nbsp;&nbsp;
                                            <?php }?> 
                                        </li>                  
                                    </ul>
                                   <?php }?>
                                 </span>
                            <?php }?>
                        <?php }?>
                    <?php }elseif($key=='tiankong' || $key=='wenda'){?><!-- yuedulijie end-->
                        <?php foreach($va as $k=>$v){?>
                    <h2> <?= $ke ?>（共有 <?= count( $v ) ?> 道题目，共计<?= $info[ 'scores' ][ $k ] ?>分）</h2>
                            <?php foreach($v as $ks=>$vs){?>
                                <?php  if($key=='tiankong'){$a=unserialize($vs['title']);}else{$a=$vs['title'];}?>                              
                                <span style="margin-left: 10px;display: block;margin-top: 5px;margin-bottom: 5px;">
                                <h4><?=$ks+1?>.<?=$a?></h4> 
                                <?php if($key=='tiankong'){ foreach(unserialize($vs['daan']) as $k_da=>$v_da){?>                                   
                                   空<?=$k_da?>: <input type="text" name="tiankong[<?=$vs['tixing_id']?>][<?=$vs['id']?>][<?=$k_da?>]" value="" />
                                <?php } }else{?>
                                   <textarea  name="wenda[<?=$vs['tixing_id']?>][<?=$vs['id']?>]"></textarea>
                                <?php }?>
                                </span>
                           <?php }?> 
                        <?php }?>    
                    <?php }?>
                  <?php }?>
               <?php }?>
                    <div class="wc-line"></div>
                    <div class="scdelec"><a href="#"><img src="/resource/images/table_edit.png" width="16" height="16">修改</a><a href="#"><img src="/resource/images/del.gif" width="16" height="16">删除</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--管理信息 end-->