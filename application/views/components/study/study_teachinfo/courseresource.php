<div class="noticewarp">
  <div class="noticetit tearch-nav tearch-navts">
    <h1>课程资源</h1>
    <div><a href="#">返回</a></div>
  </div>
  <div class="noticenwarp">
    <div class="noticekatebox" style="width:730px;padding-right:0;">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox"/></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#" title="删除">删除</a></div>
        <div class="dataadd"><a href="#" title="重命名">重命名</a></div>
        <div class="dataadd"><a href="/study_teachinfo/leadcoursere" title="导入课程资源">导入课程资源</a></div>
        <div class="dataadd"><a href="/study_teachinfo/educecoursere" class="iframe cboxElement" title="导出课程">导出课程</a></div>
      </div>

      <div class="serchbox">
        <div class="serchninput"><input type="text" name="serch" value="搜索标题" /></div>
        <div class="serchbut"><input type="button" id="serchadd" value="搜索" /></div>
      </div>

    </div>
    <div class="databox databoxs" style="width:730px">
      <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th width="42">&nbsp;</th>
            <th width="226">名称</th>
            <th width="65">类型</th>
            <th width="65">大小</th>
            <th width="164">更新时间</th>
            <th width="74">下载次数</th>
            <th width="92">操作</th>
          </tr>
        </thead>
        <tbody id="resousdatas">
          <tr>
            <td><input type="checkbox"/></td>
            <td><a href="#">道路桥梁工程技术专业</a></td>
            <td>doc</td>
            <td>30K</td>
            <td>2012-06-15 11:21:29</td>
            <td>123</td>
            <td><a href="#">下载</a></td>
          </tr>
          <tr>
            <td><input type="checkbox"/></td>
            <td><a href="#">道路桥梁工程技术专业</a></td>
            <td>doc</td>
            <td>30K</td>
            <td>2012-06-15 11:21:29</td>
            <td>123</td>
            <td><a href="#">下载</a></td>
          </tr>
          <tr>
            <td><input type="checkbox"/></td>
            <td><a href="#">道路桥梁工程技术专业</a></td>
            <td>doc</td>
            <td>30K</td>
            <td>2012-06-15 11:21:29</td>
            <td>123</td>
            <td><a href="#">下载</a></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="noticekatebox" style="width:730px">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox"/></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#" title="删除">删除</a></div>
        <div class="dataadd"><a href="#" title="重命名">重命名</a></div>
      </div>

    </div>

  </div>
</div>

<link type="text/css" href="/resource/js/front/colorbox/colorbox.css" rel="stylesheet" />
<script src="/resource/js/front/colorbox/jquery.colorbox.js"></script>
<script>
  $(document).ready(function(){
    //Examples of how to assign the ColorBox event to elements


    $(".iframe").colorbox({iframe:true, innerWidth:403, innerHeight:331});
    $(".callbacks").colorbox({
      onOpen:function(){ alert('onOpen: colorbox is about to open'); },
      onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
      onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
      onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
      onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
    });

    //Example of preserving a JavaScript event for inline calls.
    $("#click").click(function(){
      $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
      return false;
    });
  });
</script>