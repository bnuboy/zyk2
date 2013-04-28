<div class="noticewarp">

  <div class="noticetit">
    <h1><img src="/resource/images/book.gif" />我的课程</h1>
   
  </div>

  <div class="noticenwarp">

    <div class="databox">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="258">课程名称</th>
            
            <th width="100">角色</th>
            <th width="104">申请时间</th>
            <th>状态</th>
          </tr>
        </thead>
        <tbody id="resousdata">
         <?php foreach($list as $k => $v) { ?>
          <tr>
            <td><a href="/study/index?course_id=<?=$v['courseid']?>"><?=$v['coursename'];?></a></td>
            
            <td><?=$v['partname'];?></td>
            <td>2012-12-03</td>
            <td>
              <?php
                if($v['coursestatus'] == 'wait'){
                    echo "待审核";
                }else if($v['coursestatus'] == 'audit'){
                    echo '<span class="greenm">已通过</span>';
                }
              ?>
            </td>
          </tr>
          <?php } ?>
          
        </tbody>
      </table>
    </div>


  </div>

</div>