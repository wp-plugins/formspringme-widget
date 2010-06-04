=== FormSpring.me Question Widget ===
Contributors: Noah Coffey
Tags: formspring, formspringme, question, answer, q&a, widget, sidebar
Requires at least: 2.8
Tested up to: 3.0
Stable tag: trunk

Easily allows you to place a FormSpring.me question box on your sidebar and a shortcode to display your recently answered questions on any page or post.

== Description ==

Easily allows you to place a FormSpring.me question box on your sidebar and a shortcode to display your recently answered questions on any page or post.

== Installation ==

1. Upload `fsmWidget.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add the new Widget to your sidebar on the Widgets menu
4. (Optional) Add the [formspring username="my-username-goes-here"] shortcode to any page or post.

== Frequently Asked Questions ==

= How do I create a FormSpring.me account? =

You can create a free FormSpring.me account by visiting http://www.formspring.me

= What is the "username" field? =

This is your FormSpring.me username.

= What are the options for the shortcode? =

The default shortcode you need to enter is:

[formspring username="my-username-goes-here"]

To control the number of questions displayed:

[formspring username="my-username-goes-here" questions="5"]

To display an "Ask me anything" box at the top of the page:

[formspring username="my-username-goes-here" ask="yes"]

= How can I customize the way my questions page looks? =

The stylesheet that controls the question page is located in the plugin folder (fsmWidget.css). There is also an image in the images/ folder inside the plugin folder.


== Changelog ==

= 0.3 =
Added shortcode for displaying questions and answers on a post/page.

= 0.2 =
Internal housekeeping.

= 0.1 =
Initial version.