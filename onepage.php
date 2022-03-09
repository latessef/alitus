<?php
/*
  Template Name: OnePage
 */
?>

<?php get_header(); ?>
<div id="content" class="site-content center-relative">
    <?php
    $args = array('post_type' => 'page', 'posts_per_page' => '-1', 'orderby' => 'menu_order', 'order' => 'ASC', 'meta_query' => array(array('key' => 'page_structure', 'value' => '2', 'compare' => '=')));
    $loop = new WP_Query($args);
    $allowed_html_array = blanka_allowed_html();
    if ($loop->have_posts()) :
        while ($loop->have_posts()) : $loop->the_post();
            $slug = $post->post_name;
            $curentPostID = $post->ID;
            ?>
            <div id="<?php echo esc_attr($slug); ?>" <?php post_class('section'); ?>>   
                <div class="block content-1070 center-relative section-content">  
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

                    if (get_page_template_slug($curentPostID) !== 'page-contact.php'): //If is Default Page

                        the_content();
                        if (get_post_meta($post->ID, "page_scroll", true) == 'yes'):
                            echo '<div class = "icon-scroll"></div>';
                        endif;

                    else: // If is Contact Page
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
                    <?php endif; ?>
                </div>
            </div>  
            <?php
        endwhile;
    endif;
    wp_reset_postdata();
    ?>
</div>
<?php get_footer(); ?>