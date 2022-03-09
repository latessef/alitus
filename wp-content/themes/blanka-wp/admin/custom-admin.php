<?php
/*
 * Register Theme Customizer
 */
add_action('customize_register', 'blanka_theme_customize_register');

function blanka_theme_customize_register($wp_customize) {

    function blanka_clean_html($value) {
        $allowed_html_array = blanka_allowed_html();
        $value = wp_kses($value, $allowed_html_array);
        return $value;
    }

    class BlankaWP_Customize_Textarea_Control extends WP_Customize_Control {

        public $type = 'textarea';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <textarea rows="10" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>
            <?php
        }

    }

    //----------------------------- BLOG SECTION  ---------------------------------------------

    $wp_customize->add_section('blanka_home_section', array(
        'title' => esc_html__('Blog Settings', 'blanka-wp'),
        'priority' => 32
    ));

    $wp_customize->add_setting('blanka_blog_title', array(
        'default' => '',
        'sanitize_callback' => 'blanka_clean_html'
    ));

    $wp_customize->add_control('blanka_blog_title', array(
        'label' => esc_html__('Blog Title:', 'blanka-wp'),
        'section' => 'blanka_home_section',
        'settings' => 'blanka_blog_title',
        'priority' => 999
    ));

    $wp_customize->add_setting('blanka_blog_description', array(
        'default' => '',
        'sanitize_callback' => 'blanka_clean_html'
    ));

    $wp_customize->add_control(new BlankaWP_Customize_Textarea_Control($wp_customize, 'blanka_blog_description', array(
        'label' => esc_html__('Blog Description', 'blanka-wp'),
        'section' => 'blanka_home_section',
        'settings' => 'blanka_blog_description',
        'priority' => 999
    )));

    $wp_customize->add_setting('blanka_show_post_thumbnail', array(
        'default' => 'yes',
        'sanitize_callback' => 'blanka_clean_html'
    ));

    $wp_customize->add_control('blanka_show_post_thumbnail', array(
        'label' => esc_html__('Show Post Thumbnail on Blog Page', 'blanka-wp'),
        'section' => 'blanka_home_section',
        'settings' => 'blanka_show_post_thumbnail',
        'priority' => 999,
        'type' => 'radio',
        'choices' => array(
            'yes' => esc_html__('Yes', 'blanka-wp'),
            'no' => esc_html__('No', 'blanka-wp'),
    )));




    //----------------------------- END HOME (BLOG) SECTION  ---------------------------------------------
    //
    //
    //
    //----------------------------- PORTFOLIO SECTION  ---------------------------------------------
    if (post_type_exists('portfolio')) {
        $wp_customize->add_section('blanka_portfolio_section', array(
            'title' => esc_html__('Portfolio settings', 'blanka-wp'),
            'priority' => 32
        ));

        $wp_customize->add_setting('blanka_show_nav_portfolio', array(
            'default' => 'no',
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control('blanka_show_nav_portfolio', array(
            'label' => esc_html__('Show Prev/Next on Single Portfolio', 'blanka-wp'),
            'section' => 'blanka_portfolio_section',
            'settings' => 'blanka_show_nav_portfolio',
            'type' => 'radio',
            'choices' => array(
                'yes' => esc_html__('Yes', 'blanka-wp'),
                'no' => esc_html__('No', 'blanka-wp'),
        )));
    }

    //----------------------------- END PORTFOLIO SECTION  ---------------------------------------------
    //
    //
    //----------------------------- IMAGE SECTION  ---------------------------------------------

    $wp_customize->add_section('blanka_image_section', array(
        'title' => esc_html__('Images Section', 'blanka-wp'),
        'priority' => 33
    ));


    $wp_customize->add_setting('blanka_preloader', array(
        'default' => get_template_directory_uri() . '/images/preloader.gif',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'blanka_preloader', array(
        'label' => esc_html__('Preloader Gif', 'blanka-wp'),
        'section' => 'blanka_image_section',
        'settings' => 'blanka_preloader'
    )));

    $wp_customize->add_setting('blanka_header_logo', array(
        'default' => get_template_directory_uri() . '/images/logo.png',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'blanka_header_logo', array(
        'label' => esc_html__('Header Logo', 'blanka-wp'),
        'section' => 'blanka_image_section',
        'settings' => 'blanka_header_logo'
    )));

    //----------------------------- END IMAGE SECTION  ---------------------------------------------
    //
    //
    //
    //----------------------------------COLORS SECTION--------------------

    $wp_customize->add_setting('blanka_menu_background', array(
        'default' => '#221c5a',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'blanka_menu_background', array(
        'label' => esc_html__('Menu & Footer Background Color', 'blanka-wp'),
        'section' => 'colors',
        'settings' => 'blanka_menu_background'
    )));

    $wp_customize->add_setting('blanka_global_color', array(
        'default' => '#7762a1',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'blanka_global_color', array(
        'label' => esc_html__('Global Body Color', 'blanka-wp'),
        'section' => 'colors',
        'settings' => 'blanka_global_color'
    )));

    $wp_customize->add_setting('blanka_global_link_color', array(
        'default' => '#e625a4',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'blanka_global_link_color', array(
        'label' => esc_html__('Global Link Color', 'blanka-wp'),
        'section' => 'colors',
        'settings' => 'blanka_global_link_color'
    )));

    $wp_customize->add_setting('blanka_page_title_color', array(
        'default' => '#7b06b0',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'blanka_page_title_color', array(
        'label' => esc_html__('Global Page Title Color', 'blanka-wp'),
        'section' => 'colors',
        'settings' => 'blanka_page_title_color'
    )));

    $wp_customize->add_setting('blanka_page_title_background', array(
        'default' => '#efe2ff',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'blanka_page_title_background', array(
        'label' => esc_html__('Global Page Title Background', 'blanka-wp'),
        'section' => 'colors',
        'settings' => 'blanka_page_title_background'
    )));

    $wp_customize->add_setting('blanka_page_des', array(
        'default' => '#62408c',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'blanka_page_des', array(
        'label' => esc_html__('Global Page Description Color', 'blanka-wp'),
        'section' => 'colors',
        'settings' => 'blanka_page_des'
    )));


    //----------------------------------------------------------------------------------------------
    //
    //
    //
      //------------------------- FOOTER TEXT SECTION ---------------------------------------------

    $wp_customize->add_section('blanka_footer_text_section', array(
        'title' => esc_html__('Footer Text', 'blanka-wp'),
        'priority' => 99
    ));

    $wp_customize->add_setting('blanka_footer_copyright_content', array(
        'default' => '',
        'sanitize_callback' => 'blanka_clean_html'
    ));

    $wp_customize->add_control(new BlankaWP_Customize_Textarea_Control($wp_customize, 'blanka_footer_copyright_content', array(
        'label' => esc_html__('Footer Copyright Content:', 'blanka-wp'),
        'section' => 'blanka_footer_text_section',
        'settings' => 'blanka_footer_copyright_content',
        'priority' => 999
    )));


    $wp_customize->add_setting('blanka_footer_social_content', array(
        'default' => '',
        'sanitize_callback' => 'blanka_clean_html'
    ));

    $wp_customize->add_control(new BlankaWP_Customize_Textarea_Control($wp_customize, 'blanka_footer_social_content', array(
        'label' => esc_html__('Footer Social Content', 'blanka-wp'),
        'section' => 'blanka_footer_text_section',
        'settings' => 'blanka_footer_social_content',
        'priority' => 999
    )));



    //---------------------------- END FOOTER TEXT SECTION --------------------------
    //
    //
    //--------------------------------------------------------------------------
    $wp_customize->get_setting('blanka_menu_background')->transport = 'postMessage';
    $wp_customize->get_setting('blanka_global_link_color')->transport = 'postMessage';
    $wp_customize->get_setting('blanka_global_color')->transport = 'postMessage';
    $wp_customize->get_setting('blanka_page_title_color')->transport = 'postMessage';
    $wp_customize->get_setting('blanka_page_title_background')->transport = 'postMessage';
    $wp_customize->get_setting('blanka_page_des')->transport = 'postMessage';
    //--------------------------------------------------------------------------
    /*
     * If preview mode is active, hook JavaScript to preview changes
     */
    if ($wp_customize->is_preview() && !is_admin()) {
        add_action('customize_preview_init', 'blanka_theme_customize_preview_js');
    }
}

/**
 * Bind Theme Customizer JavaScript
 */
function blanka_theme_customize_preview_js() {
    wp_enqueue_script('blanka-wp-theme-customizer', get_template_directory_uri() . '/admin/js/custom-admin.js', array('customize-preview'), '20120910', true);
}

/*
 * Generate CSS Styles
 */

class BlankaWPLiveCSS {

    public static function blanka_theme_customized_style() {
        echo '<style type="text/css">' .
        //Menu & Footer Background
        blanka_generate_css('.single .site-wrapper h1.entry-title, .site-wrapper ul.comment-author-date-replay-holder li.comment-author', 'color', 'blanka_menu_background') .
        blanka_generate_css('.site-wrapper .header-holder, .site-wrapper .sm-clean ul, .site-wrapper .footer, .site-wrapper .menu-holder', 'background-color', 'blanka_menu_background') .
        //Global Body Color
        blanka_generate_css('body .site-wrapper, .single .site-wrapper .nav-links a, .site-wrapper .comment-form-holder a, .single .site-wrapper .entry-info a, .single .site-wrapper .nav-links a', 'color', 'blanka_global_color') .
        //Global Link Color
        blanka_generate_css('body .site-wrapper a, body .site-wrapper a:hover, .site-wrapper .sm-clean a:hover, .site-wrapper .main-menu.sm-clean .sub-menu li a:hover, .site-wrapper .sm-clean li.active a, .site-wrapper .sm-clean li.current-page-ancestor > a, .site-wrapper .sm-clean li.current_page_ancestor > a, .site-wrapper .sm-clean li.current_page_item > a, .site-wrapper .blog-item-holder:hover h4 a, .site-wrapper .blog-item-holder .big-circle, .navigation.pagination a:hover, .single .site-wrapper .entry-info a:hover, .single .site-wrapper .wp-link-pages, .single .site-wrapper .nav-links a:hover, .site-wrapper .comment-form-holder a:hover, .site-wrapper .replay-at-author, .site-wrapper .text-slider-header-quotes:before, .site-wrapper .pricing-table-price', 'color', 'blanka_global_link_color') .
        blanka_generate_css('.site-wrapper .tags-holder a, .site-wrapper blockquote:not(.cocobasic-block-pullquote)', 'border-color', 'blanka_global_link_color') .
        blanka_generate_css('.site-wrapper .blog-item-holder h4 a span:after, .site-wrapper .blog-item-holder .big-circle:before, .blog .site-wrapper .more-posts,  .blog .site-wrapper .no-more-posts, .blog .site-wrapper .more-posts-loading, .site-wrapper .navigation.pagination .current, .site-wrapper .tags-holder a, .site-wrapper .form-submit input[type=submit], .site-wrapper .wpcf7 input[type=submit], .site-wrapper a.service-link, .site-wrapper .slick-dots li.slick-active button:before, .site-wrapper a.button, .site-wrapper .social-holder .social, .site-wrapper .v-skill-fill, .site-wrapper .category-filter-list .button:hover, .site-wrapper .category-filter-list .button.is-checked, .site-wrapper .portfolio-arrow', 'background-color', 'blanka_global_link_color') .
        blanka_generate_css('.site-wrapper .blog-item-holder h4 a span:after, .site-wrapper .form-submit input[type=submit], .site-wrapper .wpcf7 input[type=submit], .site-wrapper a.service-link, .site-wrapper a.button, .site-wrapper .category-filter-list .button:hover, .site-wrapper .category-filter-list .button.is-checked', 'box-shadow', 'blanka_global_link_color', '', '', true) .
        blanka_generate_css('body .site-wrapper ::selection', 'background-color', 'blanka_global_link_color') .
        blanka_generate_css('body .site-wrapper ::-moz-selection', 'background-color', 'blanka_global_link_color') .
        //Global Page Title Color
        blanka_generate_css('.site-wrapper .section h2.entry-title, .page-template-default.page .site-wrapper .section h1.entry-title, .blog .site-wrapper h1.entry-title, .search .site-wrapper h1.entry-title, .archive .site-wrapper h1.entry-title', 'color', 'blanka_page_title_color') .
        //Global Page Description Color
        blanka_generate_css('.site-wrapper .section h2.entry-title, .page-template-default.page .site-wrapper .section h1.entry-title, .blog .site-wrapper h1.entry-title, .search .site-wrapper h1.entry-title, .archive .site-wrapper h1.entry-title', 'background-color', 'blanka_page_title_background') .
        //Global Page Description Color
        blanka_generate_css('.site-wrapper .blog-item-holder h4 a, .site-wrapper .section .page-description, .site-wrapper .blog .page-description, .site-wrapper #commentform #email, .site-wrapper #commentform #author, .site-wrapper #commentform #comment, .site-wrapper .wpcf7-form, .site-wrapper .wpcf7 input[type=text], .site-wrapper .wpcf7 input[type=email], .site-wrapper .wpcf7 textarea, .site-wrapper h5.service-title, .site-wrapper .big-text, .site-wrapper .big-number', 'color', 'blanka_page_des') .
        blanka_generate_css('.site-wrapper #commentform input[type=text]::-webkit-input-placeholder, .site-wrapper #commentform input[type=email]::-webkit-input-placeholder, .site-wrapper #commentform textarea::-webkit-input-placeholder, .site-wrapper .wpcf7 input[type=text]::-webkit-input-placeholder, .site-wrapper .wpcf7 input[type=email]::-webkit-input-placeholder, .site-wrapper .wpcf7 textarea::-webkit-input-placeholder', 'color', 'blanka_page_des') .
        blanka_generate_css('.site-wrapper #commentform input[type=text]::-moz-placeholder, .site-wrapper #commentform input[type=email]::-moz-placeholder, .site-wrapper #commentform textarea::-moz-placeholder, .site-wrapper .wpcf7 input[type=text]::-moz-placeholder, .site-wrapper .wpcf7 input[type=email]::-moz-placeholder, .site-wrapper .wpcf7 textarea::-moz-placeholder', 'color', 'blanka_page_des') .
        blanka_generate_css('.site-wrapper #commentform input[type=text]:-ms-input-placeholder, .site-wrapper #commentform input[type=email]:-ms-input-placeholder, .site-wrapper #commentform textarea:-ms-input-placeholder, .site-wrapper .wpcf7 input[type=text]:-ms-input-placeholder, .site-wrapper .wpcf7 input[type=email]:-ms-input-placeholder, .site-wrapper .wpcf7 textarea:-ms-input-placeholder', 'color', 'blanka_page_des') .
        blanka_generate_css('.site-wrapper #commentform input[type=text]:-moz-placeholder, .site-wrapper #commentform input[type=email]:-moz-placeholder, .site-wrapper #commentform textarea:-moz-placeholder, .site-wrapper .wpcf7 input[type=text]:-moz-placeholder, .site-wrapper .wpcf7 input[type=email]:-moz-placeholder, .site-wrapper .wpcf7 textarea:-moz-placeholder', 'color', 'blanka_page_des') .
        blanka_generate_css('.single.single-portfolio .site-wrapper ol.comments-list-holder', 'border-color', 'blanka_page_des') .
        blanka_generate_css('.site-wrapper .pricing-table-title', 'background-color', 'blanka_page_des') .
        '</style>';
    }
}

/*
 * Generate CSS Class - Helper Method
 */

function blanka_generate_css($selector, $style, $mod_name, $prefix = '', $postfix = '', $rgba = '') {
    $return = '';
    $mod = get_option($mod_name);
    if (!empty($mod)) {
        if ($rgba === true) {
            $mod = '0px 0px 50px 0px ' . blanka_hex2rgba($mod, 0.65);
        }
        $return = sprintf('%s { %s:%s; }', $selector, $style, $prefix . $mod . $postfix
        );
    }
    return $return;
}

function blanka_hex2rgba($color, $opacity = false) {

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if (empty($color))
        return $default;

    //Sanitize $color if "#" is provided 
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string
    return $output;
}
?>