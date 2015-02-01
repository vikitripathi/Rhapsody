$(function() {
	
	$("body").imagesLoaded( function() {
		//images have loaded
		setTimeout(function() {
		      
		      console.log("debugging true");
		      var s = skrollr.init();
		      
			  $("body").removeClass('loading').addClass('loaded');
			  $("#tree_pop1").hover(function(){
			  	$(this).animate({bottom:"-12%"},3000);
			  },function(){
			  	$(this).animate({bottom:"-18%"},3000);
			  });

			  if($("html,body").scrollTop()>0){
			  		// $("#archive").css("left",function(i){
			  		// 	return i*5+($("html,body").scrollTop());
			  		// });
				console.log();
			  }



		}, 3500);
	});        
                    
         
});