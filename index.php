<?php

get_header();
$archive_background_class = '';
$category = false;

if ( is_home() ) :

	$blog_before_title = get_field('blog_before_title', 'option');
	$blog_title = get_field('blog_title', 'option');
	$slider_posts_categories = get_field('slider_posts_categories', 'option');
	$middle_posts_categories = get_field('middle_posts_categories', 'option');
	$blog_middle_title = get_field('blog_middle_title', 'option');
	$blog_bottom_title = get_field('blog_bottom_title', 'option');
	$bottom_posts_categories = get_field('bottom_posts_categories', 'option');
	$cta_button_link = get_field('cta_button_link', 'option');
	$cta_button_link_url = $cta_button_link['url'];
	$cta_button_link_title = $cta_button_link['title'];

endif;

if( is_category() ) :

	$category = get_queried_object();

	$archive_before_title = get_field('archive_before_title', 'option');
	$archive_title = $category->name;
	$archive_cta_button_link = get_field('archive_cta_button_link', 'option');
	$archive_cta_button_link_url = $archive_cta_button_link['url'];
	$archive_cta_button_link_title = $archive_cta_button_link['title'];

endif;
?>

	<main id="primary" class="site-main">
		<?php if ( is_home() ) : ?>
			<div class="blog-main-container">
				<div class="blog-main-container-inner">
					<div class="container">
						<div class="intro_before_title before-title-style-3 before-title-size-1 before-title-weight-700" style="--before-title-size-1-ld: 16px;--before-title-size-1-mt: 16px;--before_title_margin_bottom_ld: 1.8rem;--before_title_margin_bottom_mt: 10px;"><?php echo $blog_before_title; ?></div>
						<h2 class="intro_title title-style-2 title-size-2 title-weight-700" style="--title_margin_bottom_ld: 5rem;--title_margin_bottom_mt: 25px;"><?php echo $blog_title; ?></h2>

						<!-- Blog top posts -->
						<div class="blog-main-container-top-posts">
							<?php
								$args = array(
									'post_type'      => 'post',
									'post_status'    => 'publish',
									'posts_per_page' => 1,
									'tax_query'      => array(
										array(
											'taxonomy' => 'category',
											'field'    => 'term_id',
											'terms'    => $slider_posts_categories,
										),
									),
								);
								$posts = new WP_Query( $args );

								if ( $posts->have_posts() ) :
					
									while ( $posts->have_posts() ) :
										$posts->the_post(); ?>
				
										<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
											<a href="<?php the_permalink(); ?>">
												<?php
												the_post_thumbnail( array(1440, 500) );
												?>
												<div class="article-container">
													<header class="entry-header">
														<h3 class="entry-title"><?php the_title(); ?></h3>
														<div class="entry-date"><?php echo get_the_date(); ?></div>
													</header>
													<div class="entry-content">
														<p>
															<?php if (get_the_excerpt()) {
																echo get_the_excerpt();
															} else {
																echo wp_trim_words(get_the_content(), 25);
															} ?>
														</p> 
													</div>
												</div>
											</a>
										</article>
										<?php
									endwhile;
									wp_reset_query();
								endif;
							?>
						</div>

						<h2 class="intro_title title-style-2 title-size-2 title-weight-700" style="--title_margin_bottom_ld: 5rem;--title_margin_bottom_mt: 25px;"><?php echo $blog_middle_title; ?></h2>

						<!-- Blog middle posts -->
						<div class="blog-main-container-middle-posts">
							<?php
							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

							$args2 = array(
								'post_type'      => 'post',
								'post_status'    => 'publish',
								'posts_per_page' => 3,
								'paged'          => $paged, // Add this line for pagination
								'tax_query'      => array(
									array(
										'taxonomy' => 'category',
										'field'    => 'term_id',
										'terms'    => $middle_posts_categories,
									),
								),
							);
							$posts2 = new WP_Query( $args2 );

							if ( $posts2->have_posts() ) :

								while ( $posts2->have_posts() ) :
									$posts2->the_post(); ?>

										<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
											<a href="<?php the_permalink(); ?>">
												<?php
												the_post_thumbnail( array(508, 250) );
												?>
												<div class="article-container">
													<header class="entry-header">
														<div class="entry-date"><?php echo get_the_date(); ?></div>
														<h3 class="entry-title"><?php the_title(); ?></h3>
													</header>
													<div class="entry-content">
														<p>
															<?php if (get_the_excerpt()) {
																echo get_the_excerpt();
															} else {
																echo wp_trim_words(get_the_content(), 25);
															} ?>
														</p> 
													</div>
													<span class="entry_btn">Learn more</span>
												</div>
											</a>
										</article>

									<?php
								endwhile;

								// Pagination
								echo '<div class="pagination">';
								echo paginate_links(array(
									'total' => $posts2->max_num_pages,
									'current' => max(1, get_query_var('paged')),
									'prev_text' => '&larr;',
									'next_text' => '&rarr;',
									'end_size' => 1,
									'mid_size' => 1,
								));
								echo '</div>';

								wp_reset_query();
							endif;
							?>
						</div>

						<h2 class="intro_title title-style-2 title-size-2 title-weight-700" style="--title_margin_bottom_ld: 5rem;--title_margin_bottom_mt: 25px;"><?php echo $blog_bottom_title; ?></h2>

						<!-- Blog bottom posts -->
						<div class="blog-main-container-bottom-posts">
							<?php
							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

							$args3 = array(
								'post_type'      => 'post',
								'post_status'    => 'publish',
								'posts_per_page' => 3,
								'paged'          => $paged, // Add this line for pagination
								'tax_query'      => array(
									array(
										'taxonomy' => 'category',
										'field'    => 'term_id',
										'terms'    => $bottom_posts_categories,
									),
								),
							);
							$posts3 = new WP_Query( $args3 );

							if ( $posts3->have_posts() ) :

								while ( $posts3->have_posts() ) :
									$posts3->the_post(); ?>

										<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
											<a href="<?php the_permalink(); ?>">
												<?php
												the_post_thumbnail( array(508, 250) );
												?>
												<div class="article-container">
													<header class="entry-header">
														<div class="entry-date"><?php echo get_the_date(); ?></div>
														<h3 class="entry-title"><?php the_title(); ?></h3>
													</header>
													<div class="entry-content">
														<p>
															<?php if (get_the_excerpt()) {
																echo get_the_excerpt();
															} else {
																echo wp_trim_words(get_the_content(), 25);
															} ?>
														</p> 
													</div>
													<span class="entry_btn">Learn more</span>
												</div>
											</a>
										</article>

									<?php
								endwhile;

								// Pagination
								echo '<div class="pagination">';
								echo paginate_links(array(
									'total' => $posts3->max_num_pages,
									'current' => max(1, get_query_var('paged')),
									'prev_text' => '&larr;',
									'next_text' => '&rarr;',
									'end_size' => 1,
									'mid_size' => 1,
								));
								echo '</div>';

								wp_reset_query();
							endif;
							?>
						</div>
					</div>
				</div>

				<!-- Bottom CTA Section -->
				<div class="il_block il_section hp-helping-donate-now-section " style=" --b-space-top-ld: 6.5rem; --b-space-bottom-ld: 8.1rem; --b-space-top-mt: 10rem; --b-space-bottom-mt: 32rem;">
					<div class="il_block_bg" style="background: linear-gradient(96deg, #053279 0%, #030B27 99.13%);">
					<img loading="lazy" decoding="async" width="670" height="360" src="/wp-content/uploads/2023/10/Image-18.png" class="bg_element" alt="" style="--bg-e-width-lg: auto; --bg-e-height-lg: 100%; --bg-e-left-lg: auto; --bg-e-right-lg: 0; --bg-e-top-lg: 0; --bg-e-bottom-lg: 0; --bg-e-width-mt: 33.5rem; --bg-e-height-mt: 18rem; --bg-e-left-mt: 0; --bg-e-right-mt: 0; --bg-e-top-mt: 0; --bg-e-bottom-mt: 0; --bg-e-display-mobile: none" srcset="/wp-content/uploads/2023/10/Image-18.png 670w, /wp-content/uploads/2023/10/Image-18-300x161.png 300w" sizes="(max-width: 670px) 100vw, 670px"><img loading="lazy" decoding="async" width="955" height="784" src="/wp-content/uploads/2023/12/Donate-now_image_mobile-2.png" class="bg_element" alt="" style="--bg-e-width-lg: 95.5rem; --bg-e-height-lg: 78.4rem; --bg-e-left-lg: 0; --bg-e-right-lg: 0; --bg-e-top-lg: 0; --bg-e-bottom-lg: 0; --bg-e-width-mt: 40rem; --bg-e-height-mt: auto; --bg-e-left-mt: auto; --bg-e-right-mt: 0; --bg-e-top-mt: auto; --bg-e-bottom-mt: 0; --bg-e-display-desktop: none" srcset="/wp-content/uploads/2023/12/Donate-now_image_mobile-2.png 955w, /wp-content/uploads/2023/11/Donate-now_image_mobile-2-300x246.png 300w, /wp-content/uploads/2023/11/Donate-now_image_mobile-2-768x630.png 768w" sizes="(max-width: 955px) 100vw, 955px">
					</div>
					<div class="il_section_inner container ib-fullwidth stack-mobile " style="--custom-max-width-ld: var(--site-width);">
						<div class="il_block_intro align-left " style="">
							<h2 class="intro_title title-style-1 title-size-2 title-weight-700" style="--title-size-2-ld: 3.6rem;--title-size-2-mt: 25px;--title_margin_bottom_ld: 5rem;--title_margin_bottom_mt: 30px;"><span>Whether helping those most in need or advancing healthcare globally: </span><br>when you support Sheba, you are making a difference.</h2>
							<div class="buttons">
									<a class="il_btn  button-color-green button-hover-color-pink" href="<?php echo $cta_button_link_url; ?>" target="_self"><?php echo $cta_button_link_title; ?></a>
							</div>
						</div>	
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if( is_category() ) : ?>
			<div class="archive-main-container">
				<div class="archive-main-container-inner">
					<div class="container">
						<div class="il_block_intro align-right">
							<div class="intro_before_title before-title-style-3 before-title-size-1 before-title-weight-500" style="--before-title-size-1-ld: 20px;--before-title-size-1-mt: 16px;--before_title_margin_bottom_ld: 1.8rem;--before_title_margin_bottom_mt: 12px;"><?php echo $archive_before_title; ?></div>
							<h2 class="intro_title title-style-2 title-size-2 title-weight-700" style="--title_margin_bottom_ld: 5rem;--title_margin_bottom_mt: 30px;"><?php echo $archive_title; ?></h2>
						</div>
						<div class="archive-main-content">
							<div class="archive-main-content-posts">
								<?php
								$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

								$args = array(
									'post_type'      => 'post',
									'post_status'    => 'publish',
									'posts_per_page' => 6,
									'paged'          => $paged,
									'tax_query'      => array(
										array(
											'taxonomy' => 'category',
											'field'    => 'id', // You can change 'id' to 'slug' if you're using category slugs
											'terms'    => get_queried_object_id(), // Gets the ID of the current category
										),
									),
								);
								$posts = new WP_Query( $args );

								if ( $posts->have_posts() ) :

									while ( $posts->have_posts() ) :
										$posts->the_post(); ?>

											<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
												<a href="<?php the_permalink(); ?>">
													<?php
													the_post_thumbnail( array(508, 250) );
													?>
													<div class="article-container">
														<header class="entry-header">
															<div class="entry-date"><?php echo get_the_date(); ?></div>
															<h3 class="entry-title"><?php the_title(); ?></h3>
														</header>
														<div class="entry-content">
															<p>
																<?php if (get_the_excerpt()) {
																	echo get_the_excerpt();
																} else {
																	echo wp_trim_words(get_the_content(), 25);
																} ?>
															</p> 
														</div>
														<span class="entry_btn">Learn more</span>
													</div>
												</a>
											</article>

										<?php
									endwhile;

									// Pagination
									echo '<div class="pagination">';
									echo paginate_links(array(
										'total' => $posts->max_num_pages,
										'current' => max(1, get_query_var('paged')),
										'prev_text' => '&larr;',
										'next_text' => '&rarr;',
										'end_size' => 1,
										'mid_size' => 1,
									));
									echo '</div>';

									wp_reset_query();
								endif;
								?>
							</div>
							<div class="archive-main-content-sidebar">
								<?php get_sidebar(); ?>
							</div>
						</div>
					</div>
				</div>

				<!-- Bottom Section First -->
				<div class="il_block il_section" style="--b-space-top-ld: 10rem; --b-space-bottom-ld: 10rem; --b-space-top-mt: 10rem; --b-space-bottom-mt: 10rem;">
					<div class="il_block_bg" style="background-color:">
						<img loading="lazy" 
							decoding="async" 
							width="1386" 
							height="576" 
							src="https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/06/Image-29-1.png" 
							class="bg_element" 
							alt="" 
							style="--bg-e-width-lg: 138.6rem; --bg-e-height-lg: 57.6rem; --bg-e-left-lg: 0; --bg-e-right-lg: 0; --bg-e-top-lg: 0; --bg-e-bottom-lg: 0; --bg-e-width-mt: 52rem; --bg-e-height-mt: auto; --bg-e-left-mt: 0; --bg-e-right-mt: 0; --bg-e-top-mt: 0; --bg-e-bottom-mt: 0" 
							srcset="https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/06/Image-29-1.png 1386w, https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/06/Image-29-1-300x125.png 300w, https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/06/Image-29-1-1024x426.png 1024w, https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/06/Image-29-1-768x319.png 768w" 
							sizes="auto, (max-width: 1386px) 100vw, 1386px">
					</div>
					<div class="il_section_inner container ib-custom-width stack-mobile content-align-right" style="--custom-max-width-ld: var(--site-width);">
						<div class="il_block_intro align-right list-cols-1" style="flex-basis: 52%;">
							<div class="intro_before_title before-title-style-3 before-title-size-1 before-title-weight-700" 
								style="--before-title-size-1-ld: 16px; --before-title-size-1-mt: 16px; --before_title_margin_bottom_ld: 1.6rem; --before_title_margin_bottom_mt: 10px;">
								על האגודה
							</div>
							<h2 class="intro_title title-style-2 title-size-3 title-weight-700" style="--title-size-3-ld: 4rem; --title-size-3-mt: 30px;">
								ידידי <span style="color: var(--color-3);">שיבא</span>
							</h2>
							<div class="intro_subtitle subtitle-style-2 subtitle-size-1 subtitle-weight-700" style="color: #000000; --subtitle-size-1-ld: 18px; --subtitle-size-1-mt: 18px;">
								כאן נולדה תנועה של אחריות רפואית וחברתית
							</div>
							<div class="intro_text text-black" style="--text_margin_bottom_ld: 5rem; --text_margin_bottom_mt: 30px;">
								<p>בשיבא, החדשנות אינה רק יעד – היא מנוע פעולה יומיומי. שיבא אינו רק מוסד רפואי – הוא חממה לרעיונות פורצי דרך, למודלים טיפוליים חדשים ולשיתופי פעולה שמשפיעים על חייהם של מיליוני אנשים בישראל וברחבי העולם.</p>
								<p>האגודה מהווה שגרירה של חזון שיבא בישראל, ומזמינה את הציבור לקחת חלק בעשייה הרפואית, המדעית והחברתית שמובילה את הרפואה קדימה – לטובת כל אחת ואחד מאיתנו.</p>
							</div>
							<div class="buttons">
								<a class="il_btn button-color-green button-hover-color-green" href="#" target="_self">READ MORE</a>
							</div>
						</div>
					</div>
				</div>


				<!-- Bottom CTA Section -->
				<div class="il_block il_section hp-helping-donate-now-section" style="--b-space-top-ld: 6.5rem; --b-space-bottom-ld: 8.1rem; --b-space-top-mt: 10rem; --b-space-bottom-mt: 32rem;">
					<div class="il_block_bg" style="background: linear-gradient(96deg, #053279 0%, #030B27 99.13%);">
						<img loading="lazy" 
							decoding="async" 
							width="1920" 
							height="360" 
							src="https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/05/donatebg1.jpg" 
							class="desk_bg" 
							alt="" 
							srcset="https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/05/donatebg1.jpg 1920w, https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/05/donatebg1-300x56.jpg 300w, https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/05/donatebg1-1024x192.jpg 1024w, https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/05/donatebg1-768x144.jpg 768w, https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/05/donatebg1-1536x288.jpg 1536w" 
							sizes="auto, (max-width: 1920px) 100vw, 1920px">
						<img loading="lazy" 
							decoding="async" 
							width="670" 
							height="359" 
							src="https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/05/donateimg.png" 
							class="bg_element" 
							alt="" 
							style="--bg-e-width-lg: auto; --bg-e-height-lg: 100%; --bg-e-left-lg: 0; --bg-e-right-lg: auto; --bg-e-top-lg: 0; --bg-e-bottom-lg: 0; --bg-e-width-mt: 33.5rem; --bg-e-height-mt: 17.95rem; --bg-e-left-mt: 0; --bg-e-right-mt: 0; --bg-e-top-mt: 0; --bg-e-bottom-mt: 0; --bg-e-display-mobile: none" 
							srcset="https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/05/donateimg.png 670w, https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/05/donateimg-300x161.png 300w" 
							sizes="auto, (max-width: 670px) 100vw, 670px">
						<img loading="lazy" 
							decoding="async" 
							width="709" 
							height="609" 
							src="https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/05/Donate-now_image_mobile-1.png" 
							class="bg_element" 
							alt="" 
							style="--bg-e-width-lg: 70.9rem; --bg-e-height-lg: 60.9rem; --bg-e-left-lg: 0; --bg-e-right-lg: 0; --bg-e-top-lg: 0; --bg-e-bottom-lg: 0; --bg-e-width-mt: 50rem; --bg-e-height-mt: auto; --bg-e-left-mt: 0; --bg-e-right-mt: auto; --bg-e-top-mt: auto; --bg-e-bottom-mt: 0; --bg-e-display-desktop: none" 
							srcset="https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/05/Donate-now_image_mobile-1.png 709w, https://hebrew-fos.ilogic-dev.net/wp-content/uploads/2025/05/Donate-now_image_mobile-1-300x258.png 300w" 
							sizes="auto, (max-width: 709px) 100vw, 709px">
					</div>
					<div class="il_section_inner container ib-fullwidth stack-mobile" style="--custom-max-width-ld: var(--site-width);">
						<div class="il_block_intro align-right">
							<h2 class="intro_title title-style-2 title-size-2 title-weight-700" style="--title-size-2-ld: 3.6rem; --title-size-2-mt: 25px; --title_margin_bottom_ld: 5rem; --title_margin_bottom_mt: 30px;">
								<span>זה הרבה יותר מתרומה. זו שותפות אמיתית בריפוי.</span><br>
								הצטרפו לקהילת התורמים שלנו והשפיעו יחד איתנו
							</h2>
							<div class="buttons">
								<a class="il_btn button-color-green button-hover-color-pink" href="/donate/" target="_self">תירמו עכשיו</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<button id="backToTopButton"><img src="/wp-content/uploads/2023/11/Group-2755.png"></button>
	</main><!-- #main -->

<?php
get_footer();
