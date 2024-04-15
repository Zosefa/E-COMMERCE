new WOW().init();
$(document).ready(function(){
    $(window).scroll(function(){	
		"use strict";	
		var scroll = $(window).scrollTop();
		if( scroll > 60 ){		
			$(".section-cart").addClass("section-cart-fixed");	
            $(".client").css({'display':'none'});	
            $(".section-cart .contenair div i").css({'color':'white !important'});
		} else {
			$(".section-cart").removeClass("section-cart-fixed");
            $(".client").css({'display':'block'});	
            $(".section-cart .contenair div i").css({'color':'black !important'});
		}
	});	
});
