<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 

 <!--管理信息-->
      <div class="noticesbox">
        <div class="noticewarp tea-cont">
          <div class="noticetit tearch-nav">
            <h2>作业测试 > 作业 > <?=$info['title']?>&nbsp;</h2>
            <div><a href="/study_stuwork/index" class="blue">&lt;&lt;返回</a></div>
          </div><!--$attr[1] 是题型ID，$a['id']是试题ID-->
          <form action="/study_stuwork/jiaojuan/<?=$info['id']?>" method="post" enctype="multipart/form-data" >
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
                                    <?php $num=count($a['timu']); for($i=0;$i<$num;$i++){?>
                                    <?=$i+1?>.<select name="pipei[<?=$a['tixing_id']?>][<?=$a['id']?>][]">
                                        <?php for($j=0;$j<$num;$j++){?>
                                        <option value="<?=$j?>">&nbsp;&nbsp;<?=$abc_array[$j]?>&nbsp;</option>
                                        <?php }?>
                                    </select>
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
                                <?php if($key=='tiankong'){ foreach($a['daan'] as $k_da=>$v_da){?>                                   
                                   空<?=$k_da?>: <input type="text" name="tiankong[<?=$a['tixing_id']?>][<?=$a['id']?>][<?=$k_da?>]" value="" />
                                <?php } }else{?>
                                   <textarea  name="wenda[<?=$a['tixing_id']?>][<?=$a['id']?>]"></textarea>
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
        </div>
      </div>
      <!--管理信息 end-->