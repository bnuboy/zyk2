// JavaScript Document
$(document).ready(function(){
					$("#dshtab li").click(function(){
						          $(this).siblings().removeClass("dshqy_hover");
												 $(this).addClass('dshqy_hover');
													    })
						     $("#dshtab li").click(function(){
															 $index=$("#dshtab li").index(this);
															 $(".guotab").hide();
															 $(".guotab:eq("+$index+")").show();
															 
															 })
						   })
								