jQuery(document).ready(		
		function($) {
			 "use strict";
			$('#fullwidth, #primary, #media-wrapper').fadeTo('slow', 1);
			$('.widget-title').addClass(title_picker);			 
			$('.slide-title, .slide-info, .slide-date').addClass(widget_fx);
			$('.bf-blog-posts-thumb img, .blog-post-image img, .featured-posts-image img').addClass(image_effect);

		//widget-title	

			$('.widget-title, .comment-count').each(function () {
				var html = $(this).html();
				var split = html.split(" ");
				if (split.length > 1) {
					split[split.length - 1] = "<span class='last-word'>" + split[split.length - 1] + "</span>";
					$(this).html(split.join(" "));
				}	else
				{}
			});	
					 
			$('.slide-title h2 a, .tv-featured-title').each(function () {
				var html = $(this).html();
				var split = html.split(" ");
				if (split.length > 3) {
					split[split.length - 1] = "<span class='last-word'>" + split[split.length - 1] + "</span>";
					split[split.length - 2] = "<span class='last-word'>" + split[split.length - 2] + "</span>";
					$(this).html(split.join(" "));
				}
				else
				{}
			});			 
			 
			 
			 
			 if ($('.tabber-container').length){
				 //tabs
			$('.tabber-container').each(function() {
				$(this).find(".tabber-content").hide();
				$(this).find("ul.tabs li:first").addClass("active").show();
				$(this).find(".tabber-content:first").show();
			});
			$("ul.tabs li").click(
					function(e) {
						$(this).parents('.tabber-container').find("ul.tabs li")
								.removeClass("active");
						$(this).addClass("active");
						$(this).parents('.tabber-container').find(
								".tabber-content").hide();
						var activeTab = $(this).find("a").attr("href");
						$(this).parents('.tabber-container').find(activeTab)
								.fadeIn();
						e.preventDefault();
					});
			$("ul.tabs li a").click(function(e) {
				e.preventDefault();
			});
			 }
            //ticker

			function tick(){
			$("ul.ticker-list li:first").animate({marginLeft : '-200px'},400,function() {$(this).detach().appendTo("ul.ticker-list").removeAttr("style");
				});
			}
			
			function tak(){
			$("ul.ticker-list li:first").animate({marginLeft : '200px'},400,function() {$("ul.ticker-list li:last-child").detach().prependTo("ul.ticker-list");
			$("ul.ticker-list li").removeAttr("style");
				});
			}		
			$('.ticker-right').click(function() {tick();});
			$('.ticker-left').click(function() {tak();});
				
			var interval = setInterval(tick, 5000);
			   
				$('ul.ticker-list li, .ticker-left, .ticker-right').hover(function() {
					clearInterval(interval);
				}, function() {
					interval = setInterval(tick, 5000);
				});
			
			
 		//fixed-menu	
		var aboveHeight = $('#nav-wrapper').offset().top;
        $(window).scroll(function(){
                if ($(window).scrollTop() > aboveHeight){
                $('.show-menu').addClass('fixed-menu');
                } else {
                $('.show-menu').removeClass('fixed-menu');
                }
				
		});
		
				
			//Masonry script
if ($('.blog-category').length){
			var bigcategorymas = $('.blog-category').masonry({
				columnWidth: 1,
				itemSelector: '.blog-category li'
			});		
			bigcategorymas.imagesLoaded( function() {
 				bigcategorymas.masonry();
			});}

if ($('#fullwidth').length){			
			var fullwidthmas = $('#fullwidth').masonry({
			columnWidth: 1,
			itemSelector: '.home-widget',
			});
			fullwidthmas.imagesLoaded( function() {
 	setTimeout(function() {fullwidthmas.masonry();

		setTimeout(function() {
			$('#fullwidth .home-widget').each(function(){
				var fullwidthright = $("#fullwidth").offset().left + $("#fullwidth").outerWidth();
				var widgetright = $(this).offset().left + $(this).outerWidth();
				if(widgetright == fullwidthright){
					$(this).addClass('right-side');
					};
				});
			},500);
		}, 500);
});}

if ($('.bf-blog-posts-category').length){			
			var blogmas = $('.bf-blog-posts-category').masonry({
			columnWidth: 1,
			itemSelector: '.bf-blog-posts-category li'
			});
			blogmas.imagesLoaded( function() {
 				blogmas.masonry();
			});}

		//sidebar height
		
	function sidebarheight() {		
		 $('#main').imagesLoaded( function() {
					var fullsize = $('#wrapper').width();
					var primaryheight = $('#primary').height();	
					if(fullsize < 1007 && fullsize > 671){
						$('#secondary').css('min-height', 0);
						}
					else if(fullsize < 671){
						$('#secondary').css('min-height', 0);
						}	
					else if (fullsize > 1007){	
						$('#secondary').css('min-height',primaryheight);
						}
		
		});}
		sidebarheight();
		$(window).resize(sidebarheight);

			
 		//fixed-sidebar-last widget

       $('#main').imagesLoaded( function() {
		if ($('#secondary .home-widget:last-child').length){ 
		
		var widgetaboveHeight = $('#secondary .home-widget:last-child ').offset().top - 34;
		if ($('#navigation').hasClass('show-menu')){$('#secondary .home-widget:last-child').addClass('navigation-has-menu');}
		
			var primaryheight = $('#primary').height();	
			var secondaryheight = 0;
				$('#secondary .home-widget').each(function(){
					secondaryheight += $(this).height();
				});

		
		//fixed widget in #secondary area			
        $(window).scroll(function(){	

				if(	primaryheight - secondaryheight < 0){
					$('#secondary .fixed-widget').css('position','relative');
					$('#secondary .home-widget:last-child ').css('top','0');
					
				}else{
                if ($(window).scrollTop() > widgetaboveHeight){
               		$('#secondary .home-widget:last-child').addClass('fixed-widget');
                } else {
                	$('#secondary .home-widget:last-child ').removeClass('fixed-widget');
                }		
				
				if ($('.footer-wrap').offset().top - ($(window).scrollTop() + $('#fullwidth ').height() + $('#secondary .home-widget:last-child').height()+$('#navigation.fixed-menu').height()) < 0){
                $('#secondary .home-widget:last-child ').css('top',$('.footer-wrap').offset().top - ($(window).scrollTop() + $('#fullwidth ').height() + $('#secondary .home-widget:last-child').height()));
				
                }	else  {
				$('#secondary .home-widget:last-child ').css('top','')
				}}
			});
		};});
		
			//Responsive widgets	
			
		function checkWidth() {
			var fullsize = $('#wrapper').width();

			if(fullsize < 1007 && fullsize > 671){
				$('.home-widget.three-thirds').removeClass('three-thirds').addClass('three-thirds-off two-thirds');
				$('.two-thirds-off').removeClass('one-third two-thirds-off').addClass('two-thirds');
				$('#fullwidth .home-widget.one-third').removeClass('one-third').addClass('one-third-off two-thirds');
				$('#ticker-list-box').css('width', 672);
				}
			else if(fullsize < 671){
				$('.home-widget.three-thirds').removeClass('three-thirds').addClass('three-thirds-off two-thirds');
				$('.home-widget.two-thirds').removeClass('two-thirds').addClass('two-thirds-off one-third');
				$('#fullwidth .one-third-off.two-thirds').removeClass('two-thirds one-third-off').addClass('one-third');
				}	
			else if (fullsize > 1007){	
				$('.two-thirds-off').removeClass('one-third two-thirds-off').addClass('two-thirds');
				$('.three-thirds-off.two-thirds').removeClass('two-thirds three-thirds-off').addClass('three-thirds');
				$('#fullwidth .one-third-off.two-thirds').removeClass('two-thirds one-third-off').addClass('one-third');
				var tickerwidth = $('.ticker-title-date').outerWidth( true ) + $('.ticker-heading').outerWidth( true );
				$('#ticker-list-box').css('width', 1008 - tickerwidth);
				}
				setTimeout(function() {$('#fullwidth').masonry();}, 500);
			}
		  	checkWidth();
			$(window).resize(checkWidth);
							
  			//scroll effects

			$(window).scroll(function () {
				 var bftop = $(this).scrollTop();
				 var bfheight = $(this).height();
				 var bfbottom = bftop + bfheight;	

					$('.home-widget').each(function(){

						var geget = $(this).offset().top;
					if (bfbottom > geget && geget > bfheight ) {
						$(this).find('.widget').addClass(widget_fx);
					}
					
				});
				
				$('.score-line').each(function(){

						var geget = $(this).offset().top;
					if (bfbottom > geget && geget > bfheight ) {
						$(this).find('.score-width').addClass('active');
					}
				});
			});
				  
			//carousel
			
			$('.carousel').flexslider({

				animation : 'slide',
				itemWidth : 167,
				itemMargin : 1,
				move : 2,
				slideshow : false,
				controlNav: false,
				directionNav: true,
			});

			
			//video type page carousel
			
			$('.tv-carousel').flexslider({
				animation : 'slide',
				itemWidth : 167,
				itemMargin : 1,
				move : 2,
				slideshow : false,
				controlNav : false,
				directionNav: true,
			});
		
			//type pages ajax
			$('.term-post-format-video').on('click', '.ajax', function(e){
						event.preventDefault();
						var post_id = $(this).attr("href");
		
						jQuery.ajax({
							post : post_id,
							type : "POST",
							data : {id : post_id},
							success : function(output) {
								$(".tv-video-wrapper").replaceWith($('.tv-video-wrapper', output));
								$(".tv-format-title").replaceWith($('.tv-format-title', output));
								$(".tv-format-subtitle").replaceWith($('.tv-format-subtitle', output));
							}
						});
					});
					
			$('.term-post-format-gallery').on('click', '.ajax', function(e){					
						event.preventDefault();
						var post_id = $(this).attr("href");
		
						jQuery.ajax({
							post : post_id,
							type : "POST",
							data : {id : post_id},
							success : function(output) {
								$(".tv-video-wrapper").replaceWith($('.tv-video-wrapper', output));
								$(".tv-format-title").replaceWith($('.tv-format-title', output));
								$(".tv-format-subtitle").replaceWith($('.tv-format-subtitle', output));												
								$('.post-page-gallery-thumbnails').flexslider({
									animation: 'slide',
									controlNav: false,
									animationLoop: false,
									slideshow: false,
									itemWidth: 166,
									itemMargin: 1,
									directionNav: true,
									asNavFor: '.post-page-gallery-slider'
								  });
								   
								  $('.post-page-gallery-slider').flexslider({
									animation: slide_picker,
									controlNav: false,
									animationLoop: false,
									slideshow: false,
									sync: '.post-page-gallery-thumbnails'
								  });
							}
						});
					});								

			$('.term-post-format-video, .term-post-format-gallery').on('click', '.pagination a', function(e){
				e.preventDefault();
				var link = $(this).attr('href');		

					$('.tv-page-widget').append('<div class="more-posts"></div>');
					$('.pagination').replaceWith('<div class="load-content"><div class="load-circle"></div></div>');
					$('.more-posts').load(link + ' .tv-page-widget li, .pagination', function() {
						$('.more-posts li').hide().detach().appendTo('.tv-page-widget ul').fadeIn(500);
						$('.more-posts .pagination').detach().appendTo('.tv-page-widget');
						$('.more-posts').remove();	
						$('.load-content').remove();	
								
					});	
			});


					
					
			//keyboard navigation next prev 		
			   $(document).keydown(function(e) {
					var url = false;
				if (e.which == 37) {  // Left arrow key code
						url = $('.previous-title a').attr('href');
					}
				else if (e.which == 39) {  // Right arrow key code
						url = $('.next-title a').attr('href');
				}
				if (url) {
						window.location = url;
				}
			});
			
			//menu button for responsive mobile
			
			
			$("#mob-menu").click(function() {
				$("#main-nav ul").toggleClass("active");
				$(this).toggleClass("active");
				
			});

		
	//main slider widget

	$('.flexslider').flexslider({
			animation: slide_picker,
			slideshowSpeed: 8000,
			controlNav: false,
			useCSS: true,
			keyboard: false,
			pauseOnHover: true,
			start: function(slider){
	   $('.flexslider').fadeTo( "fast" , 1);
	    }
		});
			
			
			
	//border splitters
	
		
		$('#fullwidth .one-third .flexslider, #fullwidth .two-thirds .flexslider, #fullwidth .one-third .wide-slider, #fullwidth .two-thirds .wide-slider, #fullwidth .img-featured, #fullwidth .small-category').each(function(){
			
			if($(this).offset().left - $('#main').offset().left > 335){
				$(this).addClass('left');
				};
			if($(this).offset().left - $('#main').offset().left < 671){
				$(this).addClass('right');
				};
				
			});
			
			
		//wide slider	

			
			
			$('.wide-slider').each(function(){
				
				
					var widget_id = $(this).closest('.widget').attr('id');
					var widget_id_p = '#'+widget_id;
					var widget_id_x = '.'+widget_id;				
					$(widget_id_p).find('.wide-slider-control li').addClass(widget_id);
					
					$(this).flexslider({
						animation: slide_picker,
						slideshowSpeed: 8000,
						manualControls: $(widget_id_x),
						controlNav: true,
						directionNav: false,
						pauseOnHover: true,
						start: function(slider) {
					$('.slider-container').fadeTo( "fast" , 1);
					$('.wide-slider-control').fadeTo( "fast" , 1);
					}
					});																	
			});

			
		//featured category			

		  $('.cat-slider').each(function(){
			  
			  
				  var widget_id = $(this).closest('.widget').attr('id');
				  var widget_id_p = '#'+widget_id;
				  var widget_id_x = '.'+widget_id;				
				  $(widget_id_p).find('.feat-cat-categories li a').addClass(widget_id);			

				$(this).flexslider({
						animation: slide_picker,
						manualControls: $(widget_id_x),
						controlNav: true,
						slideshow : false,
						directionNav: false,
					});
			});

			
			
		
			  //Gallery slider
					  $('.post-page-gallery-thumbnails').flexslider({
						animation: 'slide',
						controlNav: false,
						animationLoop: false,
						slideshow: false,
						itemWidth: 166,
						itemMargin: 1,
						directionNav: true,
						asNavFor: '.post-page-gallery-slider'
					  });
					   
					  $('.post-page-gallery-slider').flexslider({
						animation: slide_picker,
						controlNav: false,
						animationLoop: false,
						slideshow: false,
						sync: '.post-page-gallery-thumbnails'
					  });

				//super-menu scripts
				
				$(".menu-link, .menu-item-has-children").mouseenter(function() {
						$(".menu-item").removeClass("active");										
						if ($(this).hasClass("menu-item-has-children")){	
							$(this).addClass("active");
						}else{
							$(this).parent().addClass("active");
						}
				});				
	});