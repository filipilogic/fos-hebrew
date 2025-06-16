/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/js/custom.js":
/*!*********************************!*\
  !*** ./assets/src/js/custom.js ***!
  \*********************************/
/***/ (() => {

jQuery(document).ready(function ($) {
  // Mobile navigation

  $(".menu-toggle").click(function () {
    $("#primary-menu").toggleClass('mobile-menu-visible'); // Toggles mobile-menu-visible class and fades the menu in/out
    $(this).toggleClass('menu-open');
  });
  $("#primary-menu li").click(function () {
    // Get the first <a> element within the clicked li
    var ulElement = $(this).find("ul");

    // Check if the href attribute doesn't only contain "#"
    if (!ulElement.hasClass('sub-menu')) {
      var windowsize = $(window).width();
      if (windowsize < 1200) {
        $("#primary-menu").fadeToggle();
        $(".menu-toggle").toggleClass('menu-open');
      }
    }
  });

  // Sub Menu Trigger

  $("#primary-menu li.menu-item-has-children > a").after('<span class="sub-menu-trigger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span>');
  $(".menu-item-has-children").click(function () {
    var windowsize = $(window).width();
    if (windowsize < 1200) {
      $(this).toggleClass('sub-menu-open');
      $(this).find(".sub-menu").slideToggle();
    }
  });

  // AJAX Load More bttn
  $(document).on('click', '.ilLoadMore', function (e) {
    e.preventDefault(); //prevent default action

    var category = $(this).data('category');
    var postCategory = 'all';
    if (category) {
      postCategory = category;
    }
    if (!window.countPosts) {
      window.countPosts = 4;
    }
    $.ajax({
      type: 'GET',
      url: '/wp-admin/admin-ajax.php',
      data: {
        countPosts: window.countPosts,
        postCategory: postCategory,
        action: 'blog_load_more'
      }
    }).done(function (resp) {
      window.countPosts += 4;
      $('.il_archive_more').html(resp);
    });
  });

  // Store selected filters per block
  window.cptFilters = window.cptFilters || {};
  $(document).on('click', '.cpt-filter-term', function (e) {
    e.preventDefault(); // Prevent default anchor behavior
    var $term = $(this);
    var blockId = $term.closest('[data-block-id]').data('block-id');
    var tax = $term.data('tax');
    var termId = $term.data('term');

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
    var blockData = window['loadMoreData_' + blockId];
    var filters = window.cptFilters[blockId] || {};
    var $container = $('[data-block-id="' + blockId + '"] .il_inner_posts_container');
    var $button = $('[data-block-id="' + blockId + '"] .load-more-cpt-button');

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
      }
    }).done(function (resp) {
      var data;
      try {
        data = JSON.parse(resp);
      } catch (e) {
        data = {
          html: resp,
          total_found: 0
        };
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
    var blockId = $(this).data('block-id');
    loadCptPosts(blockId, false);
  });
});

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
  document.getElementById("backToTopButton").addEventListener("click", function () {
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

/***/ }),

/***/ "./assets/src/sass/frontend.scss":
/*!***************************************!*\
  !*** ./assets/src/sass/frontend.scss ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!***********************************!*\
  !*** ./assets/src/js/frontend.js ***!
  \***********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _sass_frontend_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../sass/frontend.scss */ "./assets/src/sass/frontend.scss");
/* harmony import */ var _js_custom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../js/custom */ "./assets/src/js/custom.js");
/* harmony import */ var _js_custom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_js_custom__WEBPACK_IMPORTED_MODULE_1__);
/**
 * SASS
 */


/**
 * JavaScript
 */


})();

/******/ })()
;