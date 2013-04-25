/* Function to resize the height of the fancybox window */
(function($){ $.fn.resize = function(width, height) { 
	if (!width || (width == "inherit")) inner_width = parent.$("#fancybox-inner").width();
	if (!height || (height == "inherit")) inner_height = parent.$("#fancybox-inner").height();
	inner_width = width;
	outer_width = (inner_width + 14);
	inner_height = height;
	outer_height = (inner_height + 14);
	parent.$("#fancybox-inner").css({'width':inner_width, 'height':inner_height});
	parent.$("#fancybox-outer").css({'width':outer_width, 'height':outer_height});
	}
})(jQuery);

$(document).ready(function(){

	pasturl = parent.location.href;
	if ((pasturl == "http://www.criticalwire.com/logout") || (pasturl == "http://criticalwire.com/logout")) pasturl = "http://www.criticalwire.com";
	
	$("a.iframe#register").fancybox({
		'transitionIn'			:	'fade',
		'transitionOut'			:	'fade',
		'speedIn'						: 600,
		'speedOut'					: 350,
		'width'							: 450,
		'height'						: 385,
		'scrolling'					: 'no',
		'autoScale'					: false,
		'autoDimensions'		: false,
		'overlayShow'				: true,
		'overlayOpacity'		: 0.7,
		'padding'						: 7,
		'hideOnContentClick': false,
		'titleShow'					: false,
		'onStart'						: function() {
														$.fn.resize(450,385);
													},
		'onComplete'				: function() {
														$("#realname").focus();
													},
		'onClosed'					: function() {
														$(".warningmsg").hide();
														$(".errormsg").hide();
														$(".successfulmsg").hide();
													}
	});
	
	$("a.iframe#login").fancybox({
		'transitionIn'			:	'fade',
		'transitionOut'			:	'fade',
		'speedIn'						: 600,
		'speedOut'					: 350,
		'width'							: 400,
		'height'						: 250,
		'scrolling'					: 'no',
		'autoScale'					: false,
		'overlayShow'				: true,
		'overlayOpacity'		: 0.7,
		'padding'						: 7,
		'hideOnContentClick': false,
		'titleShow'					: false,
		'onStart'						: function() {
														$.fn.resize(400,250);
													},
		'onComplete'				: function() {
														$("#login_username").focus();
													},
		'onClosed'					: function() {
														$(".warningmsg").hide();
														$(".errormsg").hide();
														$(".successfulmsg").hide();
													}
	});
	
	$("#register").click(function() {
		$("#login_form").hide();
		$(".registertext").hide();
		$.fn.resize(450,385);
		$("label").addClass("#register_form label");
	});
	
	$("#login").click(function() {
		$.fn.resize(400,250);
		$("label").addClass("#login_form label");
	});
	
	$("#register_form").bind("submit", function() {
		$(".warningmsg").hide();
		$(".errormsg").hide();
		$(".successfulmsg").hide();
		if ($("#realname").val().length < 1 || $("#password").val().length < 1 || $("#username").val().length < 1) {
			$("#no_fields").addClass("warningmsg").show().resize(inherit,405);
			return false;
		}
		if ($("#password").val() != $("#password2").val()) {
			$("#no_pass_match").addClass("errormsg").show().resize();
			return false;
		}
	
		$.fancybox.showActivity();
	
		$.post(
			"../../admin/users/create_submit.php",
			{ realname:$('#realname').val(),
			  email:$('#email').val(),
			  username:$('#username').val(),
			  password:MD5($('#password').val()),
			  rand:Math.random() }
			,function(data){
				if(data == "OK"){
					$(".registerbox").hide();
					$.fancybox.hideActivity();
					$.fn.resize(inherit,300);
					$("#successful_login").addClass("successfulmsg").show();
				}
				else if(data == "user_taken"){
					$.fancybox.hideActivity();
					$("#user_taken").addClass("errormsg").show().resize(inherit,405);
					$("#username").val("");
				}
				else {
					$.fancybox.hideActivity();
					document.write("Well, that was weird. Give me a shout at webmaster@criticalwire.com.");
				}
				return false;
			});
			
		return false;
	});
	
	$("#login_form").bind("submit", function() {
			$(".warningmsg").hide();
			$(".errormsg").hide();
			$(".successfulmsg").hide();
			if ($("#login_username").val().length < 1 || $("#login_password").val().length < 1) {
			    $("#no_fields").addClass("warningmsg").show().resize(inherit,280);
			    return false;
			}
		
			$.fancybox.showActivity();
		
			$.post(
				"../../admin/users/login_submit.php",
				{ username:$('#login_username').val(),
				  password:MD5($('#login_password').val()),
				  rand:Math.random() }
				,function(data){
					if(data == "authenticated"){
						$(".loginbox").hide();
						$(".registertext").hide();
						$.fancybox.hideActivity();
						$("#successful_login").addClass("successfulmsg").show();
						parent.document.location.href=pasturl;
					}
					else if(data == "no_user"){
						$.fancybox.hideActivity();
						$("#no_user").addClass("errormsg").show().resize();
						$("#login_username").val("");
						$("#login_password").val("");
					}
					else if(data == "wrong_password"){
						$.fancybox.hideActivity();
						$("#wrong_password").addClass("warningmsg").show().resize();
						$("#login_password").val("");
					}
					else {
						$.fancybox.hideActivity();
						document.write("Well, that was weird. Give me a shout at webmaster@criticalwire.com.");
					}
					return false;
			});	
		return false;
	});
		
});
	
	