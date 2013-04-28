<div class="centerleft">
   
   <div class="peoness">
    <div class="peopic">
      <img src="<?=!empty($this->user['face']) ? $this->user['face'] : '/resource/images/indexperson.jpg'?>" width="60px" height="60px"/></div>
    <div class="peonessr">
      <?php echo $this->user['name'];?><br/>
      <a href="/ucenter_msg/recevlist"><img src="/resource/images/email.gif" /></a><br/>
      <span>&nbsp;</span>
    </div>
    <div class="peonote">欢迎您登陆！<br/>角色：<?= $USER_TYPE[$this->user['type']] ?></div>
  </div>
  <div class="centerlink"><a href="#this" title="<?=isset($this->user['org']['name']) ? $this->user['org']['name'] : ''; ?>"><?=isset($this->user['org']['name']) ? $this->user['org']['name'] : ''; ?></a></div>
  
  <!--左侧导航-->
  <div class="menubox">
    <ul>
      <?php
      foreach ( $left_menus as $k=>$menu )
      {
      	if($menu['isshow'] == 0){
      ?>
        <li <?= $currentLeftMenuId == $menu['id'] ? 'class="over"' : '' ?> <?php if($k==0) echo "style='border-top:1px solid #bbbbbb';"?>>
          <a href="/<?=$menu['menu_url'] ?>" title="<?=$menu['name']?>">
          <?= !empty($menu['ico']) ? "<img src='".$menu['ico']."'>" : "";?>
          <?= $menu['name'] ?>
        </a>
      </li>
      <?php }} ?>
    </ul>
  </div>
  <!--左侧导航 end-->
</div>

