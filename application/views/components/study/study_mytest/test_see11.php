
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
                    <?php foreach ( $list as $kt => $vs )
                    { ?>
                        <?php
                        foreach ( $vs as $key => $val )
                        {
                            foreach ( $val as $k => $v )
                            {
                                if ( $kt != 'yuedulijie' )
                                {
                                    ?>
                                    <h2> <?= $key ?>（共有 <?= count( $v ) ?> 道题目，共计<?= $info[ 'scores' ][ $k ] ?>分）</h2>
                                        <?php foreach ( $v as $ks => $vl )
                                        { ?>
                                        <h4><?= $ks + 1 ?>.<?php
                                                if ( $kt == 'wanxingtiankong' || $kt == 'tiankong' )
                                                {
                                                    echo unserialize( $vl[ 'title' ] );
                                                }
                                                else
                                                {
                                                    echo $vl[ 'title' ];
                                                }
                                                ?></h4>
                                        <?php if ( $kt == 'danxuan' || $kt == 'duoxuan' )
                                        { ?>
                                            <ul>
                                                <?php foreach ( unserialize( $vl[ 'xx' ] ) as $kk => $vv )
                                                { ?>
                                                    <li><?= $abc_array[ $kk ] ?>.<?= $vv ?></li>                      
                                            <?php } ?>
                                            </ul> 
                                        <?php }
                                        elseif ( $kt == 'tiankong' || $kt == 'wenda' )
                                        {
                                            
                                        }
                                        elseif ( $kt == 'wanxingtiankong' || $kt == 'pipei' )
                                        { ?>  
                                             <ul>
                                            <?php foreach ( unserialize( $vl[ 'timu' ] ) as $kk => $vv )
                                            { ?>
                                               <li><?= $abc_array[ $kk ] ?>.<?= $vv ?></li>                      
                                            <?php } ?>
                                            </ul> 
                                        <?php }
                                            elseif ( $kt == 'yuedulijie' )
                                            { ?>
                                             <ul>
                                            <?php foreach ( unserialize( $vl[ 'timu' ] ) as $kk => $vv )
                                            { ?>
                                                  <li><?= $abc_array[ $kk - 1 ] ?>.<?= $vv ?></li>                      
                                            <?php } ?>
                                             </ul> 
                            <?php } ?>
                                        <?php
                                        }
                                    }else{
                                    ?> 
                                    <h2><?= $key ?>（共有 <?= count( $v ) ?> 道题目，共计<?= $info[ 'scores' ][ $k ] ?>分）</h2>
                                    <?php  foreach ( $v as $ks => $vl ){ 
                                        echo "<h2 style='margin-left:10px;'>题干:".($ks+1).'.'.$vl['title']."</h2>";
                                            foreach (unserialize($vl['timu']) as $t=>$tv){

                                        ?>
                                            <h4 style="margin-left: 15px;"><?=$t?>.<?=$tv?></h4> 
                                                <ul style="margin-left: 20px;">
                                                    <?php foreach(unserialize($vl['xuanxiang']) as $kc=>$vc){
                                                       
                                                        if($kc==$t){
                                                            foreach($vc as $kcs=>$vcs){
                                                        ?>
                                                            <li><?=$abc_array[$kcs]?>.<?=$vcs?></li>                                          
                                                      <?php }}}?>
                                                </ul>
                                            
                                            <?php 
                                            }
                                            }?>
                                    <?php }?>


        <?php }
    } ?>
<?php } ?>
                    <div class="wc-line"></div>
                    <div class="scdelec"><a href="#"><img src="images/table_edit.png" width="16" height="16">修改</a><a href="#"><img src="images/del.gif" width="16" height="16">删除</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--管理信息 end-->