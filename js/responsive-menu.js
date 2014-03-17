jQuery(function( $ ){

	// Enable responsive menu icon for mobile
	$("header .genesis-nav-menu").addClass("responsive-menu").before('<div id="responsive-menu-icon"></div>');

	$("#responsive-menu-icon").click(function(){
		$("header .genesis-nav-menu").slideToggle();
	});

	$(window).resize(function(){
		if(window.innerWidth > 768) {
			$("header .genesis-nav-menu").removeAttr("style");
		}
	});

});