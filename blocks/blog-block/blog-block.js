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
		// Find the closest common ancestor
		var commonAncestor = $(this).closest('.container');

		// Find the element with class flickity-prev-next-button.previous within the common ancestor and click on it
		commonAncestor.find('.flickity-prev-next-button.previous').click();
	});

	$('.carousel-next-button').click(function() {
		// Find the closest common ancestor
		var commonAncestor = $(this).closest('.container');

		// Find the element with class flickity-prev-next-button.previous within the common ancestor and click on it
		commonAncestor.find('.flickity-prev-next-button.next').click();
	});
});