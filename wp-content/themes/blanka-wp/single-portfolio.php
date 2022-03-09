<?php get_header(); ?>

<div id="content" class="site-content">
    <?php
    $allowed_html_array = blanka_allowed_html();
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>		
            <div <?php post_class('section portfolio-item-wrapper'); ?>> 
                <div class="center-relative content-960 portfolio-item-content"> 
                    <?php if (get_post_meta($post->ID, "portfolio_header_content", true) != ''): ?>
                        <div class="top-content">
                            <?php echo do_shortcode(wp_kses(get_post_meta($post->ID, "portfolio_header_content", true), $allowed_html_array)); ?>
                        </div>
                    <?php endif; ?> 
                    <div class="entry-content">
                        <div class="content-wrapper relative">                          
                            <?php the_content(); ?>                            
                        </div>
                    </div>
                    <div class="clear"></div>

                    <?php if (get_theme_mod('blanka_show_nav_portfolio') === 'yes'): ?>
                        <div class="nav-links">                
                            <div class="content-570 center-relative">
                                <?php
                                $prev_post = get_previous_post();
                                if (is_a($prev_post, 'WP_Post')):
                                    ?>
                                    <div class="nav-previous">                                                                          
                                        <?php previous_post_link('%link'); ?>
                                        <div class="clear"></div>                            
                                    </div>
                                <?php endif; ?>
                                <?php
                                $next_post = get_next_post();
                                if (is_a($next_post, 'WP_Post')):
                                    ?>                
                                    <div class="nav-next">                                                  
                                        <?php next_post_link('%link'); ?>                     
                                        <div class="clear"></div>                            
                                    </div>
                                <?php endif; ?>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <?php
                    endif;
                    comments_template();
                endwhile;
                ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php get_footer(); ?>