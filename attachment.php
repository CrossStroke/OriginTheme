<?php

  // Disable file attachment pages, redirect to parent post
  wp_redirect(get_permalink($post->post_parent));
