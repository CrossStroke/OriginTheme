# Origin Theme
A starter theme, specifically for one-off bespoke themes.

More specifically, this is _my_ starter theme. It is how I start all my personal and client projects. It might not be your cup of tea, and that's just fine 🙂 The Fork button is close by.

It is geared towards one-off themes where customisation options are something the client doesn't need or, isn't something they should even have access to. It also removes comments, as i'm yet to build a client site with them.

## Features

* Disabled customiser
* Disabled comments
* Disabled admin bar (on the front-end)
* Changes 'Posts' to 'News'
* Gulp for running tasks
  * Scss
  * Autoprefixer
  * Merge JS files into one `.js` file & minify
  * Merge SVG files into one to use as symbols
  * Create zip file suitable for uploading/sharing
* LiveReload


## Gulp Tasks

Task | Description
--- | ---
`gulp` | Run watch tasks and re-build files as they change
`gulp build` | Build files with no watchers
`gulp release` | Bundle all required files together and create zip file in this themes directory

## #protips

* Add the class `debug_mq` to `body_class()` to show the current breakpoint