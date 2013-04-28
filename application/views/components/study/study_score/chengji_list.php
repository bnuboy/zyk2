<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>  

<!--管理信息-->
      <div class="noticesbox kecheng">
        <div class="noticewarp">
        	
          <div class="noticetit tearch-nav tearch-navts">
            <h1>成绩簿</h1>
            <div></div>
          </div>
            
           <div class="noticenwarp">
             <div class="databox databoxs" style="width:730px">
                	<table width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="100">排名</th>
                                <th width="102">姓名</th>
                                <?php foreach($zuoye as $key=>$val){?>
                                <th width="89"><?=$val?></th>
                                <?php }?>
                                <?php if(!empty($tds)){?>
                                    <?=$tds?>
                                <?php }?>
                            </tr>
                        </thead>
                        <tbody id="resousdata">
                            <?php  $i=1; foreach($scores as $key=>$val){?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$user_info[$key]?></td>
                                <?php foreach($val['score'] as $k=>$v){?>
                                <td><?=$v?></td> 
                                <?php }?>
                                <?php if(isset($val['total'])){?>
                                <td><?=$val['total']?></td>
                                <?php }?>
                                <?php if(isset($val['avg'])){?>
                                <td><?=$val['avg']?></td>
                                <?php }?>
                                <?php if(isset($val['jaquan'])){?>
                                <td><?=$val['jaquan']?></td>
                                <?php }?>
                            </tr>
                           <?php $i++ ;}?>
                              <tr>
                                  <?php if($scor_count){?>
                              <td rowspan="<?=$scor_count?>">作业或测验统计情况</td>
                              <?php }?>
                              <?php if(!empty($tj['tiliang'])){?>
                              <td>题目数量</td>
                                 <?php foreach($tj['tiliang'] as $key=> $val){?>
                                   <td><?=$val?></td>
                                 <?php } ?>
                              <?php }?>
                                   <!--有几个个人统计条件就多出几个td-->
                                   <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>
                            <?php if(!empty($tj['top'])){?>
                            <tr>
                              <td>最高分</td>
                              <?php foreach($tj['top'] as $key=>$val){?>
                               <td><?=$val?></td>
                              <?php }?>
                              <!--有几个个人统计条件就多出几个td-->
                              <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>
                            <?php }?>
                            <?php if(!empty($tj['low'])){?>
                            <tr>
                              <td>最低分</td>
                              <?php foreach($tj['low'] as $key=>$val){?>
                              <td><?=$val?></td>
                              <?php }?>
                              <!--有几个个人统计条件就多出几个td-->
                                   <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>
                            <?php }?>
                            <?php if(!empty($tj['total'])){?>
                            <tr>
                              <td>总分</td>
                              <?php foreach($tj['total'] as $key=>$val){?>
                              <td><?=$val?></td>
                              <?php }?>
                              <!--有几个个人统计条件就多出几个td-->
                                   <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>
                            <?php }?>
                            
                             <?php if(!empty($tj['avg'])){?>
                            <tr>
                              <td>平均分</td>
                              <?php foreach($tj['avg'] as $key=>$val){?>
                              <td><?=$val?></td>
                              <?php }?>
                              <!--有几个个人统计条件就多出几个td-->
                               <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>
                            <?php }?>
                            <?php if(!empty($tj['yx'])){?>
                               <tr>
                              <td rowspan="2">优秀</td>
                              <td>人数</td>
                              <?php foreach ($tj['yx'] as $key => $val) {?>
                              <td><?=$val?></td>
                             <?php }?>
                              <!--有几个个人统计条件就多出几个td-->
                               <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>比例</td>
                              <?php foreach($tj['yx_bili'] as $key=>$val){?>
                              <td><?=$val?></td>
                              <?php }?>
                              <!--有几个个人统计条件就多出几个td-->
                              <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>        
                            <?php }?>
                            <?php if(!empty($tj['lh'])){?>
                            <tr>
                              <td rowspan="2">良好</td>
                              <td>人数</td>
                              <?php foreach($tj['lh'] as $key=>$val){?>
                              <td><?=$val?></td>
                              <?php } ?>
                              <!--有几个个人统计条件就多出几个td-->
                              <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>比例</td>
                              <?php foreach($tj['lh_bili'] as $key=>$val){?>
                              <td><?=$val?></td>
                              <?php } ?>
                              <!--有几个个人统计条件就多出几个td-->
                              <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>
                            <?php }?>
                            <?php if(!empty($tj['zd'])){?>
                            <tr>
                              <td rowspan="2">中等</td>
                              <td>人数</td>
                              <?php foreach($tj['zd'] as $key=>$val){?>
                              <td><?=$val?></td>
                              <?php }?>
                              <!--有几个个人统计条件就多出几个td-->
                              <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>比例</td>
                              <?php foreach($tj['zd_bili'] as $key=>$val){?>
                              <td><?=$val?></td>
                             <?php } ?>
                              <!--有几个个人统计条件就多出几个td-->
                              <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>
                            <?php } ?>
                            <?php if(!empty($tj['jg'])){?>
                            <tr>
                              <td rowspan="2">及格</td>
                              <td>人数</td>
                              <?php foreach($tj['jg'] as $key=>$val){?>
                              <td><?=$val?></td>
                              <?php }?>
                              <!--有几个个人统计条件就多出几个td-->
                              <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>比例</td>
                              <?php foreach($tj['jg_bili'] as $key=>$val){?>
                              <td><?=$val?></td>
                              <?php }?>
                              <!--有几个个人统计条件就多出几个td-->
                              <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>     
                            <?php } ?>
                            <?php if(!empty($tj['bjg'])){?>
                            <tr>
                              <td rowspan="2">不及格</td>
                              <td>人数</td>
                              <?php foreach($tj['bjg'] as $key=>$val){?>
                              <td><?=$val?></td>
                              <?php }?>
                              <!--有几个个人统计条件就多出几个td-->
                              <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>
                            <tr>
                              <td>比例</td>
                              <?php foreach($tj['bjg_bili'] as $key=>$val){?>
                              <td><?=$val?></td>
                              <?php }?>
                              <!--有几个个人统计条件就多出几个td-->
                              <?php if(!empty($td)){?>
                              <?=$td?>
                              <?php }?>
                            </tr>     
                            <?php } ?>
                        </tbody>                
                </table>
             </div>
			 <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                        <div class="addbutdel"><input type="reset" name="reset" class="addbut" value="取消" /></div>
                        <div class="addbutin"><input type="button" name="send" class="addbut" value="导出Excel表单" /></div>
                    </div>
          </div>
            
        </div>
      </div>
      <!--管理信息 end-->