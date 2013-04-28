function CalendarDblNum(num) {
  if (num < 10)
    return "0" + num; else
    return num;
  } 

  function ChangeDateOpt(obj, publishdate, start_time, end_time) {
  var now = new Date();
  var yy = now.getFullYear();
  var mm = now.getMonth();
  mm = mm + 1;
  var dd = now.getDate();
  var objto = document.getElementById(end_time);
  var objfrom = document.getElementById(start_time);
  var objpublishdate = document.getElementById(publishdate);

  if(objto != undefined)
    objto.value = yy + "-" + CalendarDblNum(mm) + "-" + CalendarDblNum(dd);
  if (obj.options[obj.selectedIndex].value == "day") {
    if (dd != 1)
      dd = dd - 1;
    else if (mm != 1)

    {
      mm = mm - 1;
      dd = GetMonthDay(mm - 1);
    }
    else
    {
      yy = yy - 1;
      mm = 12;
      dd = 31;
    }
  }
  else if (obj.options[obj.selectedIndex].value == "week") {
    if (dd > 7)
      dd = dd - 7;
    else if (mm != 1)

    {
      mm = mm - 1;
      dd2 = GetMonthDay(mm - 1);
      dd = dd2 + dd - 7;
    }
    else
    {
      yy = yy - 1;
      mm = 12;
      dd = 31 + dd - 7;
    }
  }
  else if (obj.options[obj.selectedIndex].value == "month") {
    if (mm != 1)
    {
      mm = mm - 1;
    }
    else
    {
      yy = yy - 1;
      mm = 12;
    }
  }
  else if (obj.options[obj.selectedIndex].value == "halfyear") {
    if (mm > 6)
    {
      mm = mm - 6;
    }
    else
    {
      yy = yy - 1;
      mm = 12 + mm - 6;
    }
  }
  else if (obj.options[obj.selectedIndex].value == "year")
    yy = yy - 1;
  else if (obj.options[obj.selectedIndex].value == "date")

  {
    objpublishdate.style.display = '';
    return ;
  }
  else
  {
    objfrom.value = "";
    objto.value = "";
    return ;
  }
  if (mm == 2 && dd > 29) {
    if (yy % 4 == 0)
      dd = 29; else
      dd = 28;
  }
  else if (mm == 4 || mm == 6 || mm == 9 || mm == 11) {
    if (dd == 31)
      dd = 30;
  }
  objfrom.value = yy + "-" + CalendarDblNum(mm) + "-" + CalendarDblNum(dd);
} 