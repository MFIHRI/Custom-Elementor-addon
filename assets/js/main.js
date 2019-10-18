/* ---------------------------------------------
 common scripts
 --------------------------------------------- */

;(function ($) {

    "use strict"; // use strict to start

    $(document).ready(function () {
        // thumbnail slier
        $('.js_hero_thumb').owlCarousel({
            loop: true,
            items: 1,
            thumbs: true,
            autoplay: true,
            nav: true,
            navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']
        });
    });

})(jQuery);