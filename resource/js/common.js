function checkAll(id) {
  if($('#'+id).attr('checked') === 'checked') {
    $('.check').attr('checked', 'checked');
  } else {
    $('.check').removeAttr('checked');
  }
}


/*
* 复选框赋值文本框
*/
function ChangeCheckbox(boxname,inputid){ 
    var str=""
    $("[name='"+boxname+"'][checked]").each(function(){ 
        str+=$(this).val()+","; 
    }) 
    if(str != "") str = str.substr(0, str.length-1); 
    document.getElementById(""+inputid+"").value = str; 
} 

/*
 *判断复选框是否选择
 */
function chkCheckBoxChs(objNam){
	  var obj = document.getElementsByName(objNam);
	  var objLen= obj.length;
	  var k = false;
	  for (i=0; i<objLen; i++){
		if(!k){
		    if (obj[i].checked==true){
		        k = true;
	        }else{
		        k = false;
		    }
		}
	 }
    return k;
}

/*
 * 复选框提示信息
 */
function checkDelMorMsg(formid, objNam, msg, msg2){    
    if(!chkCheckBoxChs(objNam)){
        alert(msg2);
        return false;
    }else{
        if(confirm(msg)){
            $('#'+formid+'').submit();
        }else{
            return false;
        }
    }
}

//按比例缩放图片
function zoom(image, width, height) {
    // 计算原图宽高比率
    var scale = image.width/image.height;
    if (image.width > width || image.height > height){
        // 按比例转换
        image.width = scale * height < width ? (height * scale) : width;
        image.height = scale * height >= width ? (width / scale) : height;
    }
}



/*
 * 等待处理效果 遮罩层
 */
function loading(msg){
  var msg = msg;
  if(msg == null){
     msg = '请稍候,正在提交信息...';
  }
	$.blockUI({ 
        message: '<img src=/resource/images/loading.gif><span style="font-size:12px;">'+msg+'</span>', 
        css: {
		border: '1px solid #99cccc',
		backgroundColor:'#f5f5f5',
		padding:'5px 0'
		} ,
		overlayCSS:  {  
			backgroundColor:'#fff',  
			opacity:        '0.5'  
		}
    });
}


/*
* 时间差
*/
function getGapDays(start_time,end_time) {  
    var regexp=/^(\d{1,4})[-|\.]{1}(\d{1,2})[-|\.]{1}(\d{1,2})$/;  
    var monthDays=[0,3,0,1,0,1,0,0,1,0,0,1];  
    regexp.test(start_time);  
    var start_timeYear=RegExp.$1;  
    var start_timeMonth=RegExp.$2;  
    var start_timeDay=RegExp.$3;  
  
    regexp.test(end_time);  
    var end_timeYear=RegExp.$1;  
    var end_timeMonth=RegExp.$2;  
    var end_timeDay=RegExp.$3;  
      
    if (validatePeriod(start_timeYear,start_timeMonth, start_timeDay, end_timeYear, end_timeMonth, end_timeDay)) {  
        var firstDate = new Date(start_timeYear, start_timeMonth, start_timeDay);  
        var secondDate = new Date(end_timeYear, end_timeMonth, end_timeDay);  
          
        var result = Math.floor((secondDate.getTime() - firstDate.getTime()) / (1000*3600*24));  
        for(j = start_timeYear; j < end_timeYear; j++) {  
            if (isLeapYear(j)) {  
                monthDays[1] = 2;  
            } else {  
                monthDays[1] = 3;  
            }  
            for(i = start_timeMonth -1 ; i < end_timeMonth; i++) {  
                result = result - monthDays[i]  
            }  
        }  
        return result;  
    } else {  
        return ;  
    }  
    if(validatePeriod(start_timeYear,start_timeMonth,start_timeDay,end_timeYear,end_timeMonth,end_timeDay)){  
        firstDate=new Date(start_timeYear,start_timeMonth,start_timeDay);  
         secondDate=new Date(end_timeYear,end_timeMonth,end_timeDay);  
        
         result=Math.floor((secondDate.getTime()-firstDate.getTime())/(1000*3600*24));  
         for(j=start_timeYear;j<=end_timeYear;j++){  
             if(isLeapYear(j)){  
                 monthDays[1]=2;  
             }else{  
                 monthDays[1]=3;     
             }  
             for(i=start_timeMonth-1;i<end_timeMonth;i++){  
                 result=result-monthDays[i];  
             }  
         }  
         return result;  
     }else{  
      return 'the first field must before the second date.';  
     }  
}  
  
//判断年份是否是闰年  
function isLeapYear(year) {  
    if (year % 4 == 0 && (year % 100 != 0) || (year % 400 == 0)) {  
        return true;  
    }  
    return false;  
}  
  
//判断前后两个日期  
function validatePeriod(fyear, fmonth, fday, byear, bmonth, bday) {  
    if (fyear < byear) {  
        return true;  
    } else if (fyear == byear) {  
        if (fmonth < bmonth) {  
            return true;  
        } else if (fmonth == bmonth) {  
            if (fday <= bday) {  
                return true;  
            } else {  
                return false;  
            }  
        } else {  
            return false;  
        }  
    } else {  
        return false;  
    }  
}  