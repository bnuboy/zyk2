<div class="centerleft">
  
 

  <!--左侧导航-->
  <div class="menubox">

    <ul>
      
      <?php
      foreach ( $left_menus as $menu )
      {
      ?>
        <li <?= $currentLeftMenuId == $menu['id'] ? 'class="over"' : '' ?> >
          <a href="/<?= $menu['menu_url'] ?>" title="<?=$menu['name']?>">
          <?= $menu['name'] ?>
        </a>
      </li>
      <?php } ?>
      <!-- <li ><img src="/resource/images/centerlravbto.jpg" /></li>-->
    </ul>

  </div>


  <!--左侧导航 end-->
</div>