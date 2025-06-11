jQuery(document).ready(function ($) {
	
	// Init Logo Carousel

	$('.il_blog-block-section .il_inner_posts_container').flickity({
		// options
		cellAlign: 'right',
		contain: true,
		pageDots: false,
		prevNextButtons: true,
		freeScroll: true,
		wrapAround: true,
		autoPlay: false,
		selectedAttraction: 0.009,
		watchCSS: true,
		rightToLeft: true,
		imagesLoaded: true
		});

	$('.carousel-previous-button').click(function() {
		// Find the closest carousel block (more specific than just .container)
		var carouselBlock = $(this).closest('.il_blog-block-section');
		
		// Target only the specific carousel within this block
		var targetCarousel = carouselBlock.find('.il_inner_posts_container');
		
		// Find the specific flickity button within this carousel only
		targetCarousel.find('.flickity-prev-next-button.previous').click();
	});

	$('.carousel-next-button').click(function() {
		// Find the closest carousel block (more specific than just .container)
		var carouselBlock = $(this).closest('.il_blog-block-section');
		
		// Target only the specific carousel within this block
		var targetCarousel = carouselBlock.find('.il_inner_posts_container');
		
		// Find the specific flickity button within this carousel only
		targetCarousel.find('.flickity-prev-next-button.next').click();
	});
});