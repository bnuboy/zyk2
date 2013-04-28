<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 

<!--管理信息-->
                        <div class="noticesbox">
    	<div class="noticewarp">
        	
          <div class="noticetit tearch-nav tearch-navts">
            <h1>批阅作业</h1>
            <div>上一份　<a href="#">下一份</a>　<a href="#">返回</a></div>
            </div>
            
            <div class="noticenwarp noticenwarps">
            	
                    <div class="noticekatebox">
                        <div class="addpword">类型：</div>
                        <div class="scselect">
                        <?=$WORK_TYPE[$list['type_id']]?>
                        </div>
                    </div>
                    <div class="noticekatebox">
                        <div class="addpword">标题：</div>
                        <div class="scselect">
							<?=$list['title']?>
                        </div>
                    </div>
                    
                    <div class="noticekatebox">
                        <div class="addpwordn">总分：</div>
                        <div class="scselect">
							<?=$list['score']?>
                        </div>
                    </div>
                    <div class="noticekatebox">
                        <div class="addpwordn">关联章节：</div>
                        <div class="scselect">
                          <?=$list['zj_name']?>
                        </div>
                    </div>
                    <div class="noticekatebox">
                        <div class="addpwordn">说明：</div>
                        <div class="scselect">
                            <?=$list['content']?>
                        </div>
                    </div>
                    <?php if($list['type_id']==3){?>
                    <div class="noticekatebox">
                        <div class="addpwordn">作业附件：</div>
                        <div class="scselect">
                            <a href="<?=$info['param']?>">下载</a>
                        </div>
                    </div>
                    <?php }?>
                    <div class="noticekatebox">
                        <div class="addpwordn">答案说明：</div>
                        <div class="scselect">
                    无
                        </div>
                    </div>
                    <?php if($list['type_id']==3){?>
                    <div class="noticekatebox">
                        <div class="addpwordn">答案附件：</div>
                        <div class="scselect">
                            <a href="">下载</a>
                        </div>
                    </div>
                    <?php }?>
                <form action="/study_homework/pingjia/<?=$list['jz_id']?>" method="post">
                    <div class="noticekatebox" style="height:184px;">
                        <div class="addpwordn">评语：</div>
                        <div class="addpease"><textarea name="pingyu" ><?=!empty($list['pingyu']) ? $list['pingyu'] : ''?></textarea></div>
                    </div>
                    <div class="noticekatebox">
                        <div class="addpword">评分：</div>
                        <div class="addptits"><input name="pingfen" type="text" value="<?=!empty($list['pingfen']) ? $list['pingfen'] : ''?>"/>满分100分</div>
                    </div>
                    <div class="noticekatebox">
                        <div class="addpword">　　　</div>
                        <div><input name="good_work" type="checkbox" value="y" <?=isset($list['good_work']) && $list['good_work']=='y' ? 'checked' :''?>/>设为优秀作业</div>
                    </div>
                    
                    <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                        <div class="addbutdel"><input type="reset"  class="addbut" value="取消" /></div>
                        <div class="addbutin"><input type="button"  class="addbut" value="退回作业" /></div>
                        <div class="addbutin"><input type="submit"  class="addbut" value="提交保存" /></div>
                    </div>
                </form>               
            </div>
            
        </div>
    </div>

            <!--管理信息 end-->