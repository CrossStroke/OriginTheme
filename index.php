<?php get_header(); ?>

  <?php
    while (have_posts()) : the_post();
      get_template_part('partials/content', 'post');
    endwhile;
  ?>

  <?php the_posts_pagination(); ?>

<?php get_footer(); ?>
