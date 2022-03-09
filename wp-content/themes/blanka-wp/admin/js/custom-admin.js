(function ($) {

    "use strict";

    // COLORS                         
    wp.customize('blanka_menu_background', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;            

            inlineStyle = '<style class="custom-color-css1">';
            inlineStyle += '.single .site-wrapper h1.entry-title, .site-wrapper ul.comment-author-date-replay-holder li.comment-author { color: ' + to + '; }';                        
            inlineStyle += '.site-wrapper .header-holder, .site-wrapper .sm-clean ul, .site-wrapper .footer, .site-wrapper .menu-holder { background-color: ' + to + '; }';                        
            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css1');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });


    wp.customize('blanka_global_color', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;            

            inlineStyle = '<style class="custom-color-css2">';
            inlineStyle += 'body .site-wrapper, .single .site-wrapper .nav-links a, .site-wrapper .comment-form-holder a, .single .site-wrapper .entry-info a, .single .site-wrapper .nav-links a { color: ' + to + '; }';                        
            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css2');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });


    wp.customize('blanka_global_link_color', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;            
            var rgba = cocobasic_hexToRGB(to, 0.65);            
            
            inlineStyle = '<style class="custom-color-css3">';            
            inlineStyle += 'body .site-wrapper a, body .site-wrapper a:hover, .site-wrapper .sm-clean a:hover, .site-wrapper .main-menu.sm-clean .sub-menu li a:hover, .site-wrapper .sm-clean li.active a, .site-wrapper .sm-clean li.current-page-ancestor > a, .site-wrapper .sm-clean li.current_page_ancestor > a, .site-wrapper .sm-clean li.current_page_item > a, .site-wrapper .blog-item-holder:hover h4 a, .site-wrapper .blog-item-holder .big-circle, .navigation.pagination a:hover, .single .site-wrapper .entry-info a:hover, .single .site-wrapper .wp-link-pages, .single .site-wrapper .nav-links a:hover, .site-wrapper .comment-form-holder a:hover, .site-wrapper .replay-at-author, .site-wrapper .text-slider-header-quotes:before, .site-wrapper .pricing-table-price { color: ' + to + '; }';
            inlineStyle += '.site-wrapper .tags-holder a, .site-wrapper blockquote:not(.cocobasic-block-pullquote) { border-color: ' + to + '; }';
            inlineStyle += '.site-wrapper .blog-item-holder h4 a span:after, .site-wrapper .blog-item-holder .big-circle:before, .blog .site-wrapper .more-posts,  .blog .site-wrapper .no-more-posts, .blog .site-wrapper .more-posts-loading, .site-wrapper .navigation.pagination .current, .site-wrapper .tags-holder a, .site-wrapper .form-submit input[type=submit], .site-wrapper .wpcf7 input[type=submit], .site-wrapper a.service-link, .site-wrapper .slick-dots li.slick-active button:before, .site-wrapper a.button, .site-wrapper .social-holder .social, .site-wrapper .v-skill-fill, .site-wrapper .category-filter-list .button:hover, .site-wrapper .category-filter-list .button.is-checked, .site-wrapper .portfolio-arrow { background-color: ' + to + '; }';
            inlineStyle += '.site-wrapper .blog-item-holder h4 a span:after, .site-wrapper .form-submit input[type=submit], .site-wrapper .wpcf7 input[type=submit], .site-wrapper a.service-link, .site-wrapper a.button, .site-wrapper .category-filter-list .button:hover, .site-wrapper .category-filter-list .button.is-checked { box-shadow: 0px 0px 50px 0px ' + rgba + '; }';
            inlineStyle += 'body .site-wrapper ::selection { background-color: ' + to + '; }';
            inlineStyle += 'body .site-wrapper ::-moz-selection { background-color: ' + to + '; }';            
            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css3');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });
    
    
    wp.customize('blanka_page_title_color', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;                        
            
            inlineStyle = '<style class="custom-color-css4">';            
            inlineStyle += '.site-wrapper .section h2.entry-title, .page-template-default.page .site-wrapper .section h1.entry-title, .blog .site-wrapper h1.entry-title, .search .site-wrapper h1.entry-title, .archive .site-wrapper h1.entry-title { color: ' + to + '; }';            
            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css4');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });
    
    
    wp.customize('blanka_page_title_background', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;                        
            
            inlineStyle = '<style class="custom-color-css5">';            
            inlineStyle += '.site-wrapper .section h2.entry-title, .page-template-default.page .site-wrapper .section h1.entry-title, .blog .site-wrapper h1.entry-title, .search .site-wrapper h1.entry-title, .archive .site-wrapper h1.entry-title { background-color: ' + to + '; }';            
            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css5');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });
    
    
    wp.customize('blanka_page_des', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;                        
            
            inlineStyle = '<style class="custom-color-css6">';            
            inlineStyle += '.site-wrapper .blog-item-holder h4 a, .site-wrapper .section .page-description, .site-wrapper .blog .page-description, .site-wrapper #commentform #email, .site-wrapper #commentform #author, .site-wrapper #commentform #comment, .site-wrapper .wpcf7-form, .site-wrapper .wpcf7 input[type=text], .site-wrapper .wpcf7 input[type=email], .site-wrapper .wpcf7 textarea, .site-wrapper h5.service-title, .site-wrapper .big-text, .site-wrapper .big-number { color: ' + to + '; }';            
            inlineStyle += '.site-wrapper #commentform input[type=text]::-webkit-input-placeholder, .site-wrapper #commentform input[type=email]::-webkit-input-placeholder, .site-wrapper #commentform textarea::-webkit-input-placeholder, .site-wrapper .wpcf7 input[type=text]::-webkit-input-placeholder, .site-wrapper .wpcf7 input[type=email]::-webkit-input-placeholder, .site-wrapper .wpcf7 textarea::-webkit-input-placeholder { color: ' + to + '; }';            
            inlineStyle += '.site-wrapper #commentform input[type=text]::-moz-placeholder, .site-wrapper #commentform input[type=email]::-moz-placeholder, .site-wrapper #commentform textarea::-moz-placeholder, .site-wrapper .wpcf7 input[type=text]::-moz-placeholder, .site-wrapper .wpcf7 input[type=email]::-moz-placeholder, .site-wrapper .wpcf7 textarea::-moz-placeholder { color: ' + to + '; }';            
            inlineStyle += '.site-wrapper #commentform input[type=text]:-ms-input-placeholder, .site-wrapper #commentform input[type=email]:-ms-input-placeholder, .site-wrapper #commentform textarea:-ms-input-placeholder, .site-wrapper .wpcf7 input[type=text]:-ms-input-placeholder, .site-wrapper .wpcf7 input[type=email]:-ms-input-placeholder, .site-wrapper .wpcf7 textarea:-ms-input-placeholder { color: ' + to + '; }';            
            inlineStyle += '.site-wrapper #commentform input[type=text]:-moz-placeholder, .site-wrapper #commentform input[type=email]:-moz-placeholder, .site-wrapper #commentform textarea:-moz-placeholder, .site-wrapper .wpcf7 input[type=text]:-moz-placeholder, .site-wrapper .wpcf7 input[type=email]:-moz-placeholder, .site-wrapper .wpcf7 textarea:-moz-placeholder { color: ' + to + '; }';            
            inlineStyle += '.single.single-portfolio .site-wrapper ol.comments-list-holder { border-color: ' + to + '; }';            
            inlineStyle += '.site-wrapper .pricing-table-title { background-color: ' + to + '; }';            
            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css6');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });


    function cocobasic_hexToRGB(hex, alpha) {
        var r = parseInt(hex.slice(1, 3), 16),
                g = parseInt(hex.slice(3, 5), 16),
                b = parseInt(hex.slice(5, 7), 16);

        if (alpha) {
            return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
        } else {
            return "rgb(" + r + ", " + g + ", " + b + ")";
        }
    }

})(jQuery);