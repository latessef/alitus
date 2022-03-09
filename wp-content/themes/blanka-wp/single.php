<?php
get_header();
?>

<div id="content" class="site-content center-relative">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>		

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if (has_post_thumbnail()): ?>
                    <div class="single-post-featured-image content-1070 center-relative">
                        <?php the_post_thumbnail(); ?>
                    </div>                        
                <?php endif; ?>
                <div class="entry-header content-740 center-relative">
                    <h1 class="entry-title"><?php the_title(); ?></h1>               
                    <div class="entry-info">
                        <div class="entry-date published"><?php echo get_the_date('F Y'); ?></div>
                        <div class="cat-links">
                            <ul>
                                <?php
                                foreach ((get_the_category()) as $category) {
                                    echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
                                }
                                ?>
                            </ul>
                        </div>                                                                                                     
                        <div class="author-nickname">
                            <?php the_author_posts_link(); ?>
                        </div>   
                    </div>
                </div>
                <div class="entry-content">
                    <div class="content-740 center-relative">                            
                        <?php
                        the_content();

                        $defaults = array(
                            'before' => '<p class="wp-link-pages top-50"><span>' . esc_html__('Pages:', 'blanka-wp') . '</span>',
                            'after' => '</p>'
                        );
                        wp_link_pages($defaults);

                        if (has_tag()):
                            ?>	
                            <div class="tags-holder">
                                <?php the_tags('', ''); ?>
                            </div>                              
                            <?php
                        endif;
                        ?>
                    </div>
                </div>                   
                <div class="clear"></div>
            </article>
            <div class="nav-links">                
                <div class="content-740 center-relative">
                    <?php
                    $prev_post = get_previous_post();
                    if (is_a($prev_post, 'WP_Post')):
                        ?>
                        <div class="nav-previous">                                                                          
                            <?php previous_post_link('%link'); ?>
                            <div class="clear"></div>
                            <div class="cat-links">
                                <ul>
                                    <?php
                                    foreach ((get_the_category($prev_post->ID)) as $category) {
                                        echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div> 
                        </div>
                    <?php endif; ?>
                    <?php
                    $next_post = get_next_post();
                    if (is_a($next_post, 'WP_Post')):
                        ?>                
                        <div class="nav-next">                                                  
                            <?php next_post_link('%link'); ?>                     
                            <div class="clear"></div>
                            <div class="cat-links">
                                <ul>
                                    <?php
                                    foreach ((get_the_category($next_post->ID)) as $category) {
                                        echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>                             
                        </div>
                    <?php endif; ?>
                    <div class="clear"></div>
                </div>
            </div>               
            <?php
            comments_template();
        endwhile;
    endif;
    ?>    
</div>
<?php get_footer(); ?>