Michigan Simple Framework
=========================

## Installation
1. Download files and place in your project root web directory within a folder named `framework`.
2. copy or add the contents of the file `framework/htaccess` to your project root web directory and rename as `.htaccess`

## Create Theme
In your project web directory create a folder named `theme` in there you can have any one of the following files.

**config.php**
Here you can add any global php code.  This can be enabling database support (see `framework/bootstrap.php`) or disabling the global `framework/theme` and all of its assets from being loaded (if you do this styles and scripts will not be added into the page unless you replicate that code form the `framework/theme/theme.tpl` file).

**theme.tpl**
Here you can create your own theme wrapper (do not duplicate the html in `framework/theme/theme.tpl`).  This is where you can place your own global header/footer/navigation for your site.  Place the tag `<!--{CONTENTS}-->` where you want the page contents to be placed.

**scripts/\*.js**
All files in this directory will automatically be included into the html.

**styles/\*.css**
All files in this directory will automatically be included into the html. 
*If the filename ends with `_print.css` it will have the `media="print"` attribute added to the link element.*

*By default the framework uses a 12 column grid.  If you need a 16 column grid add to your `theme/config.php` file the following line of code:*
`Template::var('siteGrid', 16);`

*If you need to add one or more classes to the body element you can do so by with the following code:*
`Template::var('siteBodyClass', 'myclass1 myclass2');`

## Create Page
Below the usage of `{SLUG}` will be the name of the controller file without the extension.

The controller file is determined based on the url requested and the search order for it is as follows:
URL: /foo/bar/

1. /foo/bar.php
2. /foo/bar/index.php

A Page consists of 2 files:

1. **Controller:** {SLUG}.php
2. **Template:** presentation/{SLUG}.tpl

You can optionally add css and js files using the following paths relative the page controllres directory:
styles/{SLUG}.css
scripts/{SLUG}.js
