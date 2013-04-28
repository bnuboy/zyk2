

<!--全站搜索-->
<div class="serchbox">
	<div class="serchrav">
    	<ul>
        	<li><a href="/public_search/search_resource" title="资源">资源</a></li>
            <li class="line">|</li>
            <li><a href="/public_search/search_user" title="用户">用户</a></li>
            <li class="line">|</li>
            <li class="over"><a href="/public_search/search_course" title="课程">课程</a></li>
            <li class="line">|</li>
            <li><a href="/public_search/search_org" title="院系">院系</a></li>
        </ul>
    </div>
    
    <div class="serchrnote">
    	<span class="noteorange"><?=$this->resourcecount;?></span>条资源<span class="noteblue"><?=$this->usercount;?></span>位用户<span class="notegreen"><?=$this->coursecount;?></span>门课程
    </div>

</div>

<div class="serchbg">
	<form action="" method="get">
	<div class="serchwarp"><input name="keyword" type="text" value="<?=!empty($keyword) ? $keyword : ''?>" /></div>
	<div class="serchbut"><input type="submit" name="serch" value="" /></div>
 <!--
 <div class="hotword">热词：<span>微书架、iStudy、颐达合创</span></div>
 -->
 </form>  
</div>

<!--全站搜索 end-->
<!--搜索列表-->
<div class="search_list">
<ul>
  <?php foreach($list as $k => $v){ ?>
    <li>
    <h2>
      <?php if(!empty($v['img'])) { ?>
      <img src="<?=$v['img'];?>" width="50px" height="50px">
      <?php } ?>
     <?=$v['name'];?></h2>
    <p class="gray">
      -- 课程代码：<?=$v['course_uuid'];?>  
      -- 课时：<?=$v['period'];?> 
      -- 简介：<?=$v['description'];?> 
     </p>
    <p> 状态：<a href="#this">
     <?php
     if($v['status'] == 'wait'){
         echo "待审核";
     }else if($v['status'] == 'audit'){
         echo "审核通过";
     }
     ?> 
     </a> 
     <em class="gray">2012-03-24</em></p>
    </li>
  <?php } ?>
</ul>
</div>

<div class="Spage"><?=$pagination;?></div>

<!--搜索列表 end-->
