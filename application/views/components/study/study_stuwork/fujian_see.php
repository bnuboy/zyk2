<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<script language="javascript" src="/resource/js/ui.base.min.js"></script>
<script language="javascript" src="/resource/js/ui.tabs.min.js"></script>
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<link rel="stylesheet" href="/resource/css/jquery-ui.css" />



<!--管理信息-->
<div class="noticesbox kecheng">
    <div class="noticewarp">

        <div class="noticetit tearch-nav tearch-navts">
            <h1>附件作业</h1>           
        </div>
    
       <div class="noticenwarp">  
                <div class="noticekatebox">
                    <div class="addpword">类型：</div>
                    <div class="scselect" style="line-height: 32px;">
                       <input type="hidden" name="type_id" value="3" />
                            附件作业  
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">标题：</div>
                    <div class="addptit" style="line-height: 32px;"><?=$list['title']?></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">总分：</div>
                    <div class="addptits" style="line-height: 32px;"><?=$list['score']?></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">关联章节：</div>
                    <div class="scselect" id="select_id" style="line-height: 32px;">
                        <?php foreach($list['zhangjie_name'] as $key=>$val){?>
                        <?=$val['title']?>、
                        <?php }?>
                        <div id="menuContent" class="menuContent" style="display:none; position: absolute;">
                            <ul id="treeDemo" class="ztree" style="margin-top:0; width:180px; height: 300px;"></ul>
                        </div>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">时间：</div>
                    <div class="addptime" style="line-height: 32px;"><?=$list['start_time']?></div>
                    
                    <div class="addpnotwn">到　</div>
                    <div class="addptime" style="line-height: 32px;"><?=$list['end_time']?></div>
                    
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">附件：</div>  
                    <div style="line-height: 30px;">
        
          <a href="/study_stuwork/uploadfile/<?=$list['id']?>"><font color="#0084C4">下载</font></a>
     </div>
                </div>

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">内容：</div>
                    <div class="addpease" style="line-height: 32px;"><?=$list['content']?></div>
                </div>
           <form action="/study_stuwork/answer/<?=$list['id']?>" method="post" enctype='multipart/form-data'>
              <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn" style="line-height: 49px;" >上传答案：</div>
                    <div class="addpease" style="line-height: 32px;">
                   <input name="param" id="param" type="hidden" value=""/>
                      <iframe style="border:0px;padding-bottom: 2px;" src="/Uploadfiles/uploadfileform?fileid=param&allowed_extensions=jpg|gif|remvb|flv|rm|mp4|doc|xls&overwrite=true&encrypt_name=true&uppath=/upload/study_stuework/" width="400px" height="54px;">
                      </iframe>
                      <p><input type="submit" value="确认上传"/></p>
                    </div>
                </div>
           </form>
        </div>
        
      <!--<form>
       <table>
        <tbody>
         <tr>
          <td><div class="addpword">类型：</div></td>
          <td><div class="scselect" style="line-height: 32px;">
                       <input type="hidden" name="type_id" value="3" />
                            附件作业  
                    </div></td>
         </tr>
        </tbody>
       </table>
      </form>
      -->

    </div>
</div>
<!--管理信息 end-->