<?php
/*
  Template Name: Contact
 */
?>

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
                            echo '<h2 class="entry-title">' . wp_kses(get_post_meta($post->ID, "page_custom_title", true), $allowed_html_array) . '</h2>';
                        else:
                            the_title('<h2 class="entry-title">', '</h2>');
                        endif;
                    endif;

                    if (get_post_meta($post->ID, "page_description", true) != ''):
                        echo '<p class="page-description">' . do_shortcode(wp_kses(get_post_meta($post->ID, "page_description", true), $allowed_html_array)) . '</p>';
                    endif;
                    ?>
                    <div class="contact-page-wrapper">                        
                        <div class="contact-page-left">
                            <?php the_content(); ?>
                        </div>                        
                        <div class="contact-page-right">                        
                            <?php
                            if (get_post_meta($post->ID, "page_contact_form", true) != ''):
                                echo do_shortcode(wp_kses(get_post_meta($post->ID, "page_contact_form", true), $allowed_html_array));
                            endif;
                            ?>
                        </div>
                        <div class="clear"></div>
                    </div>  
                </div>
            </div> 
            <?php
            comments_template();
        endwhile;
    endif;
    ?>    
</div>

<?php get_footer(); ?>