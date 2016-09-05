<?php get_header(); ?>

  <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
      <h1><?php the_title(); ?></h1>
      <?php
        if (has_post_thumbnail()) :
          $image_id = get_post_thumbnail_id($post->ID);
          $img_src = wp_get_attachment_image_url($image_id, 'large');
          $img_srcset = wp_get_attachment_image_srcset($image_id, 'large');
          $img_sizes = wp_get_attachment_image_sizes($image_id, 'large');
          $img_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
          $img_title = get_the_title($image_id);
          echo '<img src="'. esc_url($img_src) .'" srcset="'. esc_attr($img_srcset) .'" sizes="'. esc_attr($img_sizes) .'" alt="'. esc_attr($img_alt) .'" title="'. esc_attr($img_title) .'">';
        endif;
      ?>
      <?php the_content(); ?>
    </article>
  <?php endwhile; ?>

<?php get_footer(); ?>
