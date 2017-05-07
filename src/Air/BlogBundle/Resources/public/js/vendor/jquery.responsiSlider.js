(function($){
	$.fn.responsiSlider = function(){
		return this.each(function(){
			var $slider = $(this);
			var $pagination = $slider.find('.pagination');
			var $nav = $slider.find('.nav');
			var $slidesList = $slider.find('.slides-container');
			var $slides = $slidesList.find('.slide');
			var $currSlide = $slides.first();
			var slidesCount = parseInt($slides.size());
			var intervalTime = 4*1000;
			var intervalId;
			
			function changeSliderPos(index){

				if(intervalId){
					clearInterval(intervalId);
				}

				var newPost = (index*-100);
				$slidesList.css('margin-left', (newPost+'%'));

				$currSlide = $slides.eq(index);

				selectPagination(index);

				intervalId = setInterval(function(){
					$nav.filter('.next').click();
				}, intervalTime);
			};

			function selectPagination(index){
				var $paginationItems = $pagination.find('li');
				$paginationItems.removeClass('active');
				$paginationItems.eq(index).addClass('active');
			}


			//generate pagination elements
			for(var i=0; i<slidesCount; i++){
				$pagination.append($('<li>'));
			}


			//set init styles
			$slidesList.css({
				'width': (slidesCount*100+'%'),
				'margin-left': '0%'
			});
			$slides.css('width', ((100/slidesCount)+'%'));


			//handle nav buttons click
			$nav.click(function(e){
				e.preventDefault();

				var $this = $(this);

				if($this.hasClass('next')){
					var $next = $currSlide.next();
					if($next.size() < 1){
						$next = $slides.first();
					}
				}else
				if($this.hasClass('prev')){
					var $next = $currSlide.prev();
					if($next.size() < 1){
						$next = $slides.last();
					}
				}

				var index = $next.index();

				changeSliderPos(index);
			});


			//handle pagination items click
			$pagination.on('click', 'li', function(e){
				e.preventDefault();

				var index = $(this).index();
				changeSliderPos(index);

			});


			//run slider
			$pagination.find('li').first().click();

		});
	};
})(jQuery); 