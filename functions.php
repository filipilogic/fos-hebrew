<?php
/**
 * ilogic functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ilogic
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.1.2' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ilogic_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'ilogic' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);


	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 150,
			'width'       => 300,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'ilogic_setup' );

/**
 * Enqueue scripts and styles.
 */
function ilogic_scripts() {
	wp_enqueue_style( 'ilogic-style', get_stylesheet_uri(), array(), _S_VERSION );

	wp_enqueue_style( 'frontend-style', get_template_directory_uri() . '/assets/public/css/frontend.css', array(), _S_VERSION );
	wp_enqueue_script( 'ilogic-script', get_template_directory_uri() . '/assets/public/js/frontend.js', array('jquery'), _S_VERSION );

	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/assets/public/js/vendor/fancybox.js',array('jquery'),_S_VERSION,true);
	wp_enqueue_script( 'flickity', get_template_directory_uri() . '/assets/public/js/vendor/flickity.js',array('jquery'),_S_VERSION,true);

	if ( is_home() ) {
		wp_enqueue_script( 'blog-main-script', get_template_directory_uri() . '/assets/src/js/blog-main.js', array('jquery'), _S_VERSION );
	}

	if ( is_category() ) {
		wp_enqueue_script( 'archive-main-script', get_template_directory_uri() . '/assets/src/js/archive-main.js', array('jquery'), _S_VERSION );
	}
}
add_action( 'wp_enqueue_scripts', 'ilogic_scripts' );

function ilogic_admin_styles() {
	wp_enqueue_style( 'backend-styles', get_template_directory_uri() . '/assets/public/css/backend.css' );
}
add_action( 'admin_enqueue_scripts', 'ilogic_admin_styles' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/theme-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/includes/theme-functions.php';

// Theme options

require get_template_directory() . '/includes/theme-options.php';

// Fun Facts

require get_template_directory() . '/includes/theme-facts.php';


// Load scripts for block


 require get_template_directory() . '/includes/blocks-js.php';


// Register Blocks

add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {
	register_block_type( __DIR__ . '/blocks/hero' );
	register_block_type( __DIR__ . '/blocks/hero-si' );
    register_block_type( __DIR__ . '/blocks/section' );
	register_block_type( __DIR__ . '/blocks/accordion' );
	register_block_type( __DIR__ . '/blocks/gallery' );
	register_block_type( __DIR__ . '/blocks/team' );
	register_block_type( __DIR__ . '/blocks/columns' );
	register_block_type( __DIR__ . '/blocks/tabs' );
	register_block_type( __DIR__ . '/blocks/lb-carousel' );
	register_block_type( __DIR__ . '/blocks/timeline' );
	register_block_type( __DIR__ . '/blocks/inner-hero-1' );
	register_block_type( __DIR__ . '/blocks/inner-hero-2' );
	register_block_type( __DIR__ . '/blocks/fp-section' );
	register_block_type( __DIR__ . '/blocks/mini-gallery' );
	register_block_type( __DIR__ . '/blocks/video-popup-section' );
	register_block_type( __DIR__ . '/blocks/contact-us' );
	register_block_type( __DIR__ . '/blocks/exec-director-section' );
	register_block_type( __DIR__ . '/blocks/countdown' );
	register_block_type( __DIR__ . '/blocks/agenda' );
	register_block_type( __DIR__ . '/blocks/blog-block' );
	register_block_type( __DIR__ . '/blocks/logos' );
	register_block_type( __DIR__ . '/blocks/related-posts' );
	register_block_type( __DIR__ . '/blocks/content-and-sidebar' );
	register_block_type( __DIR__ . '/blocks/cpt-blog' );
}


function filter_block_categories_when_post_provided( $block_categories, $editor_context ) {
    if ( ! empty( $editor_context->post ) ) {
        array_push(
            $block_categories,
            array(
                'slug'  => 'ilogic-category',
                'title' => __( 'iLogic Blocks', 'ilogic' ),
                'icon'  => null,
            )
        );
    }
    return $block_categories;
}

add_filter( 'block_categories_all', 'filter_block_categories_when_post_provided', 10, 2 );

function the_breadcrumb() {

	$page_for_posts_id = get_option( 'page_for_posts' );
	$blog_title = get_the_title($page_for_posts_id);

    $sep = ' > ';

    if (!is_front_page()) {
	
	// Start the breadcrumb with a link to your homepage
        echo '<div class="il_sp_breadcrumbs">';
        echo '<a href="';
        echo get_permalink( get_option( 'page_for_posts' ) );
        echo '">';
        echo $blog_title;
        echo '</a>' . $sep;
	
	
	// Check if the current page is a category, an archive or a single page. If so show the category or archive name.
        if (is_category() || is_single() ){
			echo '<span>Category</span>'. $sep;
            the_category(', ');
        } elseif (is_archive() || is_single()){
            if ( is_day() ) {
                printf( __( '%s', 'text_domain' ), get_the_date() );
            } elseif ( is_month() ) {
                printf( __( '%s', 'text_domain' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'text_domain' ) ) );
            } elseif ( is_year() ) {
                printf( __( '%s', 'text_domain' ), get_the_date( _x( 'Y', 'yearly archives date format', 'text_domain' ) ) );
            } else {
                _e( 'Blog Archives', 'text_domain' );
            }
        }
	
	// If the current page is a single post, show its title with the separator
        if (is_single()) {
            // echo $sep;
            // the_title();
        }
	
	// If the current page is a static page, show its title.
        if (is_page()) {
            echo the_title();
        }
	
	// if you have a static page assigned to be you posts list page. It will find the title of the static page and display it. i.e Home >> Blog
        if (is_home()){
            global $post;
            $page_for_posts_id = get_option('page_for_posts');
            if ( $page_for_posts_id ) { 
                $post = get_post($page_for_posts_id);
                setup_postdata($post);
                the_title();
                rewind_posts();
            }
        }

        echo '</div>';
    }
}

function il_social_share(){
	$sb_url = urlencode(get_permalink());
	
	$sb_title = str_replace( ' ', '%20', get_the_title());

	$twitterURL = 'https://twitter.com/intent/tweet?text='.$sb_title.'&amp;url='.$sb_url.'&amp;via=wpvkp';
	$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$sb_url;
	$bufferURL = 'https://bufferapp.com/add?url='.$sb_url.'&amp;text='.$sb_title;
	$whatsappURL = 'whatsapp://send?text='.$sb_title . ' ' . $sb_url;
	$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$sb_url.'&amp;title='.$sb_title;

	$post_title = get_the_title();
	$post_permalink = get_permalink();

	$content = '<div class="social-box"><div class="social-btn">';
	$content .= '<a class="col-1 sbtn s-facebook" href="'.$facebookURL.'" target="_blank" rel="nofollow"><span>
	<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path d="M15.2389 12.3003H13.2774C13.2774 15.4355 13.2774 19.2947 13.2774 19.2947H10.3709C10.3709 19.2947 10.3709 15.4729 10.3709 12.3003H8.98926V9.82822H10.3709V8.22926C10.3709 7.08409 10.9148 5.29468 13.3041 5.29468L15.4579 5.30294V7.70259C15.4579 7.70259 14.1491 7.70259 13.8946 7.70259C13.6402 7.70259 13.2784 7.82989 13.2784 8.37599V9.82871H15.4929L15.2389 12.3003Z" fill="var(--color-3)"/>
	<mask id="mask0_272_11736" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="8" y="5" width="8" height="15">
	<path d="M15.2389 12.3003H13.2774C13.2774 15.4355 13.2774 19.2947 13.2774 19.2947H10.3709C10.3709 19.2947 10.3709 15.4729 10.3709 12.3003H8.98926V9.82822H10.3709V8.22926C10.3709 7.08409 10.9148 5.29468 13.3041 5.29468L15.4579 5.30294V7.70259C15.4579 7.70259 14.1491 7.70259 13.8946 7.70259C13.6402 7.70259 13.2784 7.82989 13.2784 8.37599V9.82871H15.4929L15.2389 12.3003Z" fill="white"/>
	</mask>
	<g mask="url(#mask0_272_11736)">
	<rect x="-0.00634766" y="0.294678" width="23.9889" height="24" fill="var(--color-3)"/>
	</g>
	</svg>
	</span></a>';

	$content .= '<a class="col-1 sbtn s-twitter" href="'. $twitterURL .'" target="_blank" rel="nofollow"><span><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path fill-rule="evenodd" clip-rule="evenodd" d="M18.1923 6.78756L18.1551 6.76276C17.3865 6.03101 16.4816 5.68375 15.4403 5.73336L15.4031 5.65894L15.4279 5.64654C16.37 5.4357 16.9279 5.21246 17.1014 4.96441C17.151 4.76597 17.089 4.65435 16.8783 4.62954C16.4072 4.69155 15.9609 4.79077 15.5766 4.95201C16.0725 4.62954 16.2584 4.4063 16.1469 4.29468C15.6634 4.30708 15.1303 4.55513 14.5849 5.05122C14.7832 4.70396 14.87 4.50552 14.8204 4.48071C14.5477 4.65435 14.3246 4.85279 14.1262 5.06363C13.7047 5.53492 13.37 5.969 13.1097 6.36588L13.0973 6.39068C12.4403 7.46969 11.9692 8.5487 11.6965 9.65252L11.5973 9.73933L11.5725 9.75173C11.1758 9.25564 10.6923 8.83396 10.1221 8.49909C9.45268 8.05261 8.6593 7.64333 7.74195 7.23405C6.75022 6.71315 5.73369 6.29146 4.71716 5.9566C4.70477 7.11002 5.27501 8.0154 6.37832 8.68513V8.69753C5.99402 8.69753 5.60972 8.75954 5.23782 8.87116C5.3122 9.93777 6.0684 10.6695 7.49401 11.0664L7.48162 11.0912C6.92377 11.054 6.46509 11.2524 6.10559 11.6617C6.57666 12.5795 7.40724 13.0136 8.60971 12.9888C8.37418 13.1128 8.18823 13.2368 8.06426 13.3856C7.84112 13.6213 7.76674 13.8941 7.84112 14.2042C8.10145 14.6755 8.56013 14.8863 9.24194 14.8491L9.27913 14.8987L9.26673 14.9235C8.08905 16.139 6.66344 16.6847 5.00229 16.5731L4.97749 16.5855C3.96097 16.5731 2.87006 16.0894 1.69238 15.122C2.87006 16.8211 4.44444 18.0489 6.39071 18.8303C8.60971 19.562 10.8411 19.624 13.0601 18.9915H13.0973C15.2543 18.3714 17.0766 17.0816 18.589 15.1468C19.2832 14.1422 19.7171 13.1748 19.8907 12.2446C21.0188 12.2818 21.8245 11.9594 22.3328 11.2648L22.3204 11.24C21.9361 11.3764 21.2047 11.3392 20.1262 11.116V10.992C21.3163 10.8555 22.0229 10.4711 22.246 9.83855C21.4154 10.161 20.5973 10.1734 19.7915 9.86336C19.6427 8.74714 19.1097 7.71774 18.1923 6.78756Z" fill="var(--color-3)"/>
	<mask id="mask0_272_11740" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="1" y="4" width="22" height="16">
	<path fill-rule="evenodd" clip-rule="evenodd" d="M18.1923 6.78756L18.1551 6.76276C17.3865 6.03101 16.4816 5.68375 15.4403 5.73336L15.4031 5.65894L15.4279 5.64654C16.37 5.4357 16.9279 5.21246 17.1014 4.96441C17.151 4.76597 17.089 4.65435 16.8783 4.62954C16.4072 4.69155 15.9609 4.79077 15.5766 4.95201C16.0725 4.62954 16.2584 4.4063 16.1469 4.29468C15.6634 4.30708 15.1303 4.55513 14.5849 5.05122C14.7832 4.70396 14.87 4.50552 14.8204 4.48071C14.5477 4.65435 14.3246 4.85279 14.1262 5.06363C13.7047 5.53492 13.37 5.969 13.1097 6.36588L13.0973 6.39068C12.4403 7.46969 11.9692 8.5487 11.6965 9.65252L11.5973 9.73933L11.5725 9.75173C11.1758 9.25564 10.6923 8.83396 10.1221 8.49909C9.45268 8.05261 8.6593 7.64333 7.74195 7.23405C6.75022 6.71315 5.73369 6.29146 4.71716 5.9566C4.70477 7.11002 5.27501 8.0154 6.37832 8.68513V8.69753C5.99402 8.69753 5.60972 8.75954 5.23782 8.87116C5.3122 9.93777 6.0684 10.6695 7.49401 11.0664L7.48162 11.0912C6.92377 11.054 6.46509 11.2524 6.10559 11.6617C6.57666 12.5795 7.40724 13.0136 8.60971 12.9888C8.37418 13.1128 8.18823 13.2368 8.06426 13.3856C7.84112 13.6213 7.76674 13.8941 7.84112 14.2042C8.10145 14.6755 8.56013 14.8863 9.24194 14.8491L9.27913 14.8987L9.26673 14.9235C8.08905 16.139 6.66344 16.6847 5.00229 16.5731L4.97749 16.5855C3.96097 16.5731 2.87006 16.0894 1.69238 15.122C2.87006 16.8211 4.44444 18.0489 6.39071 18.8303C8.60971 19.562 10.8411 19.624 13.0601 18.9915H13.0973C15.2543 18.3714 17.0766 17.0816 18.589 15.1468C19.2832 14.1422 19.7171 13.1748 19.8907 12.2446C21.0188 12.2818 21.8245 11.9594 22.3328 11.2648L22.3204 11.24C21.9361 11.3764 21.2047 11.3392 20.1262 11.116V10.992C21.3163 10.8555 22.0229 10.4711 22.246 9.83855C21.4154 10.161 20.5973 10.1734 19.7915 9.86336C19.6427 8.74714 19.1097 7.71774 18.1923 6.78756Z" fill="white"/>
	</mask>
	<g mask="url(#mask0_272_11740)">
	<rect x="-0.306641" y="0.294678" width="23.9889" height="24" fill="var(--color-3)"/>
	</g>
	</svg>
	</span></a>';
	$content .= '<a class="col-2 sbtn s-googleplus" href="mailto:?subject='.$post_title.'&body=Check out this post: '.esc_url($post_permalink).'" target="_blank" rel="nofollow"><span><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path fill-rule="evenodd" clip-rule="evenodd" d="M19.3833 3.29468H3.3907C1.73952 3.29468 0.402085 4.64203 0.402085 6.29468L0.39209 18.2938C0.39209 19.947 1.73918 21.2947 3.3907 21.2947H19.3833C21.0348 21.2947 22.3819 19.947 22.3819 18.2947V6.29468C22.3819 4.64239 21.0348 3.29468 19.3833 3.29468ZM2.40124 6.29551C2.40124 5.74351 2.84677 5.29468 3.39079 5.29468H19.3834C19.9308 5.29468 20.3829 5.74696 20.3829 6.29468V18.2947C20.3829 18.8424 19.9308 19.2947 19.3834 19.2947H3.39079C2.84332 19.2947 2.39125 18.8424 2.39125 18.2947L2.40124 6.29551ZM4.87399 9.29473C4.4012 9.00972 4.24884 8.39547 4.53366 7.92256C4.81863 7.44937 5.43332 7.29691 5.90639 7.58208L11.3578 10.8682L17.0471 7.43868C17.5202 7.15347 18.1357 7.30722 18.4207 7.78047C18.7049 8.25237 18.5547 8.8665 18.0839 9.15241L11.397 13.2127L11.3908 13.2231L4.87399 9.29473Z" fill="#979797"/>
	<mask id="mask0_272_11744" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="3" width="23" height="19">
	<path fill-rule="evenodd" clip-rule="evenodd" d="M19.3833 3.29468H3.3907C1.73952 3.29468 0.402085 4.64203 0.402085 6.29468L0.39209 18.2938C0.39209 19.947 1.73918 21.2947 3.3907 21.2947H19.3833C21.0348 21.2947 22.3819 19.947 22.3819 18.2947V6.29468C22.3819 4.64239 21.0348 3.29468 19.3833 3.29468ZM2.40124 6.29551C2.40124 5.74351 2.84677 5.29468 3.39079 5.29468H19.3834C19.9308 5.29468 20.3829 5.74696 20.3829 6.29468V18.2947C20.3829 18.8424 19.9308 19.2947 19.3834 19.2947H3.39079C2.84332 19.2947 2.39125 18.8424 2.39125 18.2947L2.40124 6.29551ZM4.87399 9.29473C4.4012 9.00972 4.24884 8.39547 4.53366 7.92256C4.81863 7.44937 5.43332 7.29691 5.90639 7.58208L11.3578 10.8682L17.0471 7.43868C17.5202 7.15347 18.1357 7.30722 18.4207 7.78047C18.7049 8.25237 18.5547 8.8665 18.0839 9.15241L11.397 13.2127L11.3908 13.2231L4.87399 9.29473Z" fill="white"/>
	</mask>
	<g mask="url(#mask0_272_11744)">
	<rect x="-0.607422" y="0.294678" width="23.9889" height="24" fill="var(--color-3)"/>
	</g>
	</svg>
	</span></a>';
	$content .= '</div></div>';
	$content .= '<script>
	function copyPostURL(url) {
		const el = document.createElement("textarea");
		el.value = url;
		document.body.appendChild(el);
		el.select();
		document.execCommand("copy");
		document.body.removeChild(el);

		showToastMessage("Post Link Copied");
	}
	function showToastMessage(message) {
		const toast = document.createElement("div");
		toast.textContent = message;
		toast.style.position = "fixed";
		toast.style.bottom = "20px";
		toast.style.left = "50%";
		toast.style.transform = "translateX(-50%)";
		toast.style.background = "#333";
		toast.style.color = "#fff";
		toast.style.padding = "10px";
		toast.style.borderRadius = "5px";
		toast.style.zIndex = "9999";
		
		document.body.appendChild(toast);
	
		// Remove toast after 3 seconds (adjust as needed)
		setTimeout(() => {
			document.body.removeChild(toast);
		}, 3000);
	}
	</script>';
	
	return $content;
}

add_action( 'il_social_share','il_social_share' );

function custom_post_navigation_shortcode() {
    ob_start(); // Start output buffering
    ?>
    <div class="post_nav_container">
        <?php
        // Output the post navigation
        the_post_navigation(array(
            'prev_text' => '<b><</b> Previous',
            'next_text' => 'Next <b>></b>',
            'in_same_term' => true,
        ));
        ?>
    </div>
    <?php

    return ob_get_clean(); // End output buffering and return the buffered content
}

// Register the shortcode
add_shortcode('post_navigation_shortcode', 'custom_post_navigation_shortcode');

function acf_load_post_type_field_choices($field) {
    
    // Reset choices
    $field['choices'] = array();
    
    // Get all registered post types
    $post_types = get_post_types(array(
        'public' => true,
        '_builtin' => false
    ), 'objects');
    
    // Add built-in post type (only post, not page)
    $post_type_obj = get_post_type_object('post');
    if ($post_type_obj) {
        $field['choices']['post'] = $post_type_obj->labels->singular_name;
    }
    
    // Add custom post types
    if ($post_types) {
        foreach ($post_types as $post_type) {
            $field['choices'][$post_type->name] = $post_type->labels->singular_name;
        }
    }
    
    // Return the field
    return $field;
}

add_filter('acf/load_field/name=pick_a_post_type', 'acf_load_post_type_field_choices');

function load_more_posts_blog_block() {
    $page = $_POST['page'];
    $posts_per_page = $_POST['posts_per_page'];
    $categories = $_POST['categories'];
    $show_date = filter_var($_POST['show_date'], FILTER_VALIDATE_BOOLEAN);
    $learn_more_text = $_POST['learn_more_text'];
    $carousel = filter_var($_POST['carousel'], FILTER_VALIDATE_BOOLEAN);
    $show_homepage_image = filter_var($_POST['show_homepage_image'], FILTER_VALIDATE_BOOLEAN);

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $page,
        'tax_query'      => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $categories,
            ),
        ),
    );

    $posts = new WP_Query($args);

    if ($posts->have_posts()) :
        while ($posts->have_posts()) : $posts->the_post();
			include(locate_template('template-parts/content-blog-post.php', false));
        endwhile;
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_posts_blog_block', 'load_more_posts_blog_block');
add_action('wp_ajax_nopriv_load_more_posts_blog_block', 'load_more_posts_blog_block');

function load_more_posts_related_block() {
    $page = $_POST['page'];
    $posts_per_page = $_POST['posts_per_page'];
    $categories = $_POST['categories'];
    $current_post_id = $_POST['current_post_id'];
    $show_date = filter_var($_POST['show_date'], FILTER_VALIDATE_BOOLEAN);
    $learn_more_text = $_POST['learn_more_text'];
    $carousel = filter_var($_POST['carousel'], FILTER_VALIDATE_BOOLEAN);

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
		'post__not_in'   => array($current_post_id),
        'paged'          => $page,
        'tax_query'      => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $categories,
            ),
        ),
    );

    $posts = new WP_Query($args);

    if ($posts->have_posts()) :
        while ($posts->have_posts()) : $posts->the_post();
			include(locate_template('template-parts/content-related-post.php', false));
        endwhile;
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_posts_related_block', 'load_more_posts_related_block');
add_action('wp_ajax_nopriv_load_more_posts_related_block', 'load_more_posts_related_block');

function load_more_posts_cpt_block() {
    $countPosts = isset($_GET['countPosts']) ? intval($_GET['countPosts']) : 0;
    $post_type = $_GET['post_type'];
    $show_date = filter_var($_GET['show_date'], FILTER_VALIDATE_BOOLEAN);
    $learn_more_text = $_GET['learn_more_text'];
    $carousel = filter_var($_GET['carousel'], FILTER_VALIDATE_BOOLEAN);
    $show_homepage_image = filter_var($_GET['show_homepage_image'], FILTER_VALIDATE_BOOLEAN);
    $posts_per_page = isset($_GET['posts_per_page']) ? intval($_GET['posts_per_page']) : 4;

    $args = array(
        'post_type'      => $post_type,
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'orderby'        => 'date',
        'order'          => 'DESC'
    );

    // Add offset for pagination
    if ($countPosts > 0) {
        $args['offset'] = $countPosts;
    }

    // Handle filters
    if (!empty($_GET['filters']) && is_array($_GET['filters'])) {
        $tax_query = array('relation' => 'AND');
        $has_filters = false;
        
        foreach ($_GET['filters'] as $tax => $term_id) {
            if ($term_id && $term_id !== 'all') {
                $has_filters = true;
                $tax_query[] = array(
                    'taxonomy' => $tax,
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                );
            }
        }
        
        if ($has_filters && count($tax_query) > 1) {
            $args['tax_query'] = $tax_query;
        }
    }

    $posts = new WP_Query($args);

    ob_start();
    if ($posts->have_posts()) :
        while ($posts->have_posts()) : $posts->the_post();
            include(locate_template('template-parts/content-cpt-post.php', false));
        endwhile;
    endif;
    $html = ob_get_clean();

    $total_found = $posts->found_posts;

    echo json_encode([
        'html' => $html,
        'total_found' => $total_found
    ]);
    wp_die();
}

add_action('wp_ajax_load_more_posts_cpt_block', 'load_more_posts_cpt_block');
add_action('wp_ajax_nopriv_load_more_posts_cpt_block', 'load_more_posts_cpt_block');
