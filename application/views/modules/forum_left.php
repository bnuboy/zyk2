<!--
<div class="centerleft">
  <div class="peoness">
    <div class="peopic">
      <img src="/resource/images/indexperson.jpg" /></div>
    <div class="peonessr">
      <?php echo $user['name'];?><br/>
      <a href="/message"><img src="/resource/images/email.gif" /></a><br/>
      <span><a href="/message">条短信</a></span>
    </div>
    <div class="peonote">欢迎您登陆！<br/>角色：<?= $USER_TYPE[$user['type']] ?></div>
  </div>

  <div class="centerlink"><a href="#" title="数控技术专业">数控技术专业</a></div>

    <div class="menubox">
    <ul>
      <li class="pic">&nbsp;</li>
      <li class="over">
        <a href="http://www.gaozhi.com/course" title="我的课程">
        <img src="/resource/images/book.gif">我的课程</a>
      </li>
      <li>
        <a href="http://www.gaozhi.com/publicnotice" title="系统公告">
        <img src="/resource/images/bell.gif">系统公告</a>
      </li>
      <li>
        <a href="http://www.gaozhi.com/calender" title="日程安排">
        <img src="/resource/images/date.gif">日程安排</a>
      </li>
      <li>
        <a href="http://www.gaozhi.com/message" title="站内短信">
        <img src="/resource/images/email.gif">站内短信</a>
      </li>
      <li>
        <a href="http://www.gaozhi.com/user" title="个人信息">
        <img src="/resource/images/nessus.gif">个人信息</a>
      </li>
      <li>
        <a href="http://www.gaozhi.com/myresource" title="我的资源">我的资源</a>
      </li>
      <li>
        <a href="http://www.gaozhi.com/contacts" title="通讯录">通讯录</a>
      </li>
      <li>
        <a href="http://www.gaozhi.com/study_noanswer/index" title="学习中心">学习中心</a>
      </li>
      <li><img src="course_files/centerlravbto.jpg"></li>
    </ul>
    </div>
</div>
-->

<div class="centerleft">
  <!--左侧导航-->
  <div class="menubox">
    <ul>
      <li class="pic">&nbsp;</li>
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
      <li ><img src="/resource/images/centerlravbto.jpg" /></li>
    </ul>
  </div>
  <!--左侧导航 end-->
</div>