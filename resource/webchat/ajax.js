$(function(){
    getchart();
    getuser();
});
function writechart(){
    var id=$("#plan_id").val();
    var content=$("#intext").val();
    if(content==""){
        alert("请输入内容");
        return ;
    }
    var mydate=new Date();
    var nowTime=mydate.getHours()+':'+mydate.getMinutes()+':'+mydate.getSeconds();
    $.post("/study_plan/addchart", {
        id:id,
        content:content,
        time:nowTime
    },function(ret){
        if(ret.status=='ok'){
            $("#chat ul").append('<li class="userid" style="color:blue;font-size:14px;">'+ret.data["time"]+'&nbsp;&nbsp;'+ret.data["user"]+'</li><li>'+ret.data["content"]+'</li>');
            $("#chat").scrollTop(655350);
            $("#intext").val(" ");
        }
    },'json');
}

function getchart(){
    var id=$("#plan_id").val();
    $.post("/study_plan/getchart", {
        id:id
    },function(ret){
        if(ret.status=='ok'){
            $.each(ret.data,function (key,obj){
                $("#chat ul").append('<li style="color:blue;font-size:14px;">'+obj[0]+'&nbsp;&nbsp;'+obj[1]+'</li><li>'+obj[2]+'</li>');
            });
            $("#chat").scrollTop(655350);
        }
    },'json');
}
function readnew(){
    var id=$("#plan_id").val();
    $.post("/study_plan/readnew",{
        id:id
    },function(ret){
        if(ret.status=='ok'){
            $("#chat ul").append('<li class="userid" style="color:blue;font-size:14px;">'+ret.data[0]+'&nbsp;&nbsp;'+ret.data[1]+'</li><li>'+ret.data[2]+'</li>');
            $("#chat").scrollTop(655350);
        }else{
            return ;
        }
    },"json");
}

function getuser(){
    var id=$("#plan_id").val();
    $.post("/study_plan/getuser",{
        id:id
    },function(ret){
        if(ret.status=='ok'){
           $("#user").empty();
           $("#count").html("("+ret.data[1]+")");
           $.each(ret.data[0],function (key,obj){
              $("#user").append('<p>'+obj+'</p>');
            });
            
        }else{
            return ;
        }
    },"json");
}
function adduserlog(){
   var id=$("#plan_id").val();
   $.get("/study_plan/adduserlog/"+id,function(ret){});
}

window.setInterval(readnew,3000);
window.setInterval(getuser,3000);
window.setInterval(adduserlog,60*1000);