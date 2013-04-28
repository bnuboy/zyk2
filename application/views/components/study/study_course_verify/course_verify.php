<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<!--管理信息-->
                        <div class="noticesbox">
    	<div class="noticewarp">
        	
            <div class="noticetit">
            	<h1>选课审核</h1>
          </div>
            
            <div class="noticenwarp">
                <form action="/study_course_verify/edit_verify/<?=$course_id?>" method="post">
					<div class="shenh">
						<dl>
							<dt>请选择合适的审核方式：</dt>
              <dd><input name="course_verify" type="radio" value="1" <?=isset($course["course_verify"])?"checked='checked'":""?> <?=isset($course["course_verify"])  && $course["course_verify"]=='1'?"checked='checked'":""?> />允许任何人选课，不需要审核</dd>
              <dd><input name="course_verify" type="radio" value="2" <?=isset($course["course_verify"])  && $course["course_verify"]=='2'?"checked='checked'":""?>/>允许任何人选课，需要通过审核</dd>
							<dd><input name="course_verify" type="radio" value="3" <?=isset($course["course_verify"])  && $course["course_verify"]=='3'?"checked='checked'":""?>/>允许所属专业用户选课，不需要审核</dd>
							<dd><input name="course_verify" type="radio" value="4" <?=isset($course["course_verify"])  && $course["course_verify"]=='4'?"checked='checked'":""?>/>允许所属专业用户选课，需要通过审核</dd>
							<dd><input name="course_verify" type="radio" value="5" <?=isset($course["course_verify"])  && $course["course_verify"]=='5'?"checked='checked'":""?>/>用户填写正确的选课密钥来通过审核</dd>
              <dd>设置密钥：<input name="course_key" type="text" value="<?=isset($course['course_key'])? $course['course_key']:""?>"></dd>
              <dd><input name="course_verify" type="radio" value="6" <?=isset($course["course_verify"])  && $course["course_verify"]=='6'?"checked='checked'":""?> />不允许任何人选课</dd>
						</dl>
					</div>                    
                    <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                        <div class="addbutdel"><input type="reset" class="addbut" onclick="location.href='/study_course_verify'" value="取消" /></div>
                        <div class="addbutin"><input type="submit"  class="addbut" value="保存" /></div>
                    </div>
                
                </form>               
            </div>
            
        </div>
    </div>

            <!--管理信息 end-->
