=== SM Sticky Clicky Star ===

Contributors: sethcarstens
Donate link: http://sethmatics.com/extend/plugins/sm-sticky-clicky-star/
Tags: sticky, post, page, plugin, ajax, admin
Requires at least: 5.1
Tested up to: 5.8.1
Stable tag: trunk

Turn sticky (featured) posts on and off with 1 easy click! Control permissions with "User Role Editor".

== Description ==

Turn sticky (featured) posts on and off with 1 easy click! Control permissions with "User Role Editor" provided by [Seth Carstens](https://sethcarstens.com) and [Sethmatics](https://sethmatics.com/).

This plugin is probably the most simple from the SM plugins collection. However, its usefulness and time saving features make it very powerful. Many themes and plugins use the "sticky" option in WordPress either to move a particular post above other posts, or to "feature" posts. An example is that a good deal of themes use "sticky" posts to populate a "featured posts" slider on the homepage of the blog. Quickly turn posts sticky status on and off with 1 click.

Features include:

* uses builtin WordPress functions to reduce any possibilities of conflicts with other themes and plugins
* a nice looking star icon uses AJAX upon click to immediately save your posts sticky status

Don't forget to rate our plugin so we know how we are doing!

== Installation ==

To install the plugin manually:

1. Extract the contents of the archive (zip file)
2. Upload the sm-sticky-clicky-star folder to your '/wp-content/plugins' folder
3. Activate the plugin through the Plugins section in your WordPress admin
4. Visit the "posts" section from within /wp-admin/.
5. Use the Sticky Clicky Stars to turn on and off the sticky attribute of the post.

== Changelog ==
Version 2.0.1
- Fix issue storing post-ids as strings instead of ints

Version 2.0.0
- Refactor for APB (abstract plugin base)
- Test with WP 5.1.1
- Fix PHPCS issues

Version 1.1.3
- Fix meta

Version 1.1.2
- Updated code for git sync + optimized code formatting

Version 1.1.1
- Checked working status with WordPress 4.2
- Updated documentation and initialized plugin using git-svn
- Testing git-svn revision 4

Version 1.1.0

- Corrected issue where style and javascript were loaded on all admin pages
- Corrected notice when AppThemes themes were not activated
- Converted entire plugin to use PHP Classes for extensibility

Version 1.0.6

- Corrected issue of all posts being made sticky.

Version 1.0.5

- Corrected custom post type losing sticky on save issue and minor admin styling issue.

Version 1.0.4

- Corrected custom post type sticky issue and removed sticky star from "page" post type editor.

Version 1.0.2

- Corrected issue where star click didn't work when blog was installed on subdirectory like domain.com/myblog/

Version 1.0.1

- First public version released, no changes yet.

== Upgrade Notice ==
Version 1.0.1

Requires at least WordPress version 3.1.X

== Frequently Asked Questions ==

Q: How do I use the plugin?

A: Visit the "posts" section from within /wp-admin/ and use the Sticky Clicky Stars to turn on and off the sticky attribute of the post. (see screenshot)

Q: What is sticky and why should I care?

A: If you found this plugin, you were likely searching for a better way to manage sticky posts. We assure you, this is a better way to manage sticky posts.

Q: Where is the options panel?

A: There is no options panel. The only changes you will see in the wp-admin is an additional column on the "posts" page that now has a Sticky Clicky Star.

== Screenshots ==

1. Sample of the "posts" page within wp-admin where a couple of the pages were marked as sticky.