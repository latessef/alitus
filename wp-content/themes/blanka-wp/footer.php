<!--Footer-->

<?php
$allowed_html_array = blanka_allowed_html();
?>

<footer class="footer">
    <div class="footer-content content-1070 center-relative">	        
        <?php if (is_active_sidebar('footer-sidebar')) : ?>
            <ul id="footer-sidebar">
                <?php dynamic_sidebar('footer-sidebar'); ?>
            </ul>
        <?php endif; ?>  
        <?php if ((get_theme_mod('blanka_footer_copyright_content') != '') || (get_theme_mod('blanka_footer_social_content') != '')): ?>
            <ul class="copyright-holder">
                <li class="copyright-footer">
                    <?php
                    if (get_theme_mod('blanka_footer_copyright_content') != ''):
                        echo wp_kses(__(get_theme_mod('blanka_footer_copyright_content') ? get_theme_mod('blanka_footer_copyright_content') : '2017 Park WordPress Theme by CocoBasic.', 'blanka-wp'), $allowed_html_array);
                    endif;
                    ?>
                </li>
                <li class="social-footer">                
                    <?php
                    if (get_theme_mod('blanka_footer_social_content') != ''):
                        echo wp_kses(__(get_theme_mod('blanka_footer_social_content') ? get_theme_mod('blanka_footer_social_content') : '<a href="#">Twitter</a><a href="#">Facebook</a><a href="#">Instagram</a><a href="#">Behance</a>', 'blanka-wp'), $allowed_html_array);
                    endif;
                    ?>
                </li>            
            </ul>
        <?php endif; ?>  
    </div>
</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>