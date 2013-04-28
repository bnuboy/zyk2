<script>
 function change_tab(num,tab_id,t,tab)
  {
    for(var i=1;i<=num;i++)
    {
      if(i==tab_id){
        $("#"+t+i).attr('class','hver');
        $("#"+tab+i).css('display','block');
      }
      else
      {
        $("#"+t+i).attr('class','');
        $("#"+tab+i).css('display','none');
      }
    }
  }
</script>
<!--中间内容-->
<div class="counter counterborder">
<div class="Scenterboxbg">
  <!--管理信息-->
  <div class="resourbox">
    <!--中间信息-->
    <div class="middlebox">
      <div class="downresoursbox mt0">
        <h1>课程公告</h1>
      </div>
      <div class="resourdata">
        <table cellpadding="0" cellspacing="0" width="100%">
          <tbody id="resousdata">
            <?php foreach($course_notice as $val){?>
              <tr>
              <td><a href="/study_coursenotice/view/<?=$val['id']?>" class="blue"><?=$val['title']?></a></td>
              <td width="120"><?=$val['created']?></td>
            </tr>
            <?php }?>
            <tr>
              <td colspan="2" class="more"><a href="/study_coursenotice/index">查看全部</a></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="ediaresoursbox anwser"> 
          <a href="#this" onclick="change_tab(4,1,'t','tab')" class="hver" id="t1">审核信息</a>
          <a href="#this" onclick="change_tab(4,2,'t','tab')" id="t2">作业批阅</a>
          <a href="#this" onclick="change_tab(4,3,'t','tab')" id="t3">最新问题</a>
          <a href="#this" onclick="change_tab(4,4,'t','tab')" id="t4">最新发帖</a> </div>
        <div class="resourdata thcolor short"  id="tab1">
        <table width="100%" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th width="">申请人</th>
              <th width="120">申请时间</th>
              <th width="120">角色</th>
              <th width="90">状态</th>
            </tr>
          </thead>
          <tbody id="ediaresousdata">
             <?php foreach($select_course as $val){?>
            <tr>
              <td><?=$val['username']?></td>
              <td><?=$val['created']?></td>
              <td><?=$val['part_name']?></td>
              <td><?=$SELECT_COURSE_STATUS[$val['status']]?></td>
            </tr>
            <?php }?>
            <tr>
              <td colspan="4" class="more"><a href="/study_teach_manage/index">更多</a></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="resourdata thcolor short"  id="tab2" style="display:none" >
        <?php if($user_part['part_id']=="10003"||$user_part['part_id']=="10001"){?>
        <table width="100%" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th width="">标题</th>
              <th width="120">截止时间</th>
              <th width="120">提交情况</th>
              <th width="90">答题情况</th>
            </tr>
          </thead>
          <tbody id="ediaresousdata">
             <?php foreach($homework as $val){?>
            <tr>
              <td><?=$val['title']?></td>
              <td><?=$val['end_time']?></td>
              <td>0/0</td>
              <td><a href="/study_homework/test/<?=$val['type_id']?>/<?=$val['id']?>">查阅</a></td>
            </tr>
            <?php }?>
            <tr>
              <td colspan="4" class="more"><a href="/study_homework/index">更多</a></td>
            </tr>
          </tbody>
        </table>
          <?php }else{?>
         <table width="100%" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th width="">标题</th>
              <th width="120">开始时间</th>
              <th width="120">截止时间</th>
              <th width="90">答题情况</th>
            </tr>
          </thead>
          <tbody id="ediaresousdata">
             <?php foreach($homework as $val){?>
            <tr>
              <td><?=$val['title']?></td>
              <td><?=$val['start_time']?></td>
              <td><?=$val['end_time']?></td>
              <td><a href="/study_homework/test/<?=$val['type_id']?>/<?=$val['id']?>"><?=$val["hometype"]?></a></td>
            </tr>
            <?php }?>
            <tr>
              <td colspan="4" class="more"><a href="/study_homework/index">更多</a></td>
            </tr>
          </tbody>
          </table>
          <?php } ?>
      </div>
      <div class="resourdata thcolor short" style="display:none"  id="tab3">
        <table width="100%" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th width="240">标题</th>
              <th width="125">提问人</th>
              <th colspan="2">提问时间</th>
            </tr>
          </thead>
          <tbody id="ediaresousdata">
            <?php foreach($question as $val){?>
            <tr>
              <td><?=$val['title']?></td>
              <td><?=$val["user"]['name']?></td>
              <td><a href="study_question/get_question_info/<?=$val['id']?>" title="回复"><?=$val['qtime']?></a></td>
            </tr>
            <?php }?>
            <tr>
              <td colspan="4" class="more"><a href="/study_question/index">更多</a></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="resourdata thcolor short"  style="display:none"  id="tab4">
        <table width="100%" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th width="240">标题</th>
              <th width="125">发帖人</th>
              <th colspan="2">发布时间</th>
            </tr>
          </thead>
          <tbody id="ediaresousdata">
            <?php foreach($post as $val){?>
            <tr>
              <td><?=$val->title?></td>
              <td><?=$val->user?></td>
              <td><?=$val->created?></td>
            </tr>
            <?php }?>
            <tr>
              <td colspan="4" class="more"><a href="/forum/index">进入交流中心</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!--中间信息 end-->
    <!--右侧模块-->
    <div class="messbox">
      <div class="messboxbg">
        <div class="messtit">
          <h1>课程信息</h1>
        </div>
        <div class="kcxx-img"> <img src="<?=$course_info['img']?>" width="240" height="160" /></div>
        <div class="nessnword kcxx">
          <p><b>课程名称：</b><?=$course_info['name']?></p>
          <p><b>课程代码：</b><?=$course_info['course_uuid']?></p>
          <p><b>所属院系：</b><?=$organization['name']?></p>
          <p><b>课程分类：</b><?=$course_cat['name']?></p>
          <p><b>课程教师：</b><?=$course_info['name']?></p>
          <p><b>时间：</b><?=date("Y-m-d",  strtotime($course_info['start_time']));?>到<?=date("Y-m-d",  strtotime($course_info['end_time']));?></p>
          <p><b>课时：</b><?=$course_info['created']?></p>
          <p><b>学分：</b><?=$course_info['score']?></p>
          <p><b>简介：</b><?=$course_info['description']?></p>
        </div>
        <div class="messtit">
          <h1>课程统计</h1>
        </div>
        <div class="nessnword kcxx">
          <p><b>学生人数：</b><?=$stu_count?>人</p>
          <p><b>作业测试：</b><?=$count_mytest?>次</p>
          <p><b>学习资料：</b><?=$count_teachinfo?>个</p>
          <p><b>在线答疑：</b><?=$count_question?>个</p>
        </div>
      </div>
      <!--右侧模块 end-->
    </div>
    <div class="clear"></div>
  </div>
</div>
<!--中间内容 end-->