$(document).ready(function(){
	$(".default-form").on('click','.default-radio.star',function(){
		$(this).prevAll().addClass("active");
		$(this).addClass("active");
		$(this).nextAll().removeClass("active");
		$(".default-form .default-radio input[type=radio]").attr("checked",false);
		$(this).find("input[type=radio]").attr("checked","checked");
	})
})
