<?php get_header(); ?>

  <ul class="press-filter">
    <?php
      $filters = get_terms('presstype', 'orderby=count&hide_empty=0');
      foreach ($filters as $filter) :
        if ($wp_query->query['presstype'] == $filter->slug) :
          echo '<li class="active">';
        else :
          echo '<li>';
        endif;
        echo '<a href="'. get_term_link($filter->term_id) .'" data-filter="'. $filter->slug .'" class="button">'. $filter->name .'</a></li>';
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
