(function ($) {
    "use stict";

//FIx for Big Number Counter
    var k = 1;
    $(".big-number-start").each(function () {
        $(this).attr('id', 'count' + k);
        k++;
    });

    $(window).on('scroll', function () {
        animateCounterUp();
    });

//Portfolio Item Hover Fix
    $(".grid-item a.item-link").on('hover', function () {
        $(this).toggleClass("highlighted");
    });
	

//Text slider
    $(".text-slider").each(function () {
        var id = $(this).attr('id');

        var auto_value = window[id + '_auto'];
        var hover_pause = window[id + '_hover'];
        var speed_value = window[id + '_speed'];

        auto_value = (auto_value === 'true') ? true : false;
        hover_pause = (hover_pause === 'true') ? true : false;

        $('#' + id).slick({
            arrows: true,
            dots: false,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 750,
            autoplay: auto_value,
            autoplaySpeed: speed_value,
            pauseOnHover: hover_pause,
            fade: true,
            draggable: true,
            adaptiveHeight: true
        });
    });

//Image slider
    $(".image-slider").each(function () {
        var id = $(this).attr('id');

        var auto_value = window[id + '_auto'];
        var hover_pause = window[id + '_hover'];
        var speed_value = window[id + '_speed'];

        auto_value = (auto_value === 'true') ? true : false;
        hover_pause = (hover_pause === 'true') ? true : false;

        $('#' + id).slick({
            arrows: false,
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 750,
            autoplay: auto_value,
            autoplaySpeed: speed_value,
            pauseOnHover: hover_pause,
            fade: true,
            draggable: true,
            adaptiveHeight: true
        });
    });

//PrettyPhoto initial
    $('a[data-rel]').each(function () {
        $(this).attr('rel', $(this).data('rel'));
    });

    $("a[rel^='prettyPhoto']").prettyPhoto({
        slideshow: false, /* false OR interval time in ms */
        overlay_gallery: false, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
        default_width: 1280,
        default_height: 720,
        deeplinking: false,
        social_tools: false,
        iframe_markup: '<iframe src ="{path}" width="{width}" height="{height}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'
    });

//Portfolio
    var grid = $('.grid').imagesLoaded(function () {
        grid.isotope({
            itemSelector: '.grid-item',
            masonry: {
                columnWidth: '.grid-sizer'
            }
        });
        
        $('.filters-button-group').on('click', '.button', function () {
            var filterValue = $(this).attr('data-filter');
            grid.isotope({filter: filterValue});
            grid.on('arrangeComplete', function () {
                $(".grid-item:visible a[rel^='prettyPhoto']").prettyPhoto({
                    slideshow: false, /* false OR interval time in ms */
                    overlay_gallery: false, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
                    default_width: 1280,
                    default_height: 720,
                    deeplinking: false,
                    social_tools: false,
                    iframe_markup: '<iframe src ="{path}" width="{width}" height="{height}" frameborder="no" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'
                });
            });
        });

        // change is-checked class on buttons
        $('.button-group').each(function (i, buttonGroup) {
            var $buttonGroup = $(buttonGroup);
            $buttonGroup.on('click', '.button', function () {
                $buttonGroup.find('.is-checked').removeClass('is-checked');
                $(this).addClass('is-checked');
            });
        });
    });


    $(window).on('load', function () {
        animateCounterUp();
    });
    
    function animateCounterUp(e) {
        $(".big-number-content:not(.animate-done)").each(function () {
            var top_of_object = $(this).offset().top;
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            if ((bottom_of_window - 70) > top_of_object) {

                $(this).addClass("animate-done");
                //Big Number Count Up
                var options = {
                    useEasing: true,
                    useGrouping: true,
                    separator: ' ',
                    decimal: '.'
                };

                var start = parseInt($(this).find(".big-number-start").html().replace(/\s+/g, ''));
                var stop = parseInt($(this).find(".big-number-stop").html().replace(/\s+/g, ''));
                var duration = parseInt($(this).find(".big-number-duration").html().replace(/\s+/g, ''));


                var demo = new CountUp($(this).find(".big-number-start").attr("id"), start, stop, 0, duration, options);
                if (!demo.error) {
                    demo.start();
                } else {
                    console.error(demo.error);
                }
            }
        });
    }
})(jQuery);