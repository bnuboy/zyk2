<script type="text/javascript" src="/resource/js/admin/common.js"></script>

<div class="noticewarp">

  <div class="noticetit">
    <h1>资源库[<span style="color:red;"><?php echo $library['name'];?></span>]-分类管理</h1>
  </div>
    
  <div class="noticenwarp">
     
    <div class="noticekatebox">
      <div class="dataediabox">
        <div class="manageadd"><a href="/admin_resource_library/catedit/<?php echo $library['id'];?>" title="新增分类">新增分类</a></div>
        <div class="manageadd"><a href="/admin_resource_library/librarylist" title="返回">返回</a></div>
      </div>
    </div>

    <div class="databox">

      <!--list start-->
      <table  id="list-table" width="100%" border=0 align=center cellpadding="5" cellspacing=1 class="tbtitle tbhover">
        <tr class="title">  
          <th align="center">分类名称</th>
          <th align="center">排序</th>
          <th align="center">操作</th>
        </tr>
        <?php
         $i = 0;
         foreach($cats as $key => $value){ 
         $i++;
        ?>
        <tr id="<?php echo $value['level'];?>_<?php echo $value['id'];?>" class="<?php echo $value['level'];?>">
          <td style="text-align:left;font-size:12px;"><img src="/resource/images/menu_minus.gif" id="icon_<?php echo $value['level'];?>_<?php echo $value['id'];?>" width="9" height="9" border="0" style="margin-left:<?php echo $value['level'];?>em;cursor:hand;" onclick="rowClicked(this)" /><?php echo $value['name'];?></td>
          <td style="text-align:left;"><?php echo $value['order'];?></td>
          <td>
            <img src='/public/style/admin/images/icon_edit.gif'><a href="/admin_resource_library/catedit/<?php echo $library['id'];?>/?id=<?php echo $value['id'];?>">编辑</a>&nbsp;
            <img src='/public/style/admin/images/icon_view.png'><a href="/admin_resource_library/catdel/<?php echo $library['id'];?>/<?php echo $value['id'];?>" onclick="javascript:return confirm('您确定要删除此分类吗?');">删除</a>
          </td>
        </tr>
        <?php } ?>
      </table>
      <!--list end-->

    </div>


  </div>

</div>

<script>
 var Browser = new Object();

Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);

var imgPlus = new Image();
imgPlus.src = "/resource/images/menu_plus.gif";

/**
 * 折叠分类列表
 */
function rowClicked(obj)
{
  // 当前图像
  img = obj;
  // 取得上二级tr>td>img对象
  obj = obj.parentNode.parentNode;
  // 整个分类列表表格
  var tbl = document.getElementById("list-table");
  // 当前分类级别
  var lvl = parseInt(obj.className);
  // 是否找到元素
  var fnd = false;
  var sub_display = img.src.indexOf('menu_minus.gif') > 0 ? 'none' : (Browser.isIE) ? 'block' : 'table-row' ;
  // 遍历所有的分类
  for (i = 0; i < tbl.rows.length; i++)
  {
      var row = tbl.rows[i];
      if (row == obj)
      {
          // 找到当前行
          fnd = true;
          //document.getElementById('result').innerHTML += 'Find row at ' + i +"<br/>";
      }
      else
      {
          if (fnd == true)
          {
              var cur = parseInt(row.className);
              var icon = 'icon_' + row.id;
              if (cur > lvl)
              {
                  row.style.display = sub_display;
                  if (sub_display != 'none')
                  {
                      var iconimg = document.getElementById(icon);
                      iconimg.src = iconimg.src.replace('plus.gif', 'minus.gif');
                  }
              }
              else
              {
                  fnd = false;
                  break;
              }
          }
      }
  }

  for (i = 0; i < obj.cells[0].childNodes.length; i++)
  {
      var imgObj = obj.cells[0].childNodes[i];
      if (imgObj.tagName == "IMG" && imgObj.src != '/resource/images/menu_arrow.gif')
      {
          imgObj.src = (imgObj.src == imgPlus.src) ? '/resource/images/menu_minus.gif' : imgPlus.src;
      }
  }
}
//-->
</script>