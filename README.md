# Origin Theme
A starter theme, specifically for one-off bespoke themes.

More specifically, this is _my_ starter theme. It is how I start all my personal and client projects. It might not be your cup of tea, and that's just fine 🙂 The Fork button is close by.

It is geared towards one-off themes where customisation options are something the client doesn't need or, isn't something they should even have access to. It also removes comments, as i'm yet to build a client site with them.


## Features

* Disabled customiser
* Disabled comments
* Disabled admin bar (on the front-end)
* Simplified Editor buttons
* Changes 'Posts' to 'News'
* Press CPT with custom taxonomy and relates templates
* Gulp for running tasks
  * Scss
  * Autoprefixer
  * Merge JS files into two `.js` file & minify (`venfor.js` & `app.js`)
  * Merge SVG files into one to use as symbols
  * LiveReload
  * Create zip file suitable for uploading/sharing


## Gulp Tasks

Task | Description
--- | ---
`gulp` | Run watch tasks and re-build files as they change
`gulp build` | Build files with no watchers
`gulp release` | Bundle all required files together and create zip file in this themes directory


## Recommended Plugins

I prefer to keep plugins to a minimum, but there are always exceptions.

* [Advanced Custom Fields](https://www.advancedcustomfields.com/) – Because 99.99% of sites I build need some form of custom fields, and no way in hell am I writing those manually.
* [Post Type Archive Link](https://wordpress.org/plugins/post-type-archive-links/) – Allows you to add _real_ CPT archive links to menus, without needing to add custom links. No extra crap is added.
* [Simple Page Ordering](https://en-gb.wordpress.org/plugins/simple-page-ordering/) – Adds the ability to drag & drop reorder pages from the usual Posts admin pages, no extra UI is added


## #protips

* Add the class `debug_mq` to `body_class()` to show the current breakpoint
  * If your local domain ends with `.dev`, that'll work automatically
