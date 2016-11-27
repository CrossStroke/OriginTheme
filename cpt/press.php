<?php

  function origin_press_init() {
    $labels = array(
      'name'               => 'Press',
      'singular_name'      => 'Press Item',
      'menu_name'          => 'Press',
      'name_admin_bar'     => 'Press Item',
      'add_new'            => 'Add New',
      'add_new_item'       => 'Add New Press Item',
      'new_item'           => 'New Press Item',
      'edit_item'          => 'Edit Press Item',
      'view_item'          => 'View Press Item',
      'all_items'          => 'All Press Items',
      'search_items'       => 'Search Press Items',
      'parent_item_colon'  => 'Parent Press Items:',
      'not_found'          => 'No press found.',
      'not_found_in_trash' => 'No press found in Trash.'
    );

    $args = array(
      'labels'             => $labels,
      'menu_icon'          => 'dashicons-media-document',
      'description'        => 'Press Items',
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array('slug' => 'press', 'with_front' => false),
      'capability_type'    => 'page',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'supports'           => array('title', 'editor', 'thumbnail', 'page-attributes')
    );

    register_post_type('press', $args);


    // Add new taxonomy, make it hierarchical (like categories)
    $tax_labels = array(
      'name'              => 'Types',
      'singular_name'     => 'Type',
      'search_items'      => 'Search Types',
      'all_items'         => 'All Types',
      'parent_item'       => 'Parent Type',
      'parent_item_colon' => 'Parent Type:',
      'edit_item'         => 'Edit Type',
      'update_item'       => 'Update Type',
      'add_new_item'      => 'Add New Type',
      'new_item_name'     => 'New Type Name',
      'menu_name'         => 'Types',
    );

    $tax_args = array(
      'hierarchical'      => true,
      'labels'            => $tax_labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array('slug' => 'press_type'),
    );

    register_taxonomy('presstype', array('press'), $tax_args);

  }

  add_action('init', 'origin_press_init');


  // Set the order and number of items in the Press Archive
  function origin_press_archive_posts_order($query) {
    if (!$query->is_admin && $query->get('post_type') == 'press') :
      $query->set('orderby', 'menu_order');
      $query->set('order', 'ASC');
      $query->set('posts_per_page', 4);
    endif;
    return $query;
  }
  add_filter('pre_get_posts', 'origin_press_archive_posts_order');


  // Set the order and number of items in the Press Type taxonomy archive
  function origin_presstype_taxonomy_posts_order($query) {
    if (!$query->is_admin && ($query->is_tax() && isset($query->query['presstype']))) :
      $query->set('orderby', 'menu_order');
      $query->set('order', 'ASC');
      $query->set('posts_per_page', 6);
    endif;
    return $query;
  }
  add_filter('pre_get_posts', 'origin_presstype_taxonomy_posts_order');


  // Menu Highlight for taxonomy pages
  function origin_press_current_type_nav_class($classes, $item) {
    global $wp_query;
    if ($item->object == 'press' && isset($wp_query->query['presstype'])) :
      array_push($classes, 'current-menu-item');
    endif;
    return $classes;
  }
  add_filter('nav_menu_css_class', 'origin_press_current_type_nav_class', 10, 2);
