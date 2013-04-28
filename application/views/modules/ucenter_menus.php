<!--
<ul>
  <li class="over"><a href="/ucenter/index" title="个人中心">个人中心</a></li>
  <li><a href="/libresource/index" title="资源中心">资源中心</a></li>
  <li><a href="/study_plan/index" title="学习中心">学习中心</a></li>
  <li><a href="/bbs/index" title="论坛">论坛</a></li>
  <li class="bake"><a href="/" title="回首页">回首页</a></li>
</ul>
-->
<ul>
    <li class=""><a href="/" title="首页">首页</a></li>
    <?php foreach( $topMenus as $menu ) {?>
      <li <?=$menu['id'] == $currentTopMenuId ? 'class="over"' : ''?> ><a href="/<?=$menu['menu_url']?>" title="<?=$menu['name']?>"><?=$menu['name']?></a></li>
    <?php }?>
      
</ul>