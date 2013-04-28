<div class="centerleft">
  
 

  <!--左侧导航-->
  <div class="menubox">

    <ul>
      <li class="pic">&nbsp;</li>
      <?php
      foreach ( $left_menus as $menu )
      {
      ?>
        <li>
          <a href="/study_plan/index?cid=<?= $menu['id'] ?>" title="<?=$menu['title']?>">
          <?= $menu['title'] ?>
        </a>
      </li>
      <?php } ?>
      <li ><img src="/resource/images/centerlravbto.jpg" /></li>
    </ul>

  </div>


  <!--左侧导航 end-->
</div>