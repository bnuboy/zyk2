<link type="text/css" href="/resource/css/index.css" rel="stylesheet" />
<style>
  .middlebox{padding:0 !important}
</style>
<div class="middlebox">

  <div class="adminness">
    <div class="adminpic">
      <img height="76" width="62" src="<?=!empty($this->admin['face']) ? $this->admin['face'] : '/resource/images/indexperson.jpg'?>"></div>
    <div class="adminnwness">
      <?php
      date_default_timezone_set( 'asia/shanghai' );

      function cnWeek( $date )
      {
        $arr = array('天', '一', '二', '三', '四', '五', '六');
        return $arr[ date( 'w', strtotime( $date ) ) ];
      }
      ?>
      今天是<?= date( 'Y' ) ?>年<?= date( 'm' ) ?>月<?= date( 'd' ) ?>日&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;星期<?= cnWeek( date( 'Y-M-d' ) ) ?><br>
      <?= $this->admin['name'] ?>（<?= $USER_TYPE[ $this->admin['type'] ] ?>），<?php
      $date = date( 'G' );
      if ( $date < 11 )
        echo '早上好';
      else if ( $date < 13 )
        echo '中午好';
      else if ( $date < 17 )
        echo '下午好';
      else
        echo '晚上好';
      ?>！<br>
      您上次登陆的时间是：2012年2月5日14点50分<br>
    </div>
  </div>

  <div class="downresoursbox">
    <h1>今日下发资源（5）</h1>
  </div>

  <div class="resourdata">
    <table cellspacing="0" cellpadding="0" width="513">
      <thead>
        <tr>
          <th width="240">资源名称</th>
          <th width="125">下发时间</th>
          <th>审核|编辑</th>
        </tr>
      </thead>
      <tbody id="resousdata">
        <tr class="layeven">
          <td>常用机械零部件造型与测绘</td>
          <td>2012-2-24&nbsp;&nbsp;&nbsp;12:55</td>
          <td><a title="审核" href="#"><img height="20" width="20" src="/resource/images/edia.gif"></a><a href="#"><img height="20" width="20" title="编辑" src="/resource/images/ediapen.gif"></a></td>
        </tr>
        <tr class="layodd">
          <td>常用机械零部件造型与测绘</td>
          <td>2012-2-24&nbsp;&nbsp;&nbsp;12:55</td>
          <td><a title="审核" href="#"><img height="20" width="20" src="/resource/images/edia.gif"></a><a href="#"><img height="20" width="20" title="编辑" src="/resource/images/ediapen.gif"></a></td>
        </tr>
        <tr class="layeven">
          <td>常用机械零部件造型与测绘</td>
          <td>2012-2-24&nbsp;&nbsp;&nbsp;12:55</td>
          <td><a title="审核" href="#"><img height="20" width="20" src="/resource/images/edia.gif"></a><a href="#"><img height="20" width="20" title="编辑" src="/resource/images/ediapen.gif"></a></td>
        </tr>
        <tr class="layodd">
          <td>常用机械零部件造型与测绘</td>
          <td>2012-2-24&nbsp;&nbsp;&nbsp;12:55</td>
          <td><a title="审核" href="#"><img height="20" width="20" src="/resource/images/edia.gif"></a><a href="#"><img height="20" width="20" title="编辑" src="/resource/images/ediapen.gif"></a></td>
        </tr>
        <tr class="layeven">
          <td>常用机械零部件造型与测绘</td>
          <td>2012-2-24&nbsp;&nbsp;&nbsp;12:55</td>
          <td><a title="审核" href="#"><img height="20" width="20" src="/resource/images/edia.gif"></a><a href="#"><img height="20" width="20" title="编辑" src="/resource/images/ediapen.gif"></a></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="ediaresoursbox">
    <h1>今日下发资源（5）</h1>
  </div>

  <div class="resourdata thcolor">
    <table cellspacing="0" cellpadding="0" width="513">
      <thead>
        <tr>
          <th width="240">资源名称</th>
          <th width="125">下发时间</th>
          <th>审核|编辑</th>
        </tr>
      </thead>
      <tbody id="ediaresousdata">
        <tr class="layeven">
          <td>常用机械零部件造型与测绘</td>
          <td>2012-2-24&nbsp;&nbsp;&nbsp;12:55</td>
          <td><a title="审核" href="#"><img height="20" width="20" src="/resource/images/edia.gif"></a><a href="#"><img height="20" width="20" title="编辑" src="/resource/images/ediapen.gif"></a></td>
        </tr>
        <tr class="layodd">
          <td>常用机械零部件造型与测绘</td>
          <td>2012-2-24&nbsp;&nbsp;&nbsp;12:55</td>
          <td><a title="审核" href="#"><img height="20" width="20" src="/resource/images/edia.gif"></a><a href="#"><img height="20" width="20" title="编辑" src="/resource/images/ediapen.gif"></a></td>
        </tr>
        <tr class="layeven">
          <td>常用机械零部件造型与测绘</td>
          <td>2012-2-24&nbsp;&nbsp;&nbsp;12:55</td>
          <td><a title="审核" href="#"><img height="20" width="20" src="/resource/images/edia.gif"></a><a href="#"><img height="20" width="20" title="编辑" src="/resource/images/ediapen.gif"></a></td>
        </tr>
        <tr class="layodd">
          <td>常用机械零部件造型与测绘</td>
          <td>2012-2-24&nbsp;&nbsp;&nbsp;12:55</td>
          <td><a title="审核" href="#"><img height="20" width="20" src="/resource/images/edia.gif"></a><a href="#"><img height="20" width="20" title="编辑" src="/resource/images/ediapen.gif"></a></td>
        </tr>
        <tr class="layeven">
          <td>常用机械零部件造型与测绘</td>
          <td>2012-2-24&nbsp;&nbsp;&nbsp;12:55</td>
          <td><a title="审核" href="#"><img height="20" width="20" src="/resource/images/edia.gif"></a><a href="#"><img height="20" width="20" title="编辑" src="/resource/images/ediapen.gif"></a></td>
        </tr>
      </tbody>
    </table>
  </div>

</div>

<div class="messbox">

  <div class="messboxbg">

    <div class="messtit">
      <h1>版本信息</h1>
    </div>

    <div class="nessnword">
      <ul>
        <li>用户您好，您目前使用得是2012.4.44版本软件，目前有功能可以更新。</li>
        <li>2012.5.6版本可更新，更新地址：<br><a title="www.123456.com" href="#">www.123456.com</a></li>
      </ul>
    </div>

    <div class="messtit messtittop">
      <h1>版本信息</h1>
    </div>

    <div class="nessnword">
      <ul>
        <li>用户您好，您目前使用得是2012.4.44版本软件，许可证信息为：12545 449556   1234566 </li>
        <li>备用许可证号：1356 567788 45789</li>
      </ul>
    </div>

    <div class="messtit messtittop">
      <h1>官方公告</h1>
    </div>

    <div class="newsrlist">
      <ul>
        <marquee direction="up" onmouseover=this.stop() onmouseout=this.start() scrollamount=3>
        <?php foreach ( $notices as $k => $v ) { ?>
          <li><a title="<?= $v['comment']; ?>" href="#this"><?= $v['title']; ?></a><span><?= date( "y-m", strtotime( $v['created'] ) ) ?></span></li>
        <?php } ?>
        </marquee>
      </ul>
    </div>

  </div>

  <div class="messtit messtittop">
    <h1>客服中心</h1>
  </div>

  <div class="nessnword"><img height="28" width="266" alt="服务电话" src="/resource/images/seviephone.jpg"></div>

</div>