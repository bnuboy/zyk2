<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 


<!--管理信息-->
                        <div class="noticesbox">
    	<div class="noticewarp">
         	<div class="noticetit tearch-nav tearch-navts">
				<h1>自测统计</h1>
            </div>
            
            <div class="noticenwarp">
              <div class="databox" style="width:730px">
                	<table width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="14">&nbsp;</th>
                                <th width="244">学生</th>
                                <th width="84">用户名</th>
                                <th width="105">所在班级</th>
                                <th width="81">自测次数</th>
                                <th width="176">最新自测时间</th>
                            </tr>
                        </thead>
                        <tbody id="resousdata">
                            <?php foreach($list as $key=>$val){?>
                            <tr>
                                <td><?=$key+1?>.</td>
                                <td><?=$val['username']?></td>
                                <td><?=$val['login_name']?></td>
                                <td><?=$val['class_name']?></td>
                                <td><?=$val['zice_count']?></td>
                                <td><?=$val['riqi']?></td>
                            </tr>
                            <?php } ?>                           
                        </tbody>                
                </table>
              </div>
              <?=$pagination?>  
            </div>
            
        </div>
    </div>

            <!--管理信息 end-->
