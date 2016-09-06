<?php get_header(); ?>

  <ul class="press-type-filter">
    <?php
      $filters = get_terms('presstype', 'orderby=count&hide_empty=0');
      foreach ($filters as $filter) :
        echo '<li><a href="'. get_term_link($filter->term_id) .'" data-filter="'. $filter->slug .'" class="button">'. $filter->name .'</a></li>';
      endforeach;
    ?>
  </ul>

  <?php
    while (have_posts()) : the_post();
      get_template_part('partials/content', 'press');
    endwhile;
  ?>

  <?php the_posts_pagination(); ?>

<?php get_footer(); ?>
