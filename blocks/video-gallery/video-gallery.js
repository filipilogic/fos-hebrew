jQuery(document).ready(function ($) {
	
	// Init Logo Carousel

	$('.il_video_gallery_inner').flickity({
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
		// Find the closest gallery block (more specific than just .container)
		var galleryBlock = $(this).closest('.il_video_gallery');
		
		// Target only the specific carousel within this block
		var targetCarousel = galleryBlock.find('.il_video_gallery_inner');
		
		// Find the specific flickity button within this carousel only
		targetCarousel.find('.flickity-prev-next-button.previous').click();
	});

	$('.carousel-next-button').click(function() {
		// Find the closest gallery block (more specific than just .container)
		var galleryBlock = $(this).closest('.il_video_gallery');
		
		// Target only the specific carousel within this block
		var targetCarousel = galleryBlock.find('.il_video_gallery_inner');
		
		// Find the specific flickity button within this carousel only
		targetCarousel.find('.flickity-prev-next-button.next').click();
	});
});