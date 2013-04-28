<div class="messbox">
      <div class="messboxbg">
        <div class="messtit">
          <h1><?=$course_cat['name']?></h1>
        </div>
        <div class="newwwarp nessnword kcxx">
         <p><b>简介：</b><?=$course_info['description']?></p>
        </div>
        <div class="kcxx-img"> <img src="<?=$course_info['img']?>" width="240" height="160" /></div>
        <div style="clear:both"></div>
        <div class="nessnword kcxx kctp">
          <p class="mr"><b>课程名称：</b><span><?=$course_info['name']?></span></p>
          <p class="ml"><b>课程代码：</b><span><?=$course_info['course_uuid']?></span></p>
          <p class="mr"><b>所属院系：</b><span><?=$organization['name']?></span></p>
          <p class="ml"><b>课程分类：</b><span><?=$course_cat['name']?></span></p>
          <p class="mr"><b>课程教师：</b><span><?=$course_info['name']?></span></p>
          <p class="ml"><b>时间：</b><span><?=date("Y-m-d",  strtotime($course_info['start_time']));?>到<?=date("Y-m-d",  strtotime($course_info['end_time']));?></span></p>
          <p class="mr noborder"><b>课时：</b><span><?=$course_info['created']?></span></p>
          <p class="ml noborder"><b>学分：</b><span><?=$course_info['score']?></span></p>
        </div>
        <div class="messboxbottom">&nbsp;</div>
      </div>
 </div>