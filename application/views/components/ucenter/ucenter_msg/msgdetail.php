
<div class="noticewarp">

  <div class="noticetit">
    <h1><img src="/resource/images/date.gif" />短信详情</h1>
  </div>

  <div class="noticenwarp" style="height:560px;">
    <!--
    <div class="noticekatebox">
      <div class="centdateback">
        <?=empty($prev['id'])? "上一条":"<a href='/ucenter_user_agenda/agendadetail/".$prev['id']."'>上一条</a>" ?>
        <?=empty($next['id'])? "下一条":"<a href='/ucenter_user_agenda/agendadetail/".$next['id']."'>下一条</a>" ?>
      </div>
    </div>  
    -->                      
      <input type="hidden" id="id" name="data[id]" value="<?=empty($info['id']) ? '' : $info['id'] ?>" />
      <div class="databox">
        <table width="100%" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th width="70">标题</th>
              <th><?=$data['msgtitle'];?></th>
            </tr>
          </thead>
          <tbody id="resousdata">
            <tr>
              <td width="70">发件人</td>
              <td><?=$data['sendusername'];?></td>
            </tr>
            <tr>
              <td width="70">收件人</td>
              <td>
                <?php 
                foreach($recevlist as $item){
                    echo $item['recevusername'] . ";";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70">内容</td>
              <td width="630">
                <p><?=$data['msgcontent'];?></p>
              </td>
            </tr>
          </tbody>                
        </table>
      </div>

      <div class="noticekatebox" id="sendbut" style="margin-top:10px; width:668px;">
        <div class="centdatedel"><input type="button" onclick="javascript:history.go(-1)" class="addbut" value="返回" /></div>
      </div>

  </div>

</div>

