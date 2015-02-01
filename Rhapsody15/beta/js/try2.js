$(function() {
	
	$("body").imagesLoaded( function() {
		//images have loaded
		setTimeout(function() {
		      
		      console.log("hi!!");
		      var s = skrollr.init();
		      
			  $("body").removeClass('loading').addClass('loaded');
			  
		}, 5000);
	});        
                    
         
});