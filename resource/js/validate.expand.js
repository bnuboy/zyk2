//自定义注册用户
jQuery.validator.addMethod("isUsername", function(value, element) {  
	var patrn=/^[a-zA-Z]{1}([a-zA-Z0-9]|[._]){4,19}$/; 
	return this.optional(element) || (patrn.exec(value));    
});  

//手机号码验证
jQuery.validator.addMethod("MobilePhone", function(value, element){
    var patrn =/^(13[0-9]|15[0|2|3|6|7|8|9]|18[0|6|8|9])\d{8}$/;
    return this.optional(element) || (patrn.exec(value));
});

//电话号码验证
jQuery.validator.addMethod("Phone", function(value, element){
    var patrn =/^((\+?[0-9]{2,4}\-[0-9]{3,4}\-)|([0-9]{3,4}\-))?([0-9]{7,8})(\-[0-9]+)?$/;
    return this.optional(element) || (patrn.exec(value));
});

//比较大小
jQuery.validator.addMethod("compareSize", function(value, element, param){
    return  value >= jQuery(param).val();
});

//邮政编码
jQuery.validator.addMethod("Postalcode", function(value, element) {   
    var tel = /^[0-9]{6}$/;
    return this.optional(element) || (tel.test(value));
});

//身份证号码验证
jQuery.validator.addMethod("userCode", function(value, element){
    var patrn =/^\d{15}$|^\d{17}([0-9]|X)$/;
    return this.optional(element) || (patrn.exec(value));
});

//验证名称
jQuery.validator.addMethod("userName", function(value, element){
    var patrn =/^[a-zA-Z\u4e00-\u9fa5]/;
    return this.optional(element) || (patrn.exec(value));
});


//验证非法字符
jQuery.validator.addMethod("illegalSize", function(value, element){
    var patrn =/^[^<>&!@#$%^*()/'\|\\]+$/;
    return this.optional(element) || (patrn.exec(value));
});

//限制文本域字数() 
function checkLen(obj)
{
 var maxChars = 200;//最多字符数
 if (obj.value.length > maxChars)
 obj.value = obj.value.substring(0,maxChars);
 var curr = maxChars - obj.value.length;
 document.getElementById("td").innerHTML = curr.toString();
}

//验证手机电话
jQuery.validator.addMethod("PMone", function(value, element){
    var patrn =/(^(\d{3,4}-)?\d{7,8})$|(^(13[0-9]|15[0|2|3|6|7|8|9]|18[0|6|8|9])\d{8}$)/;
    return this.optional(element) || (patrn.exec(value));
});
