=== MP Stacks + Passwords ===
Contributors: johnstonphilip
Donate link: http://mintplugins.com/
Tags: page, builder, stacks, bricks
Requires at least: 3.5
Tested up to: 4.3
Stable tag: 1.0.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Password Protect any Stack or Brick in MP Stacks.

== Description ==

Password Protect any Stack or Brick in MP Stacks.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the 'mp-stacks-passwords' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Build Bricks under the “Stacks and Bricks” menu. 
4. Publish your bricks into a “Stack”.
5. Put Stacks on pages using the shortcode or the “Add Stack” button.

== Frequently Asked Questions ==

See full instructions at http://mintplugins.com/doc/mp-stacks

== Screenshots ==


== Changelog ==

= 1.0.0.2 = November 22, 2015
* Change to use MP Stacks Ajax Functions for Ajax Brick refreshing added in MP Stacks 1.0.4.4.
* Make sure to set the flag for "mp_stacks_execute_content_types_in_brick" to false so that Brick COntent Types dont get executed.
* Make sure to set the mp_stacks_execute_mp_brick_in_mp_stack to false before the passwords are entered so that Brick Content Types aren't executed before a password is entered for the FULL stack.

= 1.0.0.1 = September 27, 2015
* Documentation Improvements.
* Better, cleaner variable usage in js.
* Changed "post-id" attr for pw form to "mp-brick-id".
* Make sure mp-stacks-passwords.js is enqueued if Stack is password protected. Previously just Bricks made it enqueue.

= 1.0.0.0 = September 21, 2015
* Original release
