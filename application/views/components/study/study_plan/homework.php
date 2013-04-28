<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
        <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
        <title>高等职业教育教学资源中心--个人中心</title>
        <script>
          function submit( ){
                var ss=$("#popTis input[type='checkbox']:checked");
                var id_attr='';
                $.each(ss,function(key,obj){
                   id_attr+=$(obj).val()+',';
                });
                 id_attr = id_attr.substr(0,id_attr.length-1);
                parent.addto(id_attr);
                parent.$(".iframe").colorbox.close();
              }
            </script>
    </head>
    <body>
    <div class="pop">
          <div class="popTit">
            <span class="floatL">关联作业</span>
            <span class="floatR"></span>
          </div>
          <div class="popCont popCont2 popConts">
            <div class="popTis" ></div>
            <dl id="popTis">
              <?php foreach($list as $val){?>
              <dd><input name="item_id[]" type="checkbox" value="<?=$val['id']?>" <?= !empty( $relevance ) && in_array( $val[ 'id' ], $relevance )? ' checked=""' : ''?>/><?=$val['title']?></dd>
              <?php }?>
            </dl>
          </div>
          <div class="popDown">
            <span><a href="#this" onclick="windowclose()">取消</a></span>
            <div class="dataadd"><a href="javascript:;" onclick="return submit();" title="保存">保存</a></div>
          </div>
     </div>
</body>
</html>

<script language="javascript">
    function windowclose(){
        parent.$('.iframe').colorbox.close();
    }
</script>


