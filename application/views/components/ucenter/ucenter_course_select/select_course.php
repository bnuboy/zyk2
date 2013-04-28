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
      if($('#class_id').val()==''){
          alert('请选择班级');
          return false;
      }
      if($('#part_id').val()=='')
          {
              alert('请选择角色');
              return false;
          }
  }
</script>
<title>高等职业教育教学资源中心</title>
</head>

<body>
<div class="Stc w400" style="width: 500px;height:205px;">
  <div class="Stc-top"><h1>课程选择</h1></div>
  <div class="Stc-bottom zcjg">
      <form action="/ucenter_course_select/add/<?=$id?>" method="post" onSubmit="return check();">
  <table width="100%">
  <tr>
    <td>名称：</td>
    <td><label>
      <?=$info['name']?>
    </label></td>
  </tr>
  <tr>
    <td nowrap="nowrap">班级：</td>
    <td width="25"><label>
      <select name="course_class_id" id="class_id">
          <option value=''>--请选择班级--</option>
          <?php foreach($class as $key=> $val){?>
          <option value="<?=$val['id']?>"><?=$val['name']?></option>
          <?php }?>
      </select>
    </label></td>
  </tr>
      <tr>
    <td nowrap="nowrap">角色：</td>
    <td width="25"><label>
      <select name="course_part_id" id="part_id">
          <option value=''>--请选择角色--</option>
          <?php foreach($part as $key=> $val){?>
          <option value="<?=$val['id']?>"><?=$val['name']?></option>
          <?php }?>
      </select>
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

