
<div class="noticewarp">

  <div class="noticetit">
    <h1><img src="/resource/images/date.gif" />日程安排</h1>
  </div>

  <div class="noticenwarp" style="height:560px;">

    <div class="noticekatebox">
      <div class="centdateback">
        <?=empty($prev['id'])? "上一条":"<a href='/ucenter_user_agenda/agendadetail/".$prev['id']."'>上一条</a>" ?>
        <?=empty($next['id'])? "下一条":"<a href='/ucenter_user_agenda/agendadetail/".$next['id']."'>下一条</a>" ?>
      </div>
    </div>                        
    <form action="/ucenter_user_agenda/changestatus" method="post">
      <input type="hidden" id="id" name="data[id]" value="<?=empty($info['id']) ? '' : $info['id'] ?>" />
      <div class="databox">
        <table width="100%" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th colspan="4"><?=$info['name'];?></th>
            </tr>
          </thead>
          <tbody id="resousdata">
            <tr>
              <td width="70">开始时间</td>
              <td width="270"><?=$info['start_time'];?></td>
              <td width="70">截止时间</td>
              <td width="270"><?=$info['end_time'];?></td>
            </tr>
            <tr>
              <td width="70">内容</td>
              <td colspan="3" width="630">
                <p><?=$info['content'];?></p>
              </td>
            </tr>
            <tr>
              <td width="70">状态</td>
              <td colspan="3">
          <select onchange="submitSearch()" name="data[status]" style="padding:5px" >
            <?php foreach ( $CALENDER_STATUS as $key=>$value ) { ?>
              <option <?= isset($info['status']) && $info['status'] == $key? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
            <?php } ?>
          </select></td>
          </tr>
          </tbody>                
        </table>
      </div>

      <div class="noticekatebox" id="sendbut" style="margin-top:10px; width:668px;">
        <div class="centdatedel"><input type="button" onclick="javascript:location.href='/ucenter_user_agenda/agendalist'" class="addbut" value="返回" /></div>
        <div class="centdatechange"><input type="submit"  class="addbut" value="更改状态" /></div>
      </div>

    </form>
  </div>

</div>

