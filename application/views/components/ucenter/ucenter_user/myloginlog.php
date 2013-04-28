  <div class="noticewarp">
                    
                    <div class="noticetit">
                        <h1><img src="/resource/images/nessus.gif" />登录记录</h1>
                    </div>
                    
                    <div class="noticenwarp">
                    	<div class="cendatarav">
                        	<ul>
                            <li><a href="/ucenter_user/myinfoedit" title="资料修改">资料修改</a></li>
                            <li><a href="/ucenter_user/repassword" title="密码修改">密码修改</a></li>
                            <li class="over"><a href="/ucenter_user/myloginlog" title="登录记录">登录记录</a></li>
                          </ul>
                        </div>                        
                        
                        <!--
                        <div class="noticekatebox" style="padding-top:0px;">
                            <div class="centlistt">起始时间</div> 
                            <div class="centdatebut"><a href="#"><strong>show</strong></a></div>
                            <div class="centdatein"><input type="text" name="show" /></div>
                            <div class="centdatenote">年-月-日</div>
                            
                            <div class="centlistt">截至时间</div> 
                            <div class="centdatebut"><a href="#"><strong>show</strong></a></div>
                            <div class="centdatein"><input type="text" name="show" /></div>
                            <div class="centdatenote">年-月-日</div>
                            <div class="centnums"><a href="#">统计</a></div>
                        </div>
                        -->
                        
                        <div class="noticekatebox">
                            
                            <div class="centnumsw"><!--登陆时长<span>1234567</span>小时&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->登陆次数<span><?=$count;?></span>次</div>
                            
                            <?=$pagination;?>
                            
                        </div>
                        
                        <div class="databox">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                      <th width="261">登陆用户</th>
                                      <th width="221">登入IP</th>
                                      <th width="221">登入时间</th>
                                    </tr>
                                </thead>
                                <tbody id="resousdata">
                                    <?php foreach($list as $k => $v){ ?>
                                    <tr>
                                      <td><?=$this->user['name'];?></td>
                                      <td><?=$v['login_ip'];?></td>
                                      <td><?=$v['login_time'];?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>                
                            </table>
                        </div>
                        
                        <div class="noticekatebox">
                            
                            <?=$pagination;?>
                            
                        </div>
                        
                    </div>
                    
                </div>