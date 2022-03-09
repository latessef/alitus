<?php

/*
  Plugin Name: CocoBasic - Blanka WP
  Description: User interface used in Blanka WP theme.
  Version: 1.4
  Author: CocoBasic
  Author URI: https://www.cocobasic.com
 */


if (!defined('ABSPATH'))
    die("Can't load this file directly");

class cocobasic_shortcodes {

    function __construct() {        
        add_action('init', array($this, 'myplugin_load_textdomain'));
        add_action('admin_init', array($this, 'cocobasic_plugin_admin_enqueue_script'));
        add_action('wp_enqueue_scripts', array($this, 'cocobasic_plugin_enqueue_script'));
        if ((version_compare(get_bloginfo('version'), '5.0', '<')) || (class_exists( 'Classic_Editor' )) ) {
            add_action('admin_init', array($this, 'cocobasic_action_admin_init'));
        }
    }

    function cocobasic_action_admin_init() {
        // only hook up these filters if the current user has permission
        // to edit posts and pages
        if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
            add_filter('mce_buttons', array($this, 'cocobasic_filter_mce_button'));
            add_filter('mce_external_plugins', array($this, 'cocobasic_filter_mce_plugin'));
        }
    }

    function cocobasic_filter_mce_button($buttons) {
        // add a separation before the new button
        array_push($buttons, '|', 'cocobasic_shortcodes_button');
        return $buttons;
    }

    function cocobasic_filter_mce_plugin($plugins) {
        // this plugin file will work the magic of our button
        $plugins['shortcodes_options'] = plugin_dir_url(__FILE__) . 'editor_plugin.js';
        return $plugins;
    }

    function myplugin_load_textdomain() {
        load_plugin_textdomain('cocobasic-shortcode', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    function cocobasic_plugin_admin_enqueue_script() {
        wp_enqueue_style('colorpicker', plugins_url('css/colorpicker.css', __FILE__));
        wp_enqueue_style('admin-style', plugins_url('css/admin-style.css', __FILE__));

        wp_enqueue_script('colorpicker-js', plugins_url('js/colorpicker.js', __FILE__), array('jquery'), '', true);
        wp_enqueue_script('cocobasic-admin-main-js', plugins_url('js/admin-main.js', __FILE__), array('jquery'), '', true);
    }

    function cocobasic_plugin_enqueue_script() {

        wp_enqueue_style('prettyPhoto', plugins_url('css/prettyPhoto.css', __FILE__));
        wp_enqueue_style('slick', plugins_url('css/slick.css', __FILE__));
        wp_enqueue_style('cocobasic-main-plugin-style', plugins_url('css/style.css', __FILE__));
        
        wp_enqueue_script('imagesloaded');
        wp_enqueue_script('isotope', plugins_url('js/isotope.pkgd.js', __FILE__), array('jquery'), '', true);
        wp_enqueue_script('jquery-prettyPhoto', plugins_url('js/jquery.prettyPhoto.js', __FILE__), array('jquery'), '', true);
        wp_enqueue_script('slick', plugins_url('js/slick.min.js', __FILE__), array('jquery'), '', true);
        wp_enqueue_script('jquery-easing', plugins_url('js/jquery.easing.1.3.js', __FILE__), array('jquery'), '', true);
        wp_enqueue_script('countUp', plugins_url('js/countUp.min.js', __FILE__), array('jquery'), '', true);
        wp_enqueue_script('cocobasic-main-js', plugins_url('js/main.js', __FILE__), array('jquery'), '', true);
    }

}

$cocobasic_shortcodes = new cocobasic_shortcodes();

add_theme_support('post-thumbnails', array('portfolio'));
add_action('add_meta_boxes', 'cocobasic_add_page_custom_meta_box');
add_action('add_meta_boxes', 'cocobasic_add_portfolio_custom_meta_box');
add_action('save_post', 'cocobasic_save_page_custom_meta');
add_action('save_post', 'cocobasic_save_portfolio_custom_meta');
add_action('init', 'cocobasic_allowed_plugin_html');
add_filter("the_content", "cocobasic_the_content_filter");
add_action('wp_ajax_nopriv_post-like', 'cocobasic_post_like');
add_action('wp_ajax_post-like', 'cocobasic_post_like');
add_filter('body_class', 'cocobasic_browserBodyClass');

//<editor-fold defaultstate="collapsed" desc="Inline Page CSS">
function cocobasic_inline_page_css($pageID) {
    if ($pageID != "-1") {
        $args = array('p' => $pageID, 'post_type' => 'page', 'posts_per_page' => '1');
    } else {
        $args = array('post_type' => 'page', 'posts_per_page' => '-1', 'orderby' => 'menu_order', 'order' => 'ASC');
    }
    $inlinePageCss = '';
    $inlineContactPageCss = '';
    $loop = new WP_Query($args);
    global $post;
    if ($loop->have_posts()) :
        while ($loop->have_posts()) : $loop->the_post();
            if ('onepage.php' != get_page_template_slug($post->ID)) {
                $inlinePageCss .= '.section.post-' . $post->ID . '{';
                if (get_post_meta($post->ID, "page_background_img", true) != ''):
                    $inlinePageCss .= 'background-image: url("' . get_post_meta($post->ID, "page_background_img", true) . '"); ';
                endif;

                if (get_post_meta($post->ID, "page_background_color", true) != ''):
                    $inlinePageCss .= 'background-color:' . get_post_meta($post->ID, "page_background_color", true) . '; ';
                endif;

                if (get_post_meta($post->ID, "page_img_position", true) != ''):
                    $inlinePageCss .= 'background-position:' . get_post_meta($post->ID, "page_img_position", true) . '; ';
                endif;

                if (get_post_meta($post->ID, "page_img_repeat", true) != ''):
                    $inlinePageCss .= 'background-repeat:' . get_post_meta($post->ID, "page_img_repeat", true) . '; ';
                endif;

                if (get_post_meta($post->ID, "page_img_size", true) != ''):
                    $inlinePageCss .= 'background-size:' . get_post_meta($post->ID, "page_img_size", true) . '; ';
                endif;

                if (get_post_meta($post->ID, "page_img_attachment", true) != ''):
                    $inlinePageCss .= 'background-attachment:' . get_post_meta($post->ID, "page_img_attachment", true) . '; ';
                endif;

                if (get_post_meta($post->ID, "page_custom_css", true) != ''):
                    $inlinePageCss .= get_post_meta($post->ID, "page_custom_css", true) . ' ';
                endif;

                if (get_post_meta($post->ID, "page_full_screen", true) == 'yes'):
                    $inlinePageCss .= 'min-height: calc(100vh - 220px); ';
                endif;

                if ('page-contact.php' == get_page_template_slug($post->ID)) {
                    if (get_post_meta($post->ID, "page_contact_left_background_color", true) != ''):
                        $inlineContactPageCss .= '.section.post-' . $post->ID . ' .contact-page-left{';
                        $inlineContactPageCss .= 'background-color:' . get_post_meta($post->ID, "page_contact_left_background_color", true) . '; ';
                        $inlineContactPageCss .= '} ';
                    endif;
                }

                $inlinePageCss .= '} ';
            }
        endwhile;
    endif;
    wp_reset_postdata();
    return $inlinePageCss . $inlineContactPageCss;
}

// </editor-fold>
//<editor-fold defaultstate="collapsed" desc="Inline Portfolio Item CSS">
function cocobasic_inline_portfolio_css($postID) {
    $args = array('p' => $postID, 'post_type' => 'portfolio', 'posts_per_page' => '1');
    $inlinePortfolioCss = '';
    $loop = new WP_Query($args);
    if ($loop->have_posts()) :
        while ($loop->have_posts()) : $loop->the_post();

            $inlinePortfolioCss .= '.section.post-' . $postID . '{';
            if (get_post_meta($postID, "portfolio_background_img", true) != ''):
                $inlinePortfolioCss .= 'background-image: url("' . get_post_meta($postID, "portfolio_background_img", true) . '"); ';
            endif;

            if (get_post_meta($postID, "portfolio_background_color", true) != ''):
                $inlinePortfolioCss .= 'background-color:' . get_post_meta($postID, "portfolio_background_color", true) . '; ';
            endif;

            if (get_post_meta($postID, "portfolio_img_position", true) != ''):
                $inlinePortfolioCss .= 'background-position:' . get_post_meta($postID, "portfolio_img_position", true) . '; ';
            endif;

            if (get_post_meta($postID, "portfolio_img_repeat", true) != ''):
                $inlinePortfolioCss .= 'background-repeat:' . get_post_meta($postID, "portfolio_img_repeat", true) . '; ';
            endif;

            if (get_post_meta($postID, "portfolio_img_size", true) != ''):
                $inlinePortfolioCss .= 'background-size:' . get_post_meta($postID, "portfolio_img_size", true) . '; ';
            endif;

            $inlinePortfolioCss .= '} ';
        endwhile;
    endif;
    wp_reset_postdata();
    return $inlinePortfolioCss;
}

// </editor-fold>
//<editor-fold defaultstate="collapsed" desc="Columns shortcode">
function cocobasic_col($atts, $content = null) {
    extract(shortcode_atts(array(
        "size" => 'one',
        "class" => ''
                    ), $atts));

    switch ($size) {
        case "one":
            $return = '<div class = "one ' . $class . '">
    ' . do_shortcode($content) . '
    </div><div class = "clear"></div>';
            break;
        case "one_half_last":
            $return = '<div class = "one_half last ' . $class . '">' . do_shortcode($content) . '</div><div class = "clear"></div>';
            break;
        case "one_third_last":
            $return = '<div class = "one_third last ' . $class . '">' . do_shortcode($content) . '</div><div class = "clear"></div>';
            break;
        case "two_third_last":
            $return = '<div class = "two_third last ' . $class . '">' . do_shortcode($content) . '</div><div class = "clear"></div>';
            break;
        case "one_fourth_last":
            $return = '<div class = "one_fourth last ' . $class . '">' . do_shortcode($content) . '</div><div class = "clear"></div>';
            break;
        case "three_fourth_last":
            $return = '<div class = "three_fourth last ' . $class . '">' . do_shortcode($content) . '</div><div class = "clear"></div>';
            break;
        default:
            $return = '<div class = "' . $size . ' ' . $class . '">' . do_shortcode($content) . '</div>';
    }

    return $return;
}

add_shortcode("col", "cocobasic_col");

// </editor-fold>
//<editor-fold defaultstate="collapsed" desc="BR shortcode">
function cocobasic_br($atts, $content = null) {
    return '<br />';
}

add_shortcode("br", "cocobasic_br");

//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="Button shortcode">
function cocobasic_button($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "target" => '_self',
        "href" => '#',
        "position" => 'left'
                    ), $atts));

    switch ($position) {
        case 'center':
            $position = "center-text";
            break;
        case 'right':
            $position = "text-right";
            break;
        default:
            $position = "text-left";
    }

    $return = '<div class="' . $position . '"><a href="' . $href . '" target="' . $target . '" class="button ' . $class . '">' . do_shortcode($content) . '</a></div>';

    return $return;
}

add_shortcode("button", "cocobasic_button");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Service shortcode">
function cocobasic_service($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "title" => '',
        "img" => '',
        "alt" => '',
        "href" => '#',
        "target" => '_self'
                    ), $atts));

    if (($href != '') && ($href != '#')) {
        $return = '<div class="service-item relative ' . $class . '"><img class="service-icon" src="' . $img . '" alt="' . $alt . '"/><h5 class="service-title">' . $title . '</h5><div class="service-content">' . do_shortcode($content) . '</div><a class="service-link scroll" href="' . $href . '" target="' . $target . '"></a></div>';
    } else {
        $return = '<div class="service-item relative ' . $class . '"><img class="service-icon" src="' . $img . '" alt="' . $alt . '"/><h5 class="service-title">' . $title . '</h5><div class="service-content">' . do_shortcode($content) . '</div></div>';
    }

    return $return;
}

add_shortcode("service", "cocobasic_service");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Curve Text shortcode">
function cocobasic_curve_text($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));

    $return = '<h1 class="curve-text ' . $class . '">' . do_shortcode($content) . '</h1>';

    return $return;
}

add_shortcode("curve_text", "cocobasic_curve_text");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Medium Font shortcode">
function cocobasic_med_text($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));

    $return = '<p class="medium-text ' . $class . '">' . do_shortcode($content) . '</p>';

    return $return;
}

add_shortcode("med_text", "cocobasic_med_text");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Big Font shortcode">
function cocobasic_big_text($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));

    $return = '<p class="big-text ' . $class . '">' . do_shortcode($content) . '</p>';

    return $return;
}

add_shortcode("big_text", "cocobasic_big_text");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Intro Description shortcode">
function cocobasic_intro_desc($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));

    $return = '<p class="intro-description ' . $class . '"> ' . do_shortcode($content) . '</p>';

    return $return;
}

add_shortcode("intro_desc", "cocobasic_intro_desc");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Text Slider holder shortcode">
function cocobasic_text_slider($atts, $content = null) {
    extract(shortcode_atts(array(
        "name" => 'textSlider',
        "auto" => 'true',
        "hover_pause" => 'true',
        "speed" => '2000'
                    ), $atts));


    $return = '<script> var ' . $name . '_speed = "' . $speed . '";
                var ' . $name . '_auto = "' . $auto . '";                
                var ' . $name . '_hover = "' . $hover_pause . '";                
    </script>
    <div class="text-slider-wrapper relative">
    <div class="text-slider-header-quotes center"></div>
    <div id = ' . $name . ' class = "text-slider slider">
            ' . do_shortcode($content) . '
        </div>';


    $return .= '<div class = "clear"></div></div>';

    return $return;
}

add_shortcode("text_slider", "cocobasic_text_slider");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Text Slide shortcode">
function cocobasic_text_slide($atts, $content = null) {
    extract(shortcode_atts(array(
        "img" => '',
        "alt" => '',
        "name" => '',
        "position" => ''
                    ), $atts));

    return '<div class="text-slide"><p class="text-slide-content">' . do_shortcode($content) . '</p><img class="text-slide-img" src="' . $img . '" alt="' . $alt . '" /><p class="text-slide-name">' . $name . '</p><p class="text-slide-position">' . $position . '</p></div>';
}

add_shortcode("text_slide", "cocobasic_text_slide");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Image Slider holder short code">
function cocobasic_image_slider($atts, $content = null) {
    extract(shortcode_atts(array(
        "name" => 'slider',
        "auto" => 'true',
        "hover_pause" => 'true',
        "speed" => '2000'
                    ), $atts));


    $return = '<script> var ' . $name . '_speed = "' . $speed . '";
                var ' . $name . '_auto = "' . $auto . '";                
                var ' . $name . '_hover = "' . $hover_pause . '";                
    </script>
    <div class="image-slider-wrapper relative">
    <div id = ' . $name . ' class = "image-slider slider">
            ' . do_shortcode($content) . '
        </div>';


    $return .= '<div class = "clear"></div></div>';

    return $return;
}

add_shortcode("image_slider", "cocobasic_image_slider");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Image Slide short code">
function cocobasic_image_slide($atts, $content = null) {
    extract(shortcode_atts(array(
        "img" => '',
        "href" => '',
        "alt" => '',
        "target" => '_self'
                    ), $atts));
    if ($href != '') {
        return '<div><a href="' . $href . '" target="' . $target . '"><img src = "' . $img . '" alt = "' . $alt . '" /></a></div>';
    } else {
        return '<div><img src = "' . $img . '" alt = "' . $alt . '" /></div>';
    }
}

add_shortcode("image_slide", "cocobasic_image_slide");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Member shortcode">
function cocobasic_member($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "name" => '',
        "position" => '',
        "img" => '',
        "alt" => ''
                    ), $atts));

    $return = '<div class="member ' . $class . '"><img class="member-img" src="' . $img . '" alt="' . $alt . '"/><div class="member-info"><p class="member-name">' . $name . '</p><p class="member-position">' . $position . '</p><div class="member-content">' . do_shortcode($content) . '</div></div></div>';

    return $return;
}

add_shortcode("member", "cocobasic_member");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Social Holder shortcode">
function cocobasic_social_holder($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));

    $return = '<div class="social-holder ' . $class . '">' . do_shortcode($content) . '</div>';
    return $return;
}

add_shortcode("social_holder", "cocobasic_social_holder");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Social shortcode">
function cocobasic_social($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "icon" => '',
        "href" => '',
        "target" => '_blank'
                    ), $atts));

    $return = '<div class="social ' . $class . '"><a href="' . $href . '" target="' . $target . '"><span class="fa fa-' . $icon . '"></span></a></div>';
    return $return;
}

add_shortcode("social", "cocobasic_social");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Pricing shortcode">
function cocobasic_pricing($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "title" => '',
        "button_text" => '',
        "price" => '',
        "sub_price" => '',
        "href" => '#',
        "target" => '_self'
                    ), $atts));


    $return = '<div class="pricing-table ' . $class . '">
                    <div class="pricing-table-header">
                        <div class="pricing-table-title">' . $title . '</div>                                                
                    </div>
                    <div class="pricing-table-price">' . $price . '</div>
                    <div class="pricing-table-desc">' . $sub_price . '</div>
                    <div class="pricing-table-content-holder">
                        
			' . do_shortcode($content) . '
		    </div>                    
                    <a href="' . $href . '" class="button" target="' . $target . '">
                        ' . $button_text . '
		    </a>
            </div>';

    return $return;
}

add_shortcode("pricing", "cocobasic_pricing");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Portfolio shortcode">
function cocobasic_portfolio($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));

    $return = '<div class="portfolio-wrapper">
            <div class="category-filter-list button-group filters-button-group">
                <div class="button is-checked" data-filter="*">' . esc_html__('All', 'cocobasic-shortcode') . '</div>' . cocobasic_drop_cats_filter() . '
            </div>';

    global $post;
    $args = array('post_type' => 'portfolio', 'posts_per_page' => '-1');
    $loop = new WP_Query($args);
    if ($loop->have_posts()) :
        $return .= '<div class="grid" id="portfolio-grid"><div class="grid-sizer"></div>';
        while ($loop->have_posts()) : $loop->the_post();
            if (has_post_thumbnail($post->ID)) {
                $portfolio_post_thumb = get_the_post_thumbnail();
            } else {
                $portfolio_post_thumb = '<img src = "' . get_template_directory_uri() . '/images/no-photo.png" alt = "" />';
            }

            $p_size = get_post_meta($post->ID, "portfolio_thumb_image_size", true);

            if (get_post_meta($post->ID, "portfolio_hover_thumb_title", true) != ''):
                $p_thumb_title = get_post_meta($post->ID, "portfolio_hover_thumb_title", true);
            else:
                $p_thumb_title = get_the_title();
            endif;

            $p_thumb_text = get_post_meta($post->ID, "portfolio_hover_thumb_text", true);
            $link_thumb_to = get_post_meta($post->ID, "portfolio_link_item_to", true);

            switch ($link_thumb_to):
                case 'link_to_image_url':
                    $image_popup = get_post_meta($post->ID, "portfolio_image_popup", true);
                    $return .= '<div class="grid-item element-item ' . $p_size . ' ' . cocobasic_drop_cats_slug($post->ID) . '"><a class="item-link" href="' . $image_popup . '" data-rel="prettyPhoto[gallery1]">';
                    break;
                case 'link_to_video_url':
                    $video_popup = get_post_meta($post->ID, "portfolio_video_popup", true);
                    $return .= '<div class="grid-item element-item ' . $p_size . ' ' . cocobasic_drop_cats_slug($post->ID) . '"><a class="item-link" href="' . $video_popup . '" data-rel="prettyPhoto[gallery1]">';
                    break;
                case 'link_to_extern_url':
                    $extern_site_url = get_post_meta($post->ID, "portfolio_extern_site_url", true);
                    $return .= '<div class="grid-item element-item ' . $p_size . ' ' . cocobasic_drop_cats_slug($post->ID) . '"><a class="item-link" href="' . $extern_site_url . '" target="_blank">';
                    break;

                default:
                    $return .= '<div class="grid-item element-item ' . $p_size . ' ' . cocobasic_drop_cats_slug($post->ID) . '"><a class="item-link" href="' . get_permalink() . '">';
            endswitch;

            $return .= $portfolio_post_thumb . '<div class="portfolio-text-holder"><p class="portfolio-arrow"></p><p class="portfolio-title">' . $p_thumb_title . '</p><p class="portfolio-desc">' . $p_thumb_text . '</p></div></a></div>';

        endwhile;

        $return .= '</div>';
    endif;
    $return .= '<div class="clear"></div></div>';
    wp_reset_postdata();
    return $return;
}

add_shortcode("portfolio", "cocobasic_portfolio");

//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="Full Page Width">
function cocobasic_full_width($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "background" => ''
                    ), $atts));

    if ($background != ''):
        $return = '</div><div class="full-page-width center-relative' . $class . '" style="background-image:url(' . $background . ')">' . do_shortcode($content) . '</div><div class="block content-1070 center-relative section-content resume">';
    else:
        $return = '</div><div class="full-page-width center-relative' . $class . '">' . do_shortcode($content) . '</div><div class="block content-1070 center-relative section-content resume">';
    endif;

    return $return;
}

add_shortcode("full_width", "cocobasic_full_width");

//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="Full Portfolio Width">
function cocobasic_p_full_width($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));


    $return = '</div><div class="full-portfolio-width center-relative' . $class . '">' . do_shortcode($content) . '</div><div class="content-wrapper resume">';

    return $return;
}

add_shortcode("p_full_width", "cocobasic_p_full_width");

//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="Vertical Skills Holder shortcode">
function cocobasic_v_skills($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));

    $return = '<div class="v-skills-holder ' . $class . '"><span class="v-skills-level"></span><span class="v-skills-level-2"></span>' . do_shortcode($content) . '</div>';
    return $return;
}

add_shortcode("v_skills", "cocobasic_v_skills");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Vertical Skill shortcode">
function cocobasic_v_skill($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "percent" => '50%',
        "text" => 'PhP'
                    ), $atts));

    $return = '<div class="v-skill ' . $class . '"><div class="v-skill-fill" style="width: ' . $percent . '; height:' . $percent . ';"></div><span class="v-skill-text">' . $text . '</span></div>';
    return $return;
}

add_shortcode("v_skill", "cocobasic_v_skill");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Video PopUP shortcode">
function cocobasic_video_up($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "name" => 'video1',
        "thumb" => '',
        "alt" => '',
        "video" => ''
                    ), $atts));

    $return = '<a class="video-popup-holder ' . $class . '" href="' . $video . '" data-rel="prettyPhoto[gallery-' . $name . ']"><img class="thumb" src=' . $thumb . ' alt="' . $alt . '" /><p class="popup-play"></p></a>';
    return $return;
}

add_shortcode("video_up", "cocobasic_video_up");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Contact Info shortcode">
function cocobasic_info($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "icon" => '',
                    ), $atts));

    $return = '<div class="contact-info"><span class="fa fa-' . $icon . '"></span><p class="contact-info-content">' . do_shortcode($content) . '</p></div>';
    return $return;
}

add_shortcode("info", "cocobasic_info");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Big Number shortcode">
function cocobasic_big_number($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "start" => '',
        "stop" => '',
        "speed" => '5',
        "icon" => '',
        "alt" => '',
        "up_text" => '',
        "down_text" => ''
                    ), $atts));

    $return = '<div class="big-number ' . $class . '">';
    if ($icon != ''):
        $return .= '<img src="' . $icon . '" alt="' . $alt . '" />';
    endif;

    if ($up_text != ''):
        $return .= '<p class="big-number-content"><span class="big-number-start">' . $start . '</span> <span class="up-text">' . $up_text . '</span><span class="big-number-stop hidden">' . $stop . '</span><span class="big-number-duration hidden">' . $speed . '</span></p>';
    else :
        $return .= '<p class="big-number-content"><span class="big-number-start">' . $start . '</span><span class="big-number-stop hidden">' . $stop . '</span><span class="big-number-duration hidden">' . $speed . '</span></p>';
    endif;

    if ($down_text != ''):
        $return .= '<p class="big-down-text">' . $down_text . '</p>';
    endif;

    $return .= '</div>';

    return $return;
}

add_shortcode("big_number", "cocobasic_big_number");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Latest posts shortcode">
function cocobasic_latest_posts($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "num" => 5
                    ), $atts));
    global $post;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $num
    );


    $loop = new WP_Query($args);
    $return = '<div class="blog-holder block center-relative">';

    while ($loop->have_posts()) : $loop->the_post();
        $return .= '<article id="post-' . $post->ID . '"  class="relative animate blog-item-holder center-relative latest-posts-scode">';
        $return .= '<h4 class="entry-title"><a href="' . get_permalink($post->ID) . '">' . get_the_title() . ' <span class="arrow"></span></a></h4>
                    <div class="entry-date published">' . get_the_date('F Y') . '</div>
		    <div class="author vcard ">' . get_the_author() . '</div>               
				<div class="clear"></div>';

        $return .= '</article>';

    endwhile;
    $return .= '</div>';
    wp_reset_postdata();
    return $return;
}

add_shortcode("latest_posts", "cocobasic_latest_posts");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Register custom 'portfolio' post type">
function create_portfolio() {
    $portfolio_args = array(
        'label' => esc_html__('Portfolio', 'cocobasic-shortcode'),
        'singular_label' => esc_html__('Portfolio', 'cocobasic-shortcode'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => true,
        'supports' => array('title', 'editor', 'comments', 'custom-fields', 'thumbnail'),
        'show_in_rest' => true
    );
    register_post_type('portfolio', $portfolio_args);
}

add_action('init', 'create_portfolio');

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Register Portfolio category">
function create_portfolio_taxonomies() {
    $labels = array(
        'name' => esc_html__('Portfolio Category', 'cocobasic-shortcode'),
        'singular_name' => esc_html__('Portfolio Category', 'cocobasic-shortcode'),
        'search_items' => esc_html__('Search Portfolio Category', 'cocobasic-shortcode'),
        'all_items' => esc_html__('All Categories', 'cocobasic-shortcode'),
        'parent_item' => esc_html__('Parent Category', 'cocobasic-shortcode'),
        'parent_item_colon' => esc_html__('Parent Category:', 'cocobasic-shortcode'),
        'edit_item' => esc_html__('Edit Portfolio Category', 'cocobasic-shortcode'),
        'update_item' => esc_html__('Update Portfolio Category', 'cocobasic-shortcode'),
        'add_new_item' => esc_html__('Add New Portfolio Category', 'cocobasic-shortcode'),
        'new_item_name' => esc_html__('New Portfolio Category', 'cocobasic-shortcode'),
        'menu_name' => esc_html__('Portfolio Category', 'cocobasic-shortcode'),
    );
    register_taxonomy('portfolio-category', array('portfolio'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'portfolio-category'),
        'show_in_rest' => true
    ));
}

add_action('init', 'create_portfolio_taxonomies');

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Add the Meta Box to 'Portfolio' posts"> 
function cocobasic_add_portfolio_custom_meta_box() {
    add_meta_box(
            'cocobasic_portfolio_custom_meta_box', // $id  
            esc_html__('Portfolio Preference', 'cocobasic-shortcode'), // $title   
            'cocobasic_show_portfolio_custom_meta_box', // $callback  
            'portfolio', // $page  
            'normal', // $context  
            'high'); // $priority     
}

// Field Array Post Page 
$prefix = 'portfolio_';
$portfolio_custom_meta_fields = array(
    array(
        'label' => esc_html__('Custom thumb title on mouse over', 'cocobasic-shortcode'),
        'desc' => esc_html__('by default is used item title', 'cocobasic-shortcode'),
        'id' => $prefix . 'hover_thumb_title',
        'type' => 'text'
    ),
    array(
        'label' => esc_html__('Thumb text on mouse over (second line)', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'hover_thumb_text',
        'type' => 'text'
    ),
    array(
        'label' => esc_html__('Thumb image size', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'thumb_image_size',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => '33%',
                'value' => 'p_one_third'
            ),
            'two' => array(
                'label' => '66%',
                'value' => 'p_two_third'
            ),
            'three' => array(
                'label' => '100%',
                'value' => 'p_one'
            )
        )
    ),
    array(
        'label' => esc_html__('Link thumb to', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'link_item_to',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => esc_html__('This post', 'cocobasic-shortcode'),
                'value' => 'link_to_this_post'
            ),
            'two' => array(
                'label' => esc_html__('Image', 'cocobasic-shortcode'),
                'value' => 'link_to_image_url'
            ),
            'three' => array(
                'label' => esc_html__('Video', 'cocobasic-shortcode'),
                'value' => 'link_to_video_url'
            ),
            'four' => array(
                'label' => esc_html__('External URL', 'cocobasic-shortcode'),
                'value' => 'link_to_extern_url'
            )
        )
    ),
    array(
        'label' => esc_html__('Link thumb to Image:', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'image_popup',
        'type' => 'text'
    ),
    array(
        'label' => esc_html__('Link thumb to Video', 'cocobasic-shortcode'),
        'desc' => esc_html__('For example: http://vimeo.com/XXXXXX or http://www.youtube.com/watch?v=XXXXXX', 'cocobasic-shortcode'),
        'id' => $prefix . 'video_popup',
        'type' => 'text'
    ),
    array(
        'label' => esc_html__('Link thumb to External URL:', 'cocobasic-shortcode'),
        'desc' => esc_html__('Set URL to external site', 'cocobasic-shortcode'),
        'id' => $prefix . 'extern_site_url',
        'type' => 'text'
    ),
    array(
        'label' => __('Post Background Color', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'background_color',
        'type' => 'text'
    ),
    array(
        'label' => __('Post Background Image URL', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'background_img',
        'type' => 'text'
    ),
    array(
        'label' => __('Background Image Position', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'img_position',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'Left Top',
                'value' => 'left top'
            ),
            'two' => array(
                'label' => 'Left Center',
                'value' => 'left center'
            ),
            'three' => array(
                'label' => 'Left Bottom',
                'value' => 'left bottom'
            ),
            'four' => array(
                'label' => 'Center Top',
                'value' => 'center top'
            ),
            'five' => array(
                'label' => 'Center Center',
                'value' => 'center center'
            ),
            'six' => array(
                'label' => 'Center Bottom',
                'value' => 'center bottom'
            ),
            'seven' => array(
                'label' => 'Right Top',
                'value' => 'right top'
            ),
            'eight' => array(
                'label' => 'Right Center',
                'value' => 'right center'
            ),
            'nine' => array(
                'label' => 'Right Bottom',
                'value' => 'right bottom'
            )
        )
    ),
    array(
        'label' => __('Background Image Repeat', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'img_repeat',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'No Repeat',
                'value' => 'no-repeat'
            ),
            'two' => array(
                'label' => 'Repeat-X',
                'value' => 'repeat-x'
            ),
            'three' => array(
                'label' => 'Repeat-Y',
                'value' => 'repeat-y'
            ),
            'four' => array(
                'label' => 'Repeat All',
                'value' => 'repeat'
            )
        )
    ), array(
        'label' => __('Background Image Size', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'img_size',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'Auto',
                'value' => 'auto'
            ),
            'two' => array(
                'label' => 'Cover',
                'value' => 'cover'
            ),
            'three' => array(
                'label' => 'Width 100%',
                'value' => '100% auto'
            )
        )
    ),
    array(
        'label' => __('Post Header Content', 'cocobasic-shortcode'),
        'desc' => esc_html__('optional', 'cocobasic-shortcode'),
        'id' => $prefix . 'header_content',
        'type' => 'textarea'
    )
);

// The Callback  
function cocobasic_show_portfolio_custom_meta_box() {
    global $portfolio_custom_meta_fields, $post;
    $allowed_plugin_tags = cocobasic_allowed_plugin_html();
// Use nonce for verification  
    echo '<input type="hidden" name="custom_meta_box_nonce" value="' . esc_attr(wp_create_nonce(basename(__FILE__))) . '" />';
// Begin the field table and loop  
    echo '<table class="form-table">';
    foreach ($portfolio_custom_meta_fields as $field) {
// get value of this field if it exists for this post  
        $meta = get_post_meta($post->ID, $field['id'], true);
// begin a table row with  
        echo '<tr> 
                <th><label for="' . esc_attr($field['id']) . '">' . esc_attr($field['label']) . '</label></th> 
                <td>';
        switch ($field['type']) {
// case items will go here  
// text  
            case 'text':

                if ($field['id'] == 'portfolio_image_popup') {
                    echo '<label for="upload_image">
				<input id="' . esc_attr($field['id']) . '" class="image-url-input" type="text" size="36" name="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" /> 
				<input id="upload_image_button" class="button" type="button" value="' . esc_attr__('Upload Image', 'cocobasic-shortcode') . '" />
                                <br /><span class="image-upload-desc">' . esc_html($field['desc']) . '</span>                                                                    
                                <span id="small-background-image-preview" class="has-background"></span>				
				</label>';
                } elseif ($field['id'] == 'portfolio_background_color') {
                    echo '<div id="colorPortfolioBackgroundColor"><div></div></div>
                      <input style="display:none" type="text" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="50" /> 
                <br /><span class="description">' . esc_html($field['desc']) . '</span>';
                } elseif ($field['id'] == 'portfolio_background_img') {
                    echo '<label for="upload_image">
				<input id="' . esc_attr($field['id']) . '" class="image-url-input" type="text" size="36" name="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" /> 
				<input id="upload_image_button2" class="button" type="button" value="' . esc_attr__('Upload Image', 'cocobasic-shortcode') . '" />
                                <br /><span class="image-upload-desc">' . esc_html($field['desc']) . '</span>                                                                    
                                <span id="small-background-image-preview2" class="has-background"></span>				
				</label>';
                } else {
                    echo '<input type="text" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="50" /> 
						<br /><span class="description">' . esc_html($field['desc']) . '</span>';
                }
                break;
// select  
            case 'select':
                echo '<select name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="' . esc_attr($option['value']) . '">' . esc_html($option['label']) . '</option>';
                }
                echo '</select><br /><span class="description">' . esc_html($field['desc']) . '</span>';
                break;
// textarea  
            case 'textarea':
                echo '<textarea name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" cols="60" rows="4">' . wp_kses($meta, $allowed_plugin_tags) . '</textarea> 
					<br /><span class="description">' . esc_html($field['desc']) . '</span>';
                break;
        } //end switch  
        echo '</td></tr>';
    } // end foreach  
    echo '</table>'; // end table  
}

// Save the Data  
function cocobasic_save_portfolio_custom_meta($post_id) {
    global $portfolio_custom_meta_fields;
    $allowed_plugin_tags = cocobasic_allowed_plugin_html();
// verify nonce  
    if (isset($_POST['custom_meta_box_nonce'])) {
        if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }
    }
// check autosave  
// Stop WP from clearing custom fields on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
// Prevent quick edit from clearing custom fields
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
// check permissions  
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
// loop through fields and save the data  
    foreach ($portfolio_custom_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = null;
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }
        if ($new && $new != $old) {
            $new = wp_kses($new, $allowed_plugin_tags);
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach  
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Add the Meta Box to 'Pages'"> 
function cocobasic_add_page_custom_meta_box() {
    add_meta_box(
            'cocobasic_page_custom_meta_box', // $id  
            esc_html__('Page Preference', 'cocobasic-shortcode'), // $title   
            'cocobasic_show_page_custom_meta_box', // $callback  
            'page', // $page  
            'normal', // $context  
            'high'); // $priority     
}

// Field Array Post Page 
$prefix = 'page_';

$page_contact_custom_meta_fields = array(
    array(
        'label' => __('Contact Form Code', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'contact_form',
        'type' => 'text'
    ),
    array(
        'label' => __('Left Part Content Background Color', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'contact_left_background_color',
        'type' => 'text'
    ),
    array(
        'label' => __('Show Page Title', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'show_title',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'Yes',
                'value' => 'yes'
            ),
            'two' => array(
                'label' => 'No',
                'value' => 'no'
            )
        )
    ),
    array(
        'label' => __('Page Custom Title', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'custom_title',
        'type' => 'text'
    ),
    array(
        'label' => __('Page Description', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'description',
        'type' => 'textarea'
    ),
    array(
        'label' => __('Page Background Color', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'background_color',
        'type' => 'text'
    ),
    array(
        'label' => __('Page Background Image URL', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'background_img',
        'type' => 'text'
    ),
    array(
        'label' => __('Background Image Position', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'img_position',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'Left Top',
                'value' => 'left top'
            ),
            'two' => array(
                'label' => 'Left Center',
                'value' => 'left center'
            ),
            'three' => array(
                'label' => 'Left Bottom',
                'value' => 'left bottom'
            ),
            'four' => array(
                'label' => 'Center Top',
                'value' => 'center top'
            ),
            'five' => array(
                'label' => 'Center Center',
                'value' => 'center center'
            ),
            'six' => array(
                'label' => 'Center Bottom',
                'value' => 'center bottom'
            ),
            'seven' => array(
                'label' => 'Right Top',
                'value' => 'right top'
            ),
            'eight' => array(
                'label' => 'Right Center',
                'value' => 'right center'
            ),
            'nine' => array(
                'label' => 'Right Bottom',
                'value' => 'right bottom'
            )
        )
    ),
    array(
        'label' => __('Background Image Repeat', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'img_repeat',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'No Repeat',
                'value' => 'no-repeat'
            ),
            'two' => array(
                'label' => 'Repeat-X',
                'value' => 'repeat-x'
            ),
            'three' => array(
                'label' => 'Repeat-Y',
                'value' => 'repeat-y'
            ),
            'four' => array(
                'label' => 'Repeat All',
                'value' => 'repeat'
            )
        )
    ), array(
        'label' => __('Background Image Size', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'img_size',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'Auto',
                'value' => 'auto'
            ),
            'two' => array(
                'label' => 'Cover',
                'value' => 'cover'
            ),
            'three' => array(
                'label' => 'Width 100%',
                'value' => '100% auto'
            )
        )
    ),
    array(
        'label' => __('Background Image Scroll', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'img_attachment',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'Normal',
                'value' => 'scroll'
            ),
            'two' => array(
                'label' => 'Parallax',
                'value' => 'fixed'
            )
        )
    ),
    array(
        'label' => __('Page Structure', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'structure',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => __('Separated / Stand Alone Page', 'cocobasic-shortcode'),
                'value' => '1'
            ),
            'two' => array(
                'label' => __('Include in One Page', 'cocobasic-shortcode'),
                'value' => '2'
            )
        )
    ),
    array(
        'label' => __('Page Custom CSS', 'cocobasic-shortcode'),
        'desc' => __('additional CSS just for this page (optional)', 'cocobasic-shortcode'),
        'id' => $prefix . 'custom_css',
        'type' => 'textarea'
    )
);


$page_custom_meta_fields = array(
    array(
        'label' => __('Show Page Title', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'show_title',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'Yes',
                'value' => 'yes'
            ),
            'two' => array(
                'label' => 'No',
                'value' => 'no'
            )
        )
    ),
    array(
        'label' => __('Page Custom Title', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'custom_title',
        'type' => 'text'
    ),
    array(
        'label' => __('Page Description', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'description',
        'type' => 'textarea'
    ),
    array(
        'label' => __('Full Screen Page', 'cocobasic-shortcode'),
        'desc' => __('minimal page height to fit screen', 'cocobasic-shortcode'),
        'id' => $prefix . 'full_screen',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'No',
                'value' => 'no'
            ),
            'two' => array(
                'label' => 'Yes',
                'value' => 'yes'
            )
        )
    ),
    array(
        'label' => __('Page Background Color', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'background_color',
        'type' => 'text'
    ),
    array(
        'label' => __('Page Background Image URL', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'background_img',
        'type' => 'text'
    ),
    array(
        'label' => __('Background Image Position', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'img_position',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'Left Top',
                'value' => 'left top'
            ),
            'two' => array(
                'label' => 'Left Center',
                'value' => 'left center'
            ),
            'three' => array(
                'label' => 'Left Bottom',
                'value' => 'left bottom'
            ),
            'four' => array(
                'label' => 'Center Top',
                'value' => 'center top'
            ),
            'five' => array(
                'label' => 'Center Center',
                'value' => 'center center'
            ),
            'six' => array(
                'label' => 'Center Bottom',
                'value' => 'center bottom'
            ),
            'seven' => array(
                'label' => 'Right Top',
                'value' => 'right top'
            ),
            'eight' => array(
                'label' => 'Right Center',
                'value' => 'right center'
            ),
            'nine' => array(
                'label' => 'Right Bottom',
                'value' => 'right bottom'
            )
        )
    ),
    array(
        'label' => __('Background Image Repeat', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'img_repeat',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'No Repeat',
                'value' => 'no-repeat'
            ),
            'two' => array(
                'label' => 'Repeat-X',
                'value' => 'repeat-x'
            ),
            'three' => array(
                'label' => 'Repeat-Y',
                'value' => 'repeat-y'
            ),
            'four' => array(
                'label' => 'Repeat All',
                'value' => 'repeat'
            )
        )
    ), array(
        'label' => __('Background Image Size', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'img_size',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'Auto',
                'value' => 'auto'
            ),
            'two' => array(
                'label' => 'Cover',
                'value' => 'cover'
            ),
            'three' => array(
                'label' => 'Width 100%',
                'value' => '100% auto'
            )
        )
    ),
    array(
        'label' => __('Background Image Scroll', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'img_attachment',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'Normal',
                'value' => 'scroll'
            ),
            'two' => array(
                'label' => 'Parallax',
                'value' => 'fixed'
            )
        )
    ),
    array(
        'label' => __('Page Structure', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'structure',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => __('Separated / Stand Alone Page', 'cocobasic-shortcode'),
                'value' => '1'
            ),
            'two' => array(
                'label' => __('Include in One Page', 'cocobasic-shortcode'),
                'value' => '2'
            )
        )
    ),
    array(
        'label' => __('Scroll Animation', 'cocobasic-shortcode'),
        'desc' => __('show scroll animation on bottom of page', 'cocobasic-shortcode'),
        'id' => $prefix . 'scroll',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'No',
                'value' => 'no'
            ),
            'two' => array(
                'label' => 'Yes',
                'value' => 'yes'
            )
        )
    ),
    array(
        'label' => __('Page Custom CSS', 'cocobasic-shortcode'),
        'desc' => __('additional CSS just for this page (optional)', 'cocobasic-shortcode'),
        'id' => $prefix . 'custom_css',
        'type' => 'textarea'
    )
);

// The Callback  
function cocobasic_show_page_custom_meta_box() {
    global $page_custom_meta_fields, $page_contact_custom_meta_fields, $post;

    $page_fields = $page_custom_meta_fields;

    if (!empty($post)) {
        $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);
        if ($pageTemplate == 'page-contact.php') {
            $page_fields = $page_contact_custom_meta_fields;
        }
    }

    $allowed_plugin_tags = cocobasic_allowed_plugin_html();
// Use nonce for verification  
    echo '<input type="hidden" name="custom_meta_box_nonce" value="' . esc_attr(wp_create_nonce(basename(__FILE__))) . '" />';
// Begin the field table and loop  
    echo '<table class="form-table">';
    foreach ($page_fields as $field) {
// get value of this field if it exists for this post  
        $meta = get_post_meta($post->ID, $field['id'], true);
// begin a table row with  
        echo '<tr> 
                <th><label for="' . esc_attr($field['id']) . '">' . esc_attr($field['label']) . '</label></th> 
                <td>';
        switch ($field['type']) {
// case items will go here  
// text  
            case 'text':
                if ($field['id'] == 'page_background_img') {
                    echo '<label for="upload_image">
				<input id="' . esc_attr($field['id']) . '" class="image-url-input" type="text" size="36" name="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" /> 
				<input id="upload_image_button" class="button" type="button" value="' . esc_attr__('Upload Image', 'cocobasic-shortcode') . '" />
                                <br /><span class="image-upload-desc">' . esc_html($field['desc']) . '</span>                                                                    
                                <span id="small-background-image-preview" class="has-background"></span>				
				</label>';
                } elseif ($field['id'] == 'page_background_color') {
                    echo '<div id="colorPageBackgroundColor"><div></div></div>
                      <input style="display:none" type="text" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="50" /> 
                        <br /><span class="description">' . esc_html($field['desc']) . '</span>';
                } elseif ($field['id'] == 'page_contact_left_background_color') {
                    echo '<div id="colorContactLeftBackgroundColor"><div></div></div>
                      <input style="display:none" type="text" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="50" /> 
                        <br /><span class="description">' . esc_html($field['desc']) . '</span>';
                } else {
                    echo '<input type="text" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="50" /> 
						<br /><span class="description">' . esc_html($field['desc']) . '</span>';
                }
                break;
// select  
            case 'select':
                echo '<select name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="' . esc_attr($option['value']) . '">' . esc_html($option['label']) . '</option>';
                }
                echo '</select><br /><span class="description">' . esc_html($field['desc']) . '</span>';
                break;
// textarea  
            case 'textarea':
                echo '<textarea name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" cols="60" rows="4">' . wp_kses($meta, $allowed_plugin_tags) . '</textarea> 
					<br /><span class="description">' . esc_html($field['desc']) . '</span>';
                break;
        } //end switch  
        echo '</td></tr>';
    } // end foreach  
    echo '</table>'; // end table  
}

// Save the Data  
function cocobasic_save_page_custom_meta($post_id) {
    global $page_custom_meta_fields, $page_contact_custom_meta_fields, $post;
    $page_fields = $page_custom_meta_fields;

    if (!empty($post)) {
        $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);
        if ($pageTemplate == 'page-contact.php') {
            $page_fields = $page_contact_custom_meta_fields;
        }
    }

    $allowed_plugin_tags = cocobasic_allowed_plugin_html();
// verify nonce  
    if (isset($_POST['custom_meta_box_nonce'])) {
        if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }
    }
// check autosave  
// Stop WP from clearing custom fields on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
// Prevent quick edit from clearing custom fields
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
// check permissions  
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
// loop through fields and save the data  
    foreach ($page_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = null;
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }
        if ($new && $new != $old) {
            $new = wp_kses($new, $allowed_plugin_tags);
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach  
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Return Portfolio category Filter values">
function cocobasic_drop_cats_filter() {
    $portfolio_filter_content = '';
    $args = array('taxonomy' => 'portfolio-category', 'orderby' => 'slug');
    foreach (get_categories($args) as $category) {
        $portfolio_filter_content .= '<div class="button" data-filter=".' . $category->slug . '">' . $category->name . '</div>';
    }

    return $portfolio_filter_content;
}

// </editor-fold> 
// <editor-fold defaultstate="collapsed" desc="Return Slug of Portfolio category">
function cocobasic_drop_cats_slug($cat) {
    $category = '';
    $term_list = wp_get_post_terms($cat, 'portfolio-category', array("fields" => "slugs"));
    foreach ($term_list as $c) {
        $category .= $c . ' ';
    }
    $category .= ';';
    $category = explode(' ;', $category);
    if ($category[0] == ';') {
        $category[0] = '';
    }
    return $category[0];
}

// </editor-fold> 
// <editor-fold defaultstate="collapsed" desc="Return Name of Portfolio category">
function cocobasic_drop_cats_name($cat) {
    $category = '';
    $term_list = wp_get_post_terms($cat, 'portfolio-category', array("fields" => "names", 'orderby' => 'slug'));
    foreach ($term_list as $c) {
        $category .= $c . ', ';
    }
    $category .= ';';
    $category = explode(', ;', $category);
    if ($category[0] == ';') {
        $category[0] = '';
    }
    return $category[0];
}

// </editor-fold> 
// <editor-fold defaultstate="collapsed" desc="Browser Body Class">
function cocobasic_browserBodyClass($classes) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
    if ($is_lynx)
        $classes[] = 'lynx';
    elseif ($is_gecko)
        $classes[] = 'gecko';
    elseif ($is_opera)
        $classes[] = 'opera';
    elseif ($is_NS4)
        $classes[] = 'ns4';
    elseif ($is_safari)
        $classes[] = 'safari';
    elseif ($is_chrome)
        $classes[] = 'chrome';
    elseif ($is_IE) {
        $classes[] = 'ie';
        if (preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
            $classes[] = 'ie' . $browser_version[1];
    } else
        $classes[] = 'unknown';
    if ($is_iphone)
        $classes[] = 'iphone';
    if (stristr($_SERVER['HTTP_USER_AGENT'], "mac")) {
        $classes[] = 'osx';
    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "linux")) {
        $classes[] = 'linux';
    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "windows")) {
        $classes[] = 'windows';
    }
    return $classes;
}

// </editor-fold> 
// <editor-fold defaultstate="collapsed" desc="Shortcodes p-tag fix">
function cocobasic_the_content_filter($content) {
    // array of custom shortcodes requiring the fix 
    $block = join("|", array("col", "image_slider", "image_slide", "v_skills", "v_skill", "social_holder", "social", "member", "portfolio", "info", "service", "big_number", "big_text", "pricing", "text_slider", "text_slide", "full_width", "p_full_width"));
    // opening tag
    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);

    // closing tag
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep);
    return $rep;
}

//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="Allowed HTML Tags">
function cocobasic_allowed_plugin_html() {
    $allowed_tags = array(
        'a' => array(
            'class' => array(),
            'href' => array(),
            'rel' => array(),
            'title' => array(),
            'target' => array(),
            'data-rel' => array(),
        ),
        'abbr' => array(
            'title' => array(),
        ),
        'b' => array(),
        'blockquote' => array(
            'cite' => array(),
        ),
        'cite' => array(
            'title' => array(),
        ),
        'code' => array(),
        'del' => array(
            'datetime' => array(),
            'title' => array(),
        ),
        'dd' => array(),
        'div' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'br' => array(),
        'dl' => array(),
        'dt' => array(),
        'em' => array(),
        'h1' => array(),
        'h2' => array(),
        'h3' => array(),
        'h4' => array(),
        'h5' => array(),
        'h6' => array(),
        'i' => array(),
        'img' => array(
            'alt' => array(),
            'class' => array(),
            'height' => array(),
            'src' => array(),
            'width' => array(),
        ),
        'li' => array(
            'class' => array(),
        ),
        'ol' => array(
            'class' => array(),
        ),
        'p' => array(
            'class' => array(),
        ),
        'q' => array(
            'cite' => array(),
            'title' => array(),
        ),
        'span' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'strike' => array(),
        'strong' => array(),
        'ul' => array(
            'class' => array(),
        ),
        'iframe' => array(
            'class' => array(),
            'src' => array(),
            'allowfullscreen' => array(),
            'width' => array(),
            'height' => array(),
        )
    );

    return $allowed_tags;
}

//</editor-fold>
?>