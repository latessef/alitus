<?php get_header(); ?>
<div id="content" class="site-content">    
    <?php
    global $post;
    $allowed_html_array = blanka_allowed_html();
    if ((get_theme_mod('blanka_blog_title') != '') || (get_theme_mod('blanka_blog_description') != '')):
        echo '<div class="page-content-wrapper center-relative section-content block content-1070">';
        if ((get_theme_mod('blanka_blog_title') != '')):
            echo '<h1 class="entry-title">';
            echo wp_kses(__(get_theme_mod('blanka_blog_title') ? get_theme_mod('blanka_blog_title') : 'BLOG', 'blanka-wp'), $allowed_html_array);
            echo '</h1>';
        endif;
        if ((get_theme_mod('blanka_blog_description') != '')):
            echo '<p class="page-description">';
            echo do_shortcode(wp_kses(__(get_theme_mod('blanka_blog_description') ? get_theme_mod('blanka_blog_description') : 'Blog description', 'blanka-wp'), $allowed_html_array));
            echo '</p>';
        endif;
        echo '</div>';
    endif;

    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
    query_posts('post_type=post&paged=' . $page);

    if (have_posts()) :
        echo '<div class="blog-holder block center-relative">';
        require get_parent_theme_file_path('loop-index.php');
        echo '</div><div class="clear"></div><div class="block center-relative center-text more-posts-index-holder"><a target="_self" class="more-posts">' . esc_html__('Load More', 'blanka-wp') . '</a><a class="more-posts-loading">' . esc_html__('Load More', 'blanka-wp') . '</a><a class="no-more-posts">' . esc_html__('Load More', 'blanka-wp') . '</a></div>';
    endif;
    echo '<div class="clear"></div>';
    ?>   
</div>

<?php get_footer(); ?>