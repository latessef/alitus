<?php
global $post;
?>
<?php while (have_posts()) : the_post(); ?>    

    <article id="post-<?php the_ID(); ?>" <?php post_class('relative blog-item-holder center-relative animate'); ?> >
        <?php if ((has_post_thumbnail($post->ID)) && (get_theme_mod('blanka_show_post_thumbnail') !== 'no') ) : ?>         
            <div class="post-thumbnail">
                <a href="<?php the_permalink($post->ID); ?>"><?php echo get_the_post_thumbnail(); ?></a>
            </div>                            
        <?php endif; ?>
        <h4 class="entry-title"><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?> <span class="arrow"></span></a></h4>
        <div class="entry-date published"><?php echo get_the_date('F Y'); ?></div>
        <div class="author vcard"><?php echo get_the_author(); ?></div>        
        <div class="clear"></div>     
    </article>   

<?php endwhile; ?>