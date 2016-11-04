<?php

  /*****
    Show PHP errors & warnings
  *****/
  // error_reporting(E_ALL);
  // ini_set('display_errors', '1');


  function origin_add_styles_and_scripts() {
    wp_enqueue_style('app', get_template_directory_uri() . '/dist/app.min.css', array(), '1.1', 'all');
    wp_enqueue_script('app', get_template_directory_uri() . '/dist/app.min.js', array ('jquery'), 1.1, true);
  }
  add_action('wp_enqueue_scripts', 'origin_add_styles_and_scripts');


  /*****
    Require CPT's and taxonomies
  *****/
  require "cpt/press.php";


  /*****
    Add support for thumbnails and menus
  *****/
  add_theme_support('post-thumbnails');
  add_theme_support('menus');


  /*****
    Add custom image sizes
  *****/
  add_image_size('larger', 1400, 1400);
  add_image_size('huge', 2000, 2000);
  add_image_size('massive', 2600, 2600);


  /****
    Echo or return the SVG icon with correct viewBox
  *****/
  function return_svg($icon) {
    switch ($icon) {
      case "fb":
        $view = "0 0 15 32";
        break;

      case "tw":
        $view = "0 0 31 27";
        break;

      default:
        $view = "0 0 0 0";
    }

    $str = '<svg data-icon="' . $icon . '" viewBox="' . $view . '"><use xlink:href="#' . $icon . '"></use></svg>';
    return $str;
  }

  function svg($icon) {
    echo return_svg($icon);
  }


  /*****
    Init ACF options pages, if plugin is installed
  *****/
  if (function_exists('acf_add_options_page')):
    acf_add_options_page(array(
      'page_title' => 'Global Settings',
      'menu_title' => 'Global',
      'redirect' => false
    ));

    acf_add_options_page(array(
      'page_title' => 'Social Settings',
      'menu_title' => 'Social',
      'redirect' => false
    ));
  endif;

  // And now include a bunch of stuff that hides admin panels, and some useful functions
  require "functions/origin.php";
