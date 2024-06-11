new WOW().init();
$(document).ready(function(){
    $(window).scroll(function(){	
		"use strict";	
		var scroll = $(window).scrollTop();
		if( scroll > 60 ){		
			$(".section-cart").addClass("section-cart-fixed");	
            $(".client").css({'display':'none'});	
			$(".lien a").css({'color':'white !important'});
            $(".panier").css({'color':'white !important'});
		} else {
			$(".section-cart").removeClass("section-cart-fixed");
            $(".client").css({'display':'flex'});	
            $(".panier").css({'color':'black !important'});
		}
	});	
});
