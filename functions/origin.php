<?php

  /*****
    Hide Admin Bar in WP >= 3.1
  *****/
  add_filter('show_admin_bar', '__return_false');


  /*****
    Disable Theme Updates
  *****/
  remove_action('load-update-core.php', 'wp_update_themes');
  add_filter('pre_site_transient_update_themes', create_function('$a', "return null;"));


  /*****
    Hide all dashboard stuff
  *****/
  // Hide most of the dashboard meta boxes
  function mpp_remove_dashboard_meta() {
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');//since 3.8
  }
  add_action('admin_init', 'mpp_remove_dashboard_meta');

  // Hide 'Welcome' panel, and 'Screen Options' & 'Help' tabs
  add_action('wp_dashboard_setup', 'remove_welcome_panel');
  function remove_welcome_panel() {
    global $wp_filter;
    unset($wp_filter['welcome_panel']);
  }
  add_action('admin_head', 'mytheme_remove_help_tabs');
  function mytheme_remove_help_tabs() {
    $screen = get_current_screen();
    $screen->remove_help_tabs();
  }

  // Add our own meta box
  add_action('wp_dashboard_setup', 'register_my_dashboard_widget');
  function register_my_dashboard_widget() {
    wp_add_dashboard_widget('my_dashboard_widget', 'Welcome', 'dashboard_widget_display');
  }
  function dashboard_widget_display() {
    echo 'Use the menu on the left to add content and update everything on this website.';
  }


  /*****
    Remove generator meta tag from head
  *****/
  remove_action('wp_head', 'wp_generator');


  /*****
    Rename 'Post' to 'News'
  *****/
  function origin_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0]                 = 'News';
    $submenu['edit.php'][5][0]  = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    $submenu['edit.php'][16][0] = 'News Tags';
    echo '';
  }
  function origin_change_post_object() {
    global $wp_post_types;
    $labels =& $wp_post_types['post']->labels;
    $labels->name               = 'News';
    $labels->singular_name      = 'News';
    $labels->add_new            = 'Add News';
    $labels->add_new_item       = 'Add News';
    $labels->edit_item          = 'Edit News';
    $labels->new_item           = 'News';
    $labels->view_item          = 'View News';
    $labels->search_items       = 'Search News';
    $labels->not_found          = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items          = 'All News';
    $labels->menu_name          = 'News';
    $labels->name_admin_bar     = 'News';
  }

  add_action('admin_menu', 'origin_change_post_label');
  add_action('init', 'origin_change_post_object');


  /*****
    Remove customizer from menu
    http://stackoverflow.com/a/26873392
  *****/
  function origin_remove_customize_menu() {
    $customize_url_arr = array();
    $customize_url_arr[] = 'customize.php'; // 3.x
    $customize_url = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'customize.php' );
    $customize_url_arr[] = $customize_url; // 4.0 & 4.1
    if (current_theme_supports('custom-header') && current_user_can('customize')) {
      $customize_url_arr[] = add_query_arg( 'autofocus[control]', 'header_image', $customize_url ); // 4.1
      $customize_url_arr[] = 'custom-header'; // 4.0
    }
    if (current_theme_supports('custom-background') && current_user_can('customize')) {
      $customize_url_arr[] = add_query_arg( 'autofocus[control]', 'background_image', $customize_url ); // 4.1
      $customize_url_arr[] = 'custom-background'; // 4.0
    }
    foreach ($customize_url_arr as $customize_url) {
      remove_submenu_page( 'themes.php', $customize_url );
    }
  }
  add_action( 'admin_menu', 'origin_remove_customize_menu', 999 );


  /*****
    Remove comments
    http://wordpress.stackexchange.com/a/17936
  *****/
  // Removes from admin menu
  function origin_remove_comments_admin_link() {
    remove_menu_page('edit-comments.php');
  }
  add_action('admin_menu', 'origin_remove_comments_admin_link');

  // Removes from post and pages
  function origin_remove_comment_post_types() {
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
  }
  add_action('init', 'origin_remove_comment_post_types', 100);

  // Removes from admin bar
  function origin_remove_comments_admin_bar_link() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
  }
  add_action('wp_before_admin_bar_render', 'origin_remove_comments_admin_bar_link');


  /*****
    Disable emoji
    http://wordpress.stackexchange.com/a/185578
  *****/
  function disable_wp_emojicons() {
    // all actions related to emojis
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    // filter to remove TinyMCE emojis
    add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
  }

  add_action('init', 'disable_wp_emojicons');
  function disable_emojicons_tinymce($plugins) {
    if (is_array($plugins)) {
      return array_diff($plugins, array('wpemoji'));
    } else {
      return array();
    }
  }


  /*****
    Stop the 'Posts' archive being an active menu item with in a CPT sinlge item
    https://wordpress.org/support/topic/blog-tab-gets-highlighted-in-nav-menu-for-custom-post-types#post-2711621
  *****/
  function origin_disable_posts_archive_nav_highlight_on_cpt_single($classes,$item,$args) {
    if (!is_singular('post') && !is_category() && !is_tag()) :
      $blog_page_id = intval(get_option('page_for_posts'));
      if ($blog_page_id != 0) :
        if ($item->object_id == $blog_page_id) :
          unset($classes[array_search('current_page_parent',$classes)]);
        endif;
      endif;
    endif;
    return $classes;
  }
  add_filter('nav_menu_css_class','origin_disable_posts_archive_nav_highlight_on_cpt_single',10,3);



  /*****
    Remove <p> tags surounding images
    https://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/#comment-150114
    ---
    Might need this http://wordpress.stackexchange.com/a/174585
  *****/
  function filter_ptags_on_images($content){
    return preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '\1', $content);
  }
  add_filter('the_content', 'filter_ptags_on_images');



  /*****
    Pluralise string
    ---
    Returns different srings based on the int given to it
    ---
    echo origin_plural($number_of_people, 'person', 'people');
  *****/
  function origin_plural( $amount, $singular = '', $plural = 's' ) {
    if ($amount === 1) {
      return $singular;
    }
    return $plural;
  }


  /*****
    Remove some editor buttons – to client should have the ability to justify text!
  *****/
  function origin_tinymce_editor_buttons($buttons) {
    return array(
      "formatselect",
      "separator",
      "bold",
      "italic",
      "underline",
      "strikethrough",
      "bullist",
      "numlist",
      "link",
      "unlink",
      "image",
      "blockquote",
      "outdent",
      "indent",
      "undo",
      "redo",
      "removeformat",
      "code"
    );
  }
  add_filter("mce_buttons", "origin_tinymce_editor_buttons", 99);


  /*****
    Remove some block styles
  *****/
  function origin_tinymce_block_formats($arr){
    $arr['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Pre=pre;Code=code';
    return $arr;
  }
  add_filter('tiny_mce_before_init', 'origin_tinymce_block_formats');


  /*****
    Utility function to essentially replace `print_r`, but more useful and *always* shown, even if no data is supplied
  *****/
  function pre($var, $maxheight = false) {
    $maxheightcss = ($maxheight) ? 'max-height: 300px;' : '';
    echo '<pre style="background: #fcffb1; color: #000; font-weight: normal; text-align: left; margin: 0; box-sizing: border-box; padding: 10px 15px; font-size: 14px; line-height: 18px; width: 100%; overflow: auto; outline: 4px solid rgb('. rand(0, 150) .','. rand(0, 150) .','. rand(0, 150) .');'. $maxheightcss .'">';
      if ($var) :
        print_r($var);
      else :
        if (is_bool($var)) :
          var_dump($var);
        else :
          echo "\n\n\t--- <b>No data received by pre() function</b> ---\n\n";
        endif;
      endif;
    echo '</pre>';
  }
