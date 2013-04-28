<ul>
  <?php foreach( $topMenus as $menu ) {?>
  <li <?=$menu['id'] == $currentTopMenuId ? 'class="over"' : ''?> ><a href="/<?=$menu['menu_url'];?>" title="<?=$menu['name'];?>"><?=$menu['name'];?></a></li>
  <?php }?>
</ul>