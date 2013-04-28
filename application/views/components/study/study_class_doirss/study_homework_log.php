  <div class="noticewarp tea-cont">
                    
                <div class="noticetit tearch-nav">
                <h2>学习档案 &gt; 作业</h2>
                  </div>
                    
                    <div class="noticenwarp">
                      <div class="noticekatebox">完成次数：<?=$count?>次    &nbsp;      优秀次数：<?=$good_work?>次    &nbsp;      平均成绩：<?=$agv?>分      &nbsp;    总成绩：<?=$sum?>分</div>
                        
                        <div class="databox">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th >作业标题</th>
                                        <th width="100">完成时间</th>
                                        <th width="60">成绩</th>
                                        <th width="80">优秀作业</th>
                                    </tr>
                                </thead>
                                <tbody id="resousdata">
                                   <?php foreach($list as $val){?>
                                    <tr>
                                        <td><?=$val['title']?> </td>
                                        <td><?=$val['created']?></td>
                                        <td><?=$val['score']?></td>
                                        <td><?=$val['good_work']=='n'?"优秀":""?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>                
                            </table>
      </div>
                        
                        <div class="noticekatebox">
                          <?=$pagination?>
                        </div>
                        
                  </div>
                    
                </div>
            </div>