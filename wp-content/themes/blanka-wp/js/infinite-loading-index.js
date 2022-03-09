(function ($) {
    "use strict";
    var count = 1;

    if (parseInt(ajax_var.posts_per_page_index) < parseInt(ajax_var.total_index)) {
        $('.more-posts').css('visibility', 'visible');
        $('.more-posts').animate({opacity: 1}, 1500);
    } else {
        $('.more-posts').css('display', 'none');
    }

    $('.more-posts:visible').on('click', function () {
        count++;
        loadArticleIndex(count);
        $('.more-posts').css('display', 'none');
        $('.more-posts-loading').css('display', 'inline-block');
    });

    function loadArticleIndex(pageNumber) {
        $.ajax({
            url: ajax_var.url,
            type: 'POST',
            data: "action=infinite_scroll_index&page_no_index=" + pageNumber + '&loop_file_index=loop-index+&security=' + ajax_var.nonce,
            success: function (html) {
                $(".blog-holder").append(html);
                $(".blog-holder").imagesLoaded(function () {
                    animateElement();

                    if (count == ajax_var.num_pages_index)
                    {
                        $('.more-posts').css('display', 'none');
                        $('.more-posts-loading').css('display', 'none');
                        $('.no-more-posts').css('display', 'inline-block');
                    } else
                    {
                        $('.more-posts').css('display', 'inline-block');
                        $('.more-posts-loading').css('display', 'none');
                    }
                });
            }
        });
        return false;
    }

    function animateElement(e) {
        $(".animate").each(function (i) {
            var top_of_object = $(this).offset().top;
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            if ((bottom_of_window - 70) > top_of_object) {
                $(this).addClass('show-it');
            }
        });
    }

})(jQuery);