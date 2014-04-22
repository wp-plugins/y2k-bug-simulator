=== Y2K Bug Simulator ===
Contributors: James Luberda
Tags: bugs, y2k, millenium, entertainment
Requires at least: 3.8.1
Tested up to: 3.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Y2K Bug Simulator adds filters to most core WordPress functions that report back a date, rendering 19xx in place of 20xx.

== Description ==

The Y2K Bug Simulator partially mimics one of the potential y2k failures that could (and did) affect some systems after December 31, 1999. The specific failure it mimics is one which typically occurred in systems where years were represented using two digits rather than four. Thus, in an affected system, the day after December 31, 1999 might be rendered as January 1, 1900 (in this scenario, only the last two digits of the year roll over, the first two are hard-coded as "19").

The bug that this plugin mimics was certainly not the only y2k bug, nor, arguably, a terribly significant one. It is, however, perhaps the most aesthetically interesting. The effect of this plugin on WordPress is to change 20xx dates into 19xx dates across page titles, posts, and comments, as well as archives and calendars.

Some things to note:

* The date modification occurs immediately after the plugin is installed and activated. It disappears immediately after the plugin is deactivated/uninstalled.
* The change is at the presentation layer only. This means, among other things, that all stored site content and data remain unchanged. Moreover, site navigation is not affected. If you click on a link to a post identified as being from February 14, 1914, it will bring you to the post for February 14, 2014 (but still say 1914).
* Internal date references are not affected. If you create a post/add a comment while the plugin is active, that content will not be stored with the modified date, but with the actual date, and will show that date when the plugin is deactivated/uninstalled.
* Any plugins/templates/other content that do not utilize WordPress core functions for date presentation will not have their dates modified.

== Installation ==

1. Upload `jbl-y2k.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Why would I ever use this? =

Well, it may be that I am too easily amused, but I find it mildly entertaining to see a site's content labeled as pre-dating the internet. It is also amusing to turn the plugin on just as a significant date/time passes (such as a change in DST), and leverage the general uncertainty most people have about computers, dates, and time.

Also, nostalgia for the y2k end-of-the-world scare.

= Will it work with insert_theme_name_here? =

As noted above, the plugin will operate on almost all requests for date-related data that utilize core WordPress functions to do so. If you have code that utilizes dates that do not pass through core WordPress date display functions, you will not see changes in the output of that code.

= Will it work with insert_plugin_name_here? =

See above re: themes.

== Screenshots ==

1. Screenshot demonstrating the effects of the plugin when activated. Note the changes to the page title, the post date, and the dates listed under "Recent Posts"

== Changelog ==

= 1.0 =
* Initial release.

