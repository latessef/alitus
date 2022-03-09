<?php
/*
  Template Name: OnePage
 */
?>

<?php get_header(); ?>

<?php the_content(); ?>

<?php get_footer(); ?>

<script>

jQuery(document).ready(function(){
   jQuery('#menu-item-606').click(function() {
     jQuery(this).addClass("active"); 
   });
});


</script>