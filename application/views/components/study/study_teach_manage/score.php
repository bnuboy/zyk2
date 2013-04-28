<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<!--管理信息-->
                        <div class="noticesbox">
    	<div class="noticewarp">
        	
            <div class="noticetit">
            	<h1>生成成绩簿</h1>
          </div>
            
            <div class="noticenwarp noticenwarps">
            	<form>
            		<div class="cjb">
						<h2>1. 选择统计对象</h2>
						<dl>
							<dt>作业</dt>
							<dd>已选择<span>3</span>条作业　<a href="#">修改</a>　<a href="#">清空</a></dd>
						</dl>
						<dl>
							<dt>作品</dt>
							<dd><a href="#">选择</a></dd>
						</dl>
						<dl>
							<dt>学生&nbsp;&nbsp;<input name="" type="checkbox" value="" />&nbsp;&nbsp;<span>全选</span></dt>
							<dd><input name="" type="checkbox" value="" />&nbsp;&nbsp;数控一班&nbsp;&nbsp;<input name="" type="checkbox" value="" />&nbsp;&nbsp;数控一班&nbsp;&nbsp;<a href="#">选择</a></dd>
						</dl>
					</div>
            		<div class="cjb">
						<h2>2. 选择统计方式</h2>
						<dl>
							<dt>个人分数统计&nbsp;&nbsp;<input name="" type="checkbox" value="" />&nbsp;&nbsp;<span>全选</span></dt>
							<dd><input name="" type="checkbox" value="" />&nbsp;&nbsp;总分　</dd>
							<dd><input name="" type="checkbox" value="" />&nbsp;&nbsp;平均分</dd>
							<dd><input name="" type="checkbox" value="" />&nbsp;&nbsp;加权总计</dd>
						</dl>
						<dl>
							<dt>作业及测验统计&nbsp;&nbsp;<input name="" type="checkbox" value="" />&nbsp;&nbsp;<span>全选</span></dt>
							<dd>
								<input name="" type="checkbox" value="" />&nbsp;&nbsp;题量　&nbsp;&nbsp;
								<input name="" type="checkbox" value="" />&nbsp;&nbsp;最高分&nbsp;&nbsp;
								<input name="" type="checkbox" value="" />&nbsp;&nbsp;最低分&nbsp;&nbsp;
								<input name="" type="checkbox" value="" />&nbsp;&nbsp;总分　&nbsp;&nbsp;
								<input name="" type="checkbox" value="" />&nbsp;&nbsp;不及格
							</dd>
							<dd>
								<input name="" type="checkbox" value="" />&nbsp;&nbsp;优秀　&nbsp;&nbsp;
								<input name="" type="checkbox" value="" />&nbsp;&nbsp;良好　&nbsp;&nbsp;
								<input name="" type="checkbox" value="" />&nbsp;&nbsp;中等　&nbsp;&nbsp;
								<input name="" type="checkbox" value="" />&nbsp;&nbsp;及格　&nbsp;&nbsp;
								<input name="" type="checkbox" value="" />&nbsp;&nbsp;不及格
							</dd>
						</dl>
					</div>
					<div class="cjb">
						<h2>3. 选择生成方式</h2>
						<dl>
							<dd><input name="" type="checkbox" value="" />&nbsp;&nbsp;网页　　<input name="" type="checkbox" value="" />&nbsp;&nbsp;Excel文件</dd>
						</dl>
						
					</div>
                    <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                        <div class="addbutdel"><input type="reset" name="reset" class="addbut" value="取消" /></div>
                        <div class="addbutin"><input type="button" name="send" class="addbut" value="提交" onclick="subMit()" /></div>
                        <script type="text/javascript">
						 function subMit(){
							 window.location.href="成绩表统计信息.html"
						}
                        </script>
                    </div>
                
                </form>               
            </div>
            
        </div>
    </div>

            <!--管理信息 end-->