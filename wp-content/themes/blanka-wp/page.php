<?php get_header(); ?>

<div id="content" class="site-content">
    <?php
    $allowed_html_array = blanka_allowed_html();
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>

            <div <?php post_class('section'); ?>>   
                <div class="page-content-wrapper center-relative section-content block content-1070">  
                    <?php
                    if (get_post_meta($post->ID, "page_show_title", true) != 'no'):
                        if (get_post_meta($post->ID, "page_custom_title", true) != ''):
                            echo '<h1 class="entry-title">' . wp_kses(get_post_meta($post->ID, "page_custom_title", true), $allowed_html_array) . '</h1>';
                        else:
                            the_title('<h1 class="entry-title">', '</h1>');
                        endif;
                    endif;

                    if (get_post_meta($post->ID, "page_description", true) != ''):
                        echo '<p class="page-description">' . do_shortcode(wp_kses(get_post_meta($post->ID, "page_description", true), $allowed_html_array)) . '</p>';
                    endif;

                    the_content();
                    if (get_post_meta($post->ID, "page_scroll", true) == 'yes'):
                        echo '<div class = "icon-scroll"></div>';
                    endif;
                    ?>
                </div>
            </div> 
            <?php
            comments_template();
        endwhile;
    endif;
    ?>    
</div>

<?php get_footer(); ?>