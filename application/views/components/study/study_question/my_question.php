<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script type="text/javascript">
    function deleteItems( )
    {
        if( $("#resousdata input[type=checkbox]:checked").length == 0 ){
            alert( "请至少选择一条记录" );
            return;
        }
        if ( !confirm( "你确定要删除吗？" ) )
            return;

        var post_str = $("#resousdata input[type=checkbox]").serialize();
        $.post("/study_question/delete/", post_str , function(ret){
            if ( ret.status == "ok" ) {
                alert("删除成功");
                location.reload();
            } else {
                alert(ret.data);
            }
        },"json");
    }
    function select_all()
    {
        
        if( $("#select_all:checked").length == 0 ){
            $("#resousdata input[type=checkbox]").attr("checked",false);
        }else{
            $("#resousdata input[type=checkbox]").attr("checked","checked");
        }
    }
  
   
</script>


<!--管理信息-->
                        <div class="noticesbox">
                <div class="noticewarp tea-cont">
                    
                <div class="noticetit tearch-nav">
                  <h2>在线答疑 > 我的问题&nbsp;</h2>                   
                  </div>
                    
                    <div class="noticenwarp">
                      <div class="noticekatebox">
                       <div class="dataediabox">
                      
                                <div class="ediacheck"><input type="checkbox" id="select_all" onchange="select_all();"></div>
                                <div class="ediacheckw">全选</div>
                                <div class="datadel"><a title="删除" href="javascript:;" onclick="deleteItems();">删除</a></div>
                         <div class="dataadd"><a title="我要提问" href="/study_question/my_tiwen">我要提问</a></div>
                       </div>
                     
                        <form action="/study_question/my_question" method="get">    
                        <div class="serchbox">
                                <div class="serchninput"><input type="text" name="title" value="搜索标题" onclick="search_input(this)" /></div>
                                <div class="serchbut"><input type="submit" id="serchadd" value="搜索" /></div>
                        </div>
                          </form>  
                      </div>
                        
                        <div class="databox">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                         <th width="72">&nbsp;</th>
                                        <th>问题标题</th>
                                        <th  width="130">提问时间</th>
                                        <th width="60">回答</th>
                                        <th width="130">最后回答时间</th>
                                    </tr>
                                </thead>
                                <tbody id="resousdata">
                                    <?php foreach($list as $key=>$val){?>
                                    <tr>
                                        <td><input type="checkbox" name="item_id[]" value="<?= $val[ 'id' ] ?>"/></td>
                                        <td><?=$val['title']?></td>
                                        <td><?=$val['qtime']?></td>
                                        <td><?=$val['count']?></td>
                                        <td><?=!empty($val['last_riqi']['last_time']) ? $val['last_riqi']['last_time'] : '0000:00:00 00:00:00';?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>                
                            </table>
                </div>
                        
                        <div class="noticekatebox">
                        <div class="dataediabox">
                      
                           <div class="ediacheck"></div>
                   
                          </div>
                          <div class="datapkate">
                          <div class="datajump">                                   
                            </div>
                              <?=$pagination?>
                          </div>
                            
                        </div>
                        
                  </div>
                    
                </div>
            </div>

            <!--管理信息 end-->