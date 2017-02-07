  <footer class="site-footer">

    <?php
      $site_twitter_url = get_field('site_twitter_url', 'option');
      $site_facebook_url = get_field('site_facebook_url', 'option');
      $site_instagram_url = get_field('site_instagram_url', 'option');

      if ($site_twitter_url || $site_facebook_url || $site_instagram_url) :
        echo '<ul class="site-footer-social">';

        if ($site_twitter_url) :
          echo '<li><a href="'. $site_twitter_url .'">Follow on Twitter</a></li>';
        endif;

        if ($site_facebook_url) :
          echo '<li><a href="'. $site_facebook_url .'">Like on Facebook</a></li>';
        endif;

        if ($site_instagram_url) :
          echo '<li><a href="'. $site_instagram_url .'">Follow on Instagram</a></li>';
        endif;

        echo '</ul>';
      endif;
    ?>

    <small>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></small>
  </footer>

  <?php wp_footer(); ?>
  <span class="hidden"><?php include "dist/svg-symbols.svg"; ?></span>

  <!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->

</body>
</html>
