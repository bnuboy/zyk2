<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<script>
  function close_win()
  {
      parent.$('.iframe').colorbox.close();
  }
  function check()
  {
      if($('#name').val()==''){
          alert('请填写标题');
          return false;
      }
  }
</script>
<title>高等职业教育教学资源中心</title>
</head>

<body>
<div class="Stc w400" style="width: 500px;">
  <div class="Stc-top"><h1>笔记分类 -> 新建分类</h1></div>
  <div class="Stc-bottom zcjg">
    <form action="/study_notecat/add" method="post" onSubmit="return check();">
  <table width="100%">
  <tr>
    <td>名称：</td>
    <td><label>
      <input name="name" type="text" id="name" size="30" />
    </label></td>
  </tr>
  <tr>
    <td nowrap="nowrap">描述：</td>
    <td width="25"><label>
      <textarea name="description" id="textarea" cols="35" rows="5"></textarea>
    </label></td>
  </tr>
</table>
       <br />

 <p align="right"><input type="reset" class="remove"  value="取消" onclick="return close_win();"/> 
    <input type="submit" class="save" value="添加" /></p> 
    </form>
  </div>
</div>
</body>
</html>

