(function($){
	$(document).ready(function(){

		$('.slider').responsiSlider();

		$('.mobile-menu-trigger').click(function(e) {
			e.preventDefault();

			var el = $(this);
			var content = $('#header .top .menu');
			
			if ( content.is(':visible') ) {
				el.removeClass('open');
				content.removeClass('visible');

			} else {
				el.addClass('open');
				content.addClass('visible');
			}
		});
		
	});
})(jQuery); 
