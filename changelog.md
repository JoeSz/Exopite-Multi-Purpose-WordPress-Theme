# Changelog

= 20170921 - Sep 21 2017
* **UPDATE**: Update to Bootstrap 4.0.0 beta

= 20170825 - Aug 25 2017
* **ENHANCEMENT**: Possibility to completely deactivate REST API with 405 error code for WordPress 4.7+.
* **ENHANCEMENT**: Make Google Analytics option filed as ACE Editor.
               (Regular textarea had modify some chars, create JavaScript errors)

= 20170727 - Jul 27 2017
* **FIXED**: Check exopite-thumbnail-size-crop exist before use it in media.php

= 20170722 - Jul 22 2017
* **ADDED**: menu full width option
* **ADDED**: hooks to:
             - change left side content of logo top
             - change right side content of logo top
* **ENHANCEMENT**: prefix variables in header, menu, logo-top, hero_header

= 20170715 - Jul 15 2017
* **ADDED**: option in theme options and in meta options to limit revisions

= 20170709 - Jul 09 2017
* **ADDED**: display releated post and author shortcode

= 20170708 - Jul 08 2017
* **ENHANCEMENT**: releated posts can be **ADDED** on custom post types too (via filters)
* **ENHANCEMENT**: display the author can be controlled in posts options meta box
* **FIXED**: meta box color in posts

= 20170705 - Jul 05 2017
* **ENHANCEMENT**: add site title to SEO meta in header
* **ADDED**: meta options of noindex, nofollow and description

= 20170703 - Jul 03 2017
* **ADDED**: "logo-in-menu" class to logo container div, if logo in menu
* **FIXED**: wrong selector in css for logo width
* **FIXED**: create logo function name if logo is in menu middle

= 20170702 - Jul 02 2017
* **ADDED**: skip/scroll to content in Hero Header with animation
* **ENHANCEMENT**: breadcrumbs display all parent page and all parent categories for posts/post_types

= 20170625 - Jun 25 2017
* **ADDED**: option to disable desktop logo if logo is in top
         This is useful if user has a hero header and **FIXED** menu on top, but the logo is displayed in hero header
* **ADDED**: hooks to:
             - change logo anchor link url
             - chenge hamburger icon
             - change mobile menu slug
             - change menu search icon

= 20170621 - Jun 21 2017
* **ENHANCEMENT**: WPML ready (see: https://wpml.org/theme/exopite/), many thanks for the WPML team!
* **ADDED**: wpml-config.xml for WPML compatibility

= 20170618 - Jun 18 2017
* **ADDED**: color for link hover
* **ADDED**: underline for link and link hover in content

= 20170613 - Jun 13 2017
* **FIXED**: remove editor and admin JavaScript and style for category sticky plugin.
* **FIXED**: sidebar checking for blog and archives.
* **FIXED**: check wp.media in JavaScript and only load when need it.
* **FIXED**: category_name and tags in archive query by slug not by name.

= 20170611 - Jun 11 2017
* **ENHANCEMENT**: redirect to "Install Required Plugins" after theme activated.
* **ENHANCEMENT**: refresh "Install Required Plugins" page after plugin installed (to show up theme options menu),
               and redirect to theme options after all plugins are installed.
* **FIXED**: definie some option variable, to prevent error on theme actiovation before the exopite-core plugin is activated.

= 20170606 - Jun 6 2017
* **ADDED**: desktop logo with
* **ADDED**: mobile logo width and padding top/bottom

= 20170601 - Jun 1 2017
* **ENHANCEMENT**: load framework styles and scripts only on required pages. (options page, post, page and for metabox: custom post type pages)

= 20170531 - May 31 2017
* **ENHANCEMENT**: add "slug" to menu item class

= 20170529 - May 29 2017
* **ADDED**: option to display/hide WooCommerce cart in menu
* **ENHANCEMENT**: WooCommerce cart and content (via dropdown) in menu
* **ENHANCEMENT**: WooCommerce AJAX remove items from cart in menu and in widget

= 20170524 - May 24 2017
* **ADDED**: plugin management (on WooCommerce add css and regenerate/combine css and js files, on SiteOrigin Page Builder add support for section post type)
* **ENHANCEMENT**: code refactor (move maintenance and update function to the separate file)

= 20170523 - May 23 2017
* **ADDED**: option to not minify certain js files
* **ENHANCEMENT**: WooCommerce sidebar
* **ENHANCEMENT**: stick Anything: Check more often closer to top, reduce problem if scroll to top is too fast

= 20170521 - May 21 2017
* **ADDED**: support for WooCommerce (styles and functions)
* **ADDED**: style for Contact From 7

= 20170516 - May 16 2017
* **ADDED**: search in options
* **ADDED**: maintenence mode

= 20170514 - May 14 2017
* **ADDED**: hooks.txt to display available hooks
* **ADDED**: Use a "section" post type for "preheader and footer as page"
* **ADDED**: SiteOrigin Page Builder to "section" post type (if SiteOrigin is instelled before theme is activated)
* **ENHANCEMENT**: Upgrade license to GPL v3
* **ADDED** new media sizes name and display them in media library too
* **FIXED**: mobile menu floating even if it is set to off

= 20170508 - May 08 2017
* **ADDED**: option to disable comments on WordPress media attachments
* **ADDED**: paddign top and botton for boxed layout
* **FIXED**: content background-size cover

= 20170507 - May 07 2017
* **ADDED**: options to add/remove emojicons (for speed, most people do not need emojicons)
* **ADDED**: options to enable/disable dekstop menu search
* **ADDED**: filters to header (logo, menu ect...), footer
* **FIXED**: google font loading in https protocol

= 20170417 - Arp 16 2017
* **ENHANCEMENT**: version based on date
* **FIXED**: some minor PHP warnings

= 1.0.26 - Arp 2 2017
* **ADDED**: hero header height meta settings for page and post options
* **ADDED**: better mobile/tablet detection and post type and post slug to body classes
* **FIXED**: some minor JS errors

= 1.0.25 - Mar 31 2017
* **ADDED**: overlay to Hero Header .mp4 video
* **ADDED**: pause Hero Header HTML5 video if not visible

= 1.0.24 - Mar 30 2017
* **ADDED**: overlay to Hero Header image
* **ADDED**: archive tempalte compatibility to [exopite-loop] shortcode
* **ADDED**: option to display blog page content top of the loop
* **ADDED**: option for minifying HTML
* **FIXED**: category sticky display first
* **FIXED**: Some minor fix

= 1.0.23 - Mar 19 2017
* **ADDED**: mobile menu break point to options
* **ENHANCEMENT**: mobile menu: Disable scroll (also in iOS) if menu is **FIXED** and opened and
do not fix it if it is opened before **FIXED**.

= 1.0.22 - Mar 16 2017
* **ADDED**: schema.org itemprops
* **ADDED**: HTML minifying

= 1.0.21 - Mar 13 2017
* **ADDED**: JavaSscript combine and minify
* **ADDED**: Integrate with theme and plugin update checker
* **ENHANCEMENT**: move JS/CSS minify to core plugin
* **FIXED**: some HTML 5 validate issue

= 1.0.20 - Mar 5 2017
* **FIXED**: set page without sidebar default
* **ENHANCEMENT**: Automatic script and style versioning for local css and js files based on file time.
https://www.doitwithwp.com/enqueue-scripts-styles-automatic-versioning/

= 1.0.19 - Feb 26 2017
* **ADDED**: before and after hook to desktop menu
* **ADDED**: filter for mobile and desktop menu wrap
* **ADDED**: options slide up animation for mobile footer
* **ADDED**: custom user avatar

= 1.0.18 - Feb 25 2017
* **ADDED**: animation to skip to content. Also calculate **FIXED** header and nav height.
* **ENHANCEMENT**: refactor 404 and search page
remove sidebar from 404 and search
adding hooks to suggestions and for 404: custom search based on not found url

= 1.0.17 - Feb 19 2017 =
* **FIXED**: various bugs
* **ENHANCEMENT**: refactor code
* **ADDED**: comments

= 1.0.16 - Feb 15 2017 =
* **ADDED**: sidebar id as class for sidebar (useful with custom sidebars)
* **ADDED**: last modifidied to post meta
* **ENHANCEMENT**: refactor options

= 1.0.15 - Feb 10 2017 =
* **ADDED**: menu left and/or right widget if logo on top
* **ADDED**: option logo on top inside header
* **ADDED**: page option: Content above menu and full or content width

= 1.0.14 - Feb 02 2017 =
* **ADDED**: option for use custom page to display archive

= 1.0.13 - Jan 25 2017
* **ENHANCEMENT**: move theme options (CodeStar Framework) and some core PHP and JavaScript in a plugin.
Possibility for other plugins to use it.

= 1.0.12 - Jan 20 2017
* **ADDED**: page or widget option to preheader

= 1.0.11 - Jan 14 2017
* **ADDED**: ACE Editor field to options

= 1.0.10 - Jan 10 2017
* **ADDED**: versioning
* **ENHANCEMENT**: use custom query instead of main query, for DRY. (use the same code in tempalte and shortcode too)
The idea is to give the user full control over blog and archive pages. A lots of customers want
to customize those pages.
* **FIXED**: archive and search (using custom queries)

= 1.0 - May 12 2015 =
* Initial release


