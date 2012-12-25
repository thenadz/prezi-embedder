=== Plugin Name ===
Contributors: dan.rossiter
Tags: prezi, embed, presentation, iframe
Requires at least: 2.5
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows the user to quickly & easily embed a Prezi in Wordpress site by directly implementing the published 
iframe embed code.

== Description ==

This plugin allows the user to quickly & easily embed a Prezi in Wordpress site by directly implementing the published 
iframe embed code.

This plugin, like most things useful, grew out of a need. I had a Prezi and I had a WordPress blog. I Googled for a 
few hours and found some very dirty hacks that ended up not working, as well as a plugin or two that didn't work, or 
only half worked. When I realized that there were no *good* solutions around, I decided to create one.

This plugin is based on simplicity, making it extremely robust. On the back end, it is actually extremely simple. 
It takes the code that Prezi provides when you the the iframe embed code and simply inserts the variables that you
need before rendering a working Prezi.

I hope that you all find this plugin as useful as I have.

PS: If this plugin is helpful, please take a moment to give it the rating you believe it deserves. I truly appreciate 
your support!

== Installation ==

1. Upload `prezi-embedder` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[prezi id="<Prezi ID>"]` in any post or page were you want to embed a Prezi.

You can find your Prezi ID in a few different places. The easiest is to go to the URL for your Prezi, which 
will look something like this: `http://prezi.com/<Prezi ID>/<Prezi Name>`. All you need to do is extract the 
Prezi ID section and include it in the shortcode above. That's it!

*EDIT:* It's now _even easier_ to embed your Prezi. Just paste the entire URL (http://prezi.com/<blah, blah, blah>) 
for your id. The plugin will handle extracting the ID!

= Prezi Embedder Options =

In addition to a simple embed, you can also set some additional embed options:

1. width (default = 500)
1. height (default = 400)
1. lock_to_path (default = 0)

With *lock_to_path*, the default allows viewers to pan & zoom freely. If you want to constrain viewers 
to simple back and forward steps, set `lock_to_path=1`.

The following shortcode is equivalent to `[prezi id="<Prezi ID>"]`:

`[prezi id="<Prezi ID>" width=500 height=400 lock_to_path=0]`

== Changelog ==

= 1.1 =
* Enhancement: Shortcode now handles the full URL of the Prezi as an ID value (while still supporting just the id value).
* Enhancement: Added some simple error checking for attribute values.

= 1.0 =
* Released: Initial release.
