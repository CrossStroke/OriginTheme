<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

  <meta name="description" content="<?php bloginfo("description"); ?>" />
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" />
  <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

  <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

  <header class="site-header">
    <a class="logo" href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a>

    <nav class="site-header-nav">
      <?php
        wp_nav_menu(array(
          'sort_column' => 'menu_order',
          'menu' => 'Header',
          'container' => '',
          'items_wrap' => '<ul>%3$s</ul>'
        ));
      ?>
    </nav>
  </header>
