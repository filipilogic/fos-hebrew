jQuery(document).ready(function ($) {

    // Mobile navigation

    $(".menu-toggle").click(function () {
        $("#primary-menu").fadeToggle();
        $(this).toggleClass('menu-open')
    });

    $("#primary-menu li").click(function() {
      // Get the first <a> element within the clicked li
      var ulElement = $(this).find("ul");
  
      // Check if the href attribute doesn't only contain "#"
      if (! ulElement.hasClass('sub-menu')) {
          var windowsize = $(window).width();
          if (windowsize < 1200) {
              $("#primary-menu").fadeToggle();
              $(".menu-toggle").toggleClass('menu-open');
          }
      }
    });
    
    // Sub Menu Trigger

    $( "#primary-menu li.menu-item-has-children > a" ).after('<span class="sub-menu-trigger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span>');
    
    $( ".menu-item-has-children" ).click(function() {
      var windowsize = $(window).width();
      if (windowsize < 1200) {
          $( this ).toggleClass('sub-menu-open')
          $( this ).find(".sub-menu").slideToggle();
      }
	  });

    // AJAX Load More bttn
    $(document).on('click', '.ilLoadMore', function (e) {
        e.preventDefault() //prevent default action
        
        const category = $(this).data('category')
        let postCategory = 'all'

        if (category) {
          postCategory = category
        }

        if (!window.countPosts) {
          window.countPosts = 4
        }

        $.ajax({
          type: 'GET',
          url: '/wp-admin/admin-ajax.php',
          data: {
            countPosts: window.countPosts,
            postCategory,
            action: 'blog_load_more',
          },
        }).done(function (resp) {
          window.countPosts += 4
         
          $('.il_archive_more').html(resp)
        })
    })

    // Store selected filters per block
    window.cptFilters = window.cptFilters || {};

    $(document).on('click', '.cpt-filter-term', function() {
        const $term = $(this);
        const blockId = $term.closest('[data-block-id]').data('block-id');
        const tax = $term.data('tax');
        const termId = $term.data('term');

        // Reset all filters for this taxonomy
        $term.closest('[data-block-id]').find('.cpt-filter-term[data-tax="' + tax + '"]').removeClass('active');
        $term.addClass('active');

        window.cptFilters[blockId] = window.cptFilters[blockId] || {};

        if (termId === 'all') {
            // Remove filter for this taxonomy
            delete window.cptFilters[blockId][tax];
        } else {
            window.cptFilters[blockId][tax] = termId;
        }

        // Reset offset
        window['countPosts_' + blockId] = 0;

        // Reload posts with filters
        loadCptPosts(blockId, true);
    });

    function loadCptPosts(blockId, replace) {
        const blockData = window['loadMoreData_' + blockId];
        const filters = window.cptFilters[blockId] || {};
        const $container = $('[data-block-id="' + blockId + '"] .il_inner_posts_container');
        const $button = $('[data-block-id="' + blockId + '"] .load-more-cpt-button');

        // Initialize or reset countPosts
        if (typeof window['countPosts_' + blockId] === 'undefined' || replace) {
            window['countPosts_' + blockId] = 0;
        }

        // If this is the initial load and we already have posts, set the count
        if (!replace && window['countPosts_' + blockId] === 0 && $container.find('article').length > 0) {
            window['countPosts_' + blockId] = blockData.postsPerPage;
        }

        $.ajax({
            type: 'GET',
            url: '/wp-admin/admin-ajax.php',
            data: {
                countPosts: window['countPosts_' + blockId],
                post_type: blockData.extraData.post_type,
                show_date: blockData.extraData.show_date,
                learn_more_text: blockData.extraData.learn_more_text,
                carousel: blockData.extraData.carousel,
                show_homepage_image: blockData.extraData.show_homepage_image,
                posts_per_page: blockData.postsPerPage,
                action: 'load_more_posts_cpt_block',
                filters: filters
            },
        }).done(function (resp) {
            let data;
            try {
                data = JSON.parse(resp);
            } catch (e) {
                data = { html: resp, total_found: 0 };
            }

            if (replace) {
                $container.empty().html(data.html);
                window['countPosts_' + blockId] = blockData.postsPerPage;
            } else {
                $container.append(data.html);
                window['countPosts_' + blockId] += blockData.postsPerPage;
            }

            // Hide button if all posts loaded
            if (window['countPosts_' + blockId] >= data.total_found) {
                $button.hide();
            } else {
                $button.show();
            }
        });
    }

    // Update Load More to send filters
    $(document).on('click', '.load-more-cpt-button', function (e) {
        e.preventDefault();
        const blockId = $(this).data('block-id');
        loadCptPosts(blockId, false);
    });

});

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {
	scrollFunction();
	
	document.getElementById("backToTopButton").addEventListener("click", function() {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	});
};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("backToTopButton").style.opacity = "1";
  } else {
    document.getElementById("backToTopButton").style.opacity = "0";
  }
}
