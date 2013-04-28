<!--<ul>
  <li class="pic">&nbsp;</li>
  <?php foreach( $left_menus as $menu ) {?>
    <li <?=$currentLeftMenuId == $menu['id'] ? 'class="over"' : ''?>><a href="/<?=$menu['menu_url']?>" title="<?=$menu['name'];?>"><?=$menu['name'];?></a></li>
  <?php }?>
  <li><img src="/resource/images/munbottom.jpg" /></li>
</ul>-->

<ul>
  <?php foreach( $left_menus as $menu ) {?>
    <li <?=$currentLeftMenuId == $menu['id'] ? 'class="over"' : ''?>><a href="/<?=$menu['menu_url']?>" title="<?=$menu['name'];?>"><?=$menu['name'];?></a></li>
  <?php }?>
</ul>