      <div class="noticesbox kecheng">
        <div class="noticewarp">
          <div class="noticetit tearch-nav tearch-navts">
            <h1>共享课程资源</h1>
            <div><a href="/study_course_resource/" class="blue" href="#">&lt;&lt;返回</a></div>
            </div>
              <div class="cendatarav">
                   <ul>
                      <li class="over"><a href="study_course_resource/upfile/<?=$this->course['id']?>" title="上传">上传</a></li>
                      <li><a href="/study_course_resource/anthorcourse" title="其他课程资源">其他课程资源</a></li>
                    </ul>
                 </div>
            <div class="noticenwarp noticenwarpts">
                <form action="/study_course_resource/upfile" method="post">
                    <div class="noticekatebox noticekateboxta">
                      请从本地选择一个课程资源包上传：
                  	</div>
                    <div class="noticekatebox noticekateboxta">
                           <input id="param" name="param" type="hidden" value=""/>
                           <input id="course_id" name="course_id" type="hidden" value="<?=isset($course_id)? $course_id:""?>"/>
                           <input id="fileinfoid" name="allparam" type="hidden" value=""/>
                           <iframe style="border:0px;padding-bottom: 20px;" src="/Uploadfiles/uploadfileform?fileid=param&allowed_extensions=zip&overwrite=True&encrypt_name=False&fileinfoid=fileinfoid&uppath=/upload/course_resource/" width="760px" height="54px;">
                           </iframe>
                    </div>

                    <div class="noticekatebox" id="sendbut" style="margin-top:15px;">
                        <div class="addbutdel"><input type="button"  class="addbut" onclick="location.href='/study_course_resource'"value="取消" /></div>
                        <div class="addbutin"><input type="submit" class="addbut" value="导入" /></div>
                    </div>

                </form>
            </div>

        </div>
      </div>