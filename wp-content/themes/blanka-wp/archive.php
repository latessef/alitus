<?php get_header(); ?>
<div id="content" class="site-content">
    <div class="header-content content-1070 center-relative block archive-title">
        <h1 class="entry-title"><?php echo esc_html(blanka_archive_title($title)); ?></h1>
    </div>

    <div class="blog-holder block center-relative">
        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('relative blog-item-holder center-relative animate'); ?> >
                <?php if (has_post_thumbnail($post->ID)) : ?>                    
                    <div class="post-thumbnail">
                        <a href="<?php the_permalink($post->ID); ?>"><?php echo get_the_post_thumbnail(); ?></a>
                    </div>                            
                <?php endif; ?>
                <h4 class="entry-title"><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a></h4>
                <div class="entry-date published"><?php echo get_the_date('F Y'); ?></div>
                <div class="author vcard"><?php echo get_the_author(); ?></div>
                <?php if (function_exists('cocobasic_getPostLikeLink')): ?>
                    <div class="kudos"><?php echo cocobasic_getPostLikeLink(get_the_ID()); ?></div>	
                <?php endif; ?>
                <div class="clear"></div>     
            </article> 
            <?php
        endwhile;
        echo '<div class="pagination-holder">';
        the_posts_pagination();
        echo '</div>';
        ?>
    </div>
</div>

<?php get_footer(); ?>