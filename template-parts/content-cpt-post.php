<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <a href="<?php the_permalink(); ?>">
        <?php
        $homepage_image = get_field('homepage_image', get_the_ID());
        if ( $show_homepage_image && $homepage_image ) {
            $size = 'full';
            echo wp_get_attachment_image( $homepage_image, $size, false );
        } else {
            the_post_thumbnail( array(508, 250) );
        }
        ?>
        <div class="article-container">
            <?php if( $show_date ) { ?>
                <div class="entry-date"><?php echo get_hebrew_date(); ?></div>
            <?php } ?>
            <header class="entry-header">
                <h3 class="entry-title"><?php the_title(); ?></h3>
            </header>
            <?php if ( empty( $carousel) ) { ?>
                <div class="entry-content">
                    <p>
                        <?php if (get_the_excerpt()) {
                            echo get_the_excerpt();
                        } else {
                            echo wp_trim_words(get_the_content(), 25);
                        } ?>
                    </p> 
                </div>
            <?php } ?>
            <?php if ( $learn_more_text ) { ?>
                <span class="entry_btn">
                    <?php echo $learn_more_text; ?>
                    <?php if ( ! empty( $carousel) ) { ?>
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="14" cy="14" r="14" fill="#2FB297"/><path fill-rule="evenodd" clip-rule="evenodd" d="M14.7053 6.70532C14.3158 6.31578 13.6842 6.31578 13.2947 6.70532C12.9054 7.0946 12.9051 7.72568 13.2941 8.11531L18.17 13H7C6.44771 13 6 13.4477 6 14C6 14.5523 6.44772 15 7 15H18.17L13.2941 19.8847C12.9051 20.2743 12.9054 20.9054 13.2947 21.2947C13.6842 21.6842 14.3158 21.6842 14.7053 21.2947L22 14L14.7053 6.70532Z" fill="white"/><mask id="mask0_276_1421" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="6" y="6" width="16" height="16"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.7053 6.70532C14.3158 6.31578 13.6842 6.31578 13.2947 6.70532C12.9054 7.0946 12.9051 7.72568 13.2941 8.11531L18.17 13H7C6.44771 13 6 13.4477 6 14C6 14.5523 6.44772 15 7 15H18.17L13.2941 19.8847C12.9051 20.2743 12.9054 20.9054 13.2947 21.2947C13.6842 21.6842 14.3158 21.6842 14.7053 21.2947L22 14L14.7053 6.70532Z" fill="white"/></mask><g mask="url(#mask0_276_1421)"><rect x="2" y="2" width="24" height="24" fill="white"/></g></svg>
                    <?php } ?>
                </span>
            <?php } ?>
        </div>
    </a>
</article>