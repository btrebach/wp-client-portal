=== bbPress String Swap ===
Contributors: daveshine, deckerweb
Donate link: http://genesisthemes.de/en/donate/
Tags: bbpress, bbPress 2.0, title, forums title, forums archive, breadcrumb, breadcrumbs arguments, pagination, topics, replies, strings, swap, frontend, deckerweb
Requires at least: 3.6 and bbPress 2.2+
Tested up to: 3.7.1
Stable tag: 1.4.0
License: GPL-2.0+
License URI: http://www.opensource.org/licenses/gpl-license.php

In bbPress 2.2+, change Forums Archive Title (forums main page), some Breadcrumbs arguments, User Role display names plus a few other Forums Strings.

== Description ==

> #### Simply Changing Text Strings
> This **small and lightweight plugin** lets you change the Title of the Forums root view. Plus, I added 3 options for some important (as of my opinion) bbPress Breadcrumb parameters. Additionally, you can change the 4 built-in bbPress Forum User Role names. And finally, I've added 5 other important (again, as of my opinion) forum strings used in various Forum, Topic and Reply views. -- **Change all 23 strings *easily* on the bbPress main settings page**!
>
> #### Main Benefits of this Plugin
> * Fine tune your strings and display for YOUR FORUM USE CASE and used theme/templates!
> * Quick and easily adjust settings via *bbPress Main Settings* page.
> * Change strings independently from translation files.
> * Change strings as often as you want to :-)

= General Features =
* Change *Forums Archive Title* (in root view) - default: `Forums`
* Change *Breadcrumbs: Home Text* - default: `Home`
* Change *Breadcrumbs: Root Text* - default: `Forums`
* Change *Breadcrumbs: Separator* - default: `&rsaquo;`
* Change *User Role Display: Key Master* - default: `Key Master`
* Change *User Role Display: Moderator* - default: `Moderator`
* Change *User Role Display: Participant* - default: `Participant` (bbPress v2.2+)
* Change *User Role Display: Spectator* - default: `Spectator` (bbPress v2.2+)
* Change *User Role Display: Visitor* - default: `Visitor` (bbPress v2.2+)
* Change *User Role Display: Blocked* - default: `Blocked` (bbPress v2.2+)
* Change *User Role Display: Member* - default: `Member` (prior bbPress v2.2)
* Change *User Role Display: Guest* - default: `Guest` (prior bbPress v2.2)
* Change *Forum String: Posts* - default: `Posts`
* Change *Forum String: Started by (user)* - default: `Started by: %1$s`
* Change *Forum String: Freshness* - default: `Freshness`
* Change *Forum String: Voices* - default: `Voices`
* Change *Forum String: Submit* - default: `Submit`
* Change *Topic Pagination: Prev String/Text* - default: `&larr;`
* Change *Topic Pagination: Next String/Text* - default: `&rarr;`
* Change *Reply Pagination: Prev String/Text* - default: `&larr;`
* Change *Reply Pagination: Next String/Text* - default: `&rarr;`
* Change *No Forums found Text* - default: `Oh bother! No forums were found here!`
* Change *No Topics found Text* - default: `Oh bother! No topics were found here!`
* Change *No Replies found Text* - default: `Oh bother! No replies were found here!`
* Change *No Search results found Text* - default: `Oh bother! No forums were found here!`
* If settings fields are left blank, plugin display the original default values :)
* Fully WPML compatible.
* Fully Multisite compatible, you can also network-enable it if ever needed (per site use is recommended).
* Tested with WordPress branches 3.7 (and before with 3.4 - 3.6) - also in debug mode (no stuff there, ok? :)

= Requirements =
* WordPress 3.6 or higher
* bbPress 2.2 or higher
* *We ALWAYS recommend using latest versions!*

= Important Note Regarding Themes/ Plugins =
* If your current theme or other plugins change appropiate filters this could lead to not display any or all changes made by this plugin (though it's not harmful!).
* Some themes (especially bbPress compatible ones from 'ThemeForest' marketplace) come with own templates for bbPress and also change other display things (for example breadcrumb behavior) and functions... This could also lead to not display any or all changes made by this plugin. You then have to make the wished changes manually via the theme's templates or simply just call the support of its creator for further advise.

= Localization =
* English (default) - always included
* German (de_DE) - always included
* .pot file (`bbpress-string-swap.pot`) for translators is also always included :)
* Easy plugin translation platform via GlotPress tool: [Translate "bbPress String Swap"...](http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/bbpress-string-swap)
* *Your translation? - [Just send it in](http://genesisthemes.de/en/contact/)*

[A plugin from deckerweb.de and GenesisThemes](http://genesisthemes.de/en/)

= Feedback =
* I am open for your suggestions and feedback - Thank you for using or trying out one of my plugins!
* Drop me a line [@deckerweb](http://twitter.com/#!/deckerweb) on Twitter
* Follow me on [my Facebook page](http://www.facebook.com/deckerweb.service)
* Or follow me on [+David Decker](http://deckerweb.de/gplus) on Google Plus ;-)

= Tips & More =
* *Plugin tip:* [My bbPress Toolbar / Admin Bar plugin](http://wordpress.org/extend/plugins/bbpress-admin-bar-addition/) -- a great time safer and helper tool :)
* [Also see my other plugins](http://genesisthemes.de/en/wp-plugins/) or see [my WordPress.org profile page](http://profiles.wordpress.org/daveshine/)
* Tip: [*GenesisFinder* - Find then create. Your Genesis Framework Search Engine.](http://genesisfinder.com/)

== Installation ==

1. Upload the entire `bbpress-string-swap` folder to the `/wp-content/plugins/` directory -- or just upload the ZIP package via 'Plugins > Add New > Upload' in your WP Admin
2. Activate the plugin through the 'Plugins' menu in WordPress
3. On the regular bbPress settings (look under 'Settings > Forums') scroll down to the new section "Plugin: bbPress String Swap" and adjust your settings.
4. Enjoy the new wording for your forums :)

= Requirements =
* WordPress 3.6 or higher
* bbPress 2.2 or higher
* *We ALWAYS recommend using latest versions!*

**Note for own translation/wording:** For custom and update-secure language files please upload them to `/wp-content/languages/bbpress-string-swap/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that, just use a language file like `bbpress-string-swap-en_US.mo/.po` to achieve that (for creating one see the tools on "Other Notes").

== Frequently Asked Questions ==

= Can I Change More Strings, for Example String 'Xyz'? =
No, not yet. The plugin just uses currently available filters in bbPress branches from v2.1 or higher plus the WordPress global variable for all translations for a few other strings. So I'll only add new settings for more strings if there is an original bbPress filter/ hook available and if a setting really makes sense for some use cases (to slim down global variable usage!).

= The Plugin's Settings Have No Effect in My Install!? =
*Sadly, this could be true in some cases:*

* If your current used theme or other third-party plugins change appropiate filters this could lead to not display any or all changes made by this plugin (though it's not harmful!).
* Some themes (especially bbPress compatible ones from 'ThemeForest' marketplace) come with own templates for bbPress and also change other display things (for example breadcrumb behavior) and functions... This could also lead to not display any or all changes made by this plugin. You then have to make the wished changes manually via the theme's templates or simply just call the support of its creator for further advise.

== Screenshots ==

1. bbPress String Swap on the frontend: Forums Archive (root view) ([Click here for larger version of screenshot](https://www.dropbox.com/s/s8hfjoy6ymgjl4p/screenshot-1.png))

2. bbPress String Swap on the frontend: a single Forum view ([Click here for larger version of screenshot](https://www.dropbox.com/s/m5uzzp0ja8amfgg/screenshot-2.png))

3. bbPress String Swap on the frontend: a single Topic view ([Click here for larger version of screenshot](https://www.dropbox.com/s/5hhwj1sz49ap4pq/screenshot-3.png))

4. bbPress String Swap on the frontend: changed submit button ([Click here for larger version of screenshot](https://www.dropbox.com/s/47k5pqddpkmi65b/screenshot-4.png))

5. bbPress String Swap on the frontend: changed Prev/Next (text) strings for Topics & Replies navigation ([Click here for larger version of screenshot](https://www.dropbox.com/s/8oykhxquz9byuig/screenshot-5.png))

6. bbPress String Swap plugin section on the bbPress main settings page ([Click here for larger version of screenshot](https://www.dropbox.com/s/zut7lhwvz6xf24a/screenshot-6.png))

7. bbPress String Swap - plugin's help tab on bbPress settings page ([Click here for larger version of screenshot](https://www.dropbox.com/s/wy7q7zcxo60t4i3/screenshot-7.png))

== Changelog ==

= 1.4.0 (2013-11-20) =
* NEW: Added 4 new settings for all four *Oh bother...* text strings (no forums/topics/replies/search results)!
* UPDATE: Removed all 'gettext' filters from the plugin to speed up performance significantly and to avoid future error sources...!
* UPDATE: Improved registering, saving and calling of plugin's settings. (This includes the transfer of all single options of prior v1.4.0 to the new options array!)
* NEW: Plugin includes an uninstall script (as recommended from Plugin API) to delete plugin's options array when deleting the plugin via the plugins page in admin.
* CODE: Partly refactoring of larger code blocks of the plugin: speed up performance and rely on coding standards. Huge portions of code could be removed, yeah! :-)
* UPDATE: Updated German translations and also the .pot file for all translators!

= 1.3.0 (2013-03-10) =
* BUGFIX: Fixed "lost" setting for "Freshness" string. (Sorry for the delay, guys!)
* CODE: Improved main class, improved singleton behavior and instantiation.
* CODE: Minor code/documentation improvements.
* UPDATE: Updated German translations and also the .pot file for all translators!

= 1.2.0 (2012-11-19) =
* NEW: Added 4 new user role strings introduced with new bbPress 2.2 version.
* UPDATE: Ensured compatibility with new bbPress 2.2 version (tested with v2.2-RC1 and final v2.2).
* CODE: Minor code/documentation improvements.
* UPDATE: Updated German translations and also the .pot file for all translators!

= 1.1.0 (2012-09-18) =
* NEW: Added 2 options for the Prev/Next (Text) strings for Topic pagination.
* NEW: Added 2 options for the Prev/Next (Text) strings for Reply pagination.
* CODE: Minor code/documentation improvements.
* UPDATE: Tweaked screenshots plus reordered and added them to the assets folder in repo to drop them from download ZIP package.
* UPDATE: Updated German translations and also the .pot file for all translators!

= 1.0.0 (2012-09-10) =
* Initial release
* Supporting changes for 13 different strings!

== Upgrade Notice ==

= 1.4.0 =
Several additions & improvements: 4 new settings. Code refactoring, performance improvements, removal of all 'gettext' filters! Updated German translations and also the .pot file for all translators!

= 1.3.0 =
Maintenance release: Code improvements and bugfixes. Updated German translations and also the .pot file for all translators!

= 1.2.0 =
Maintenance release: 4 new user roles strings for bbPress 2.2+. Ensured compatibility with new bbPress 2.2 version. Updated German translations and also the .pot file for all translators!

= 1.1.0 =
Several additions & improvements: Added Prev/Next strings for Topics & Replies Pagination.

= 1.0.0 =
Just released into the wild.

== Plugin Links ==
* [Translations (GlotPress)](http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/bbpress-string-swap)
* [User support forums](http://wordpress.org/support/plugin/bbpress-string-swap)
* *Plugin tip:* [My bbPress Toolbar / Admin Bar plugin](http://wordpress.org/extend/plugins/bbpress-admin-bar-addition/) -- a great time safer and helper tool :)

== Donate ==
Enjoy using *bbPress String Swap*? Please consider [making a small donation](http://genesisthemes.de/en/donate/) to support the project's continued development.

== Translations ==

* English - default, always included
* German (de_DE): Deutsch - immer dabei! [Download auch via deckerweb.de](http://deckerweb.de/material/sprachdateien/bbpress-forum/#bbpress-string-swap)
* For custom and update-secure language files please upload them to `/wp-content/languages/bbpress-string-swap/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that, just use a language file like `bbpress-string-swap-en_US.mo/.po` to achieve that (for creating one see the following tools).

**Easy plugin translation platform with GlotPress tool:** [**Translate "bbPress String Swap"...**](http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/bbpress-string-swap)

*Note:* All my plugins are internationalized/ translateable by default. This is very important for all users worldwide. So please contribute your language to the plugin to make it even more useful. For translating I recommend the awesome ["Codestyling Localization" plugin](http://wordpress.org/extend/plugins/codestyling-localization/) and for validating the ["Poedit Editor"](http://www.poedit.net/), which works fine on Windows, Mac and Linux.

== Additional Info ==
**Idea Behind / Philosophy:** I've come across some user requests to change the title of the forums archive (a.k.a. root view). When researching for the proper filter for changing this I thought it would be handy to also change a few important breadcrumb parameters along with the title :). So this plugin was born. Nothing spectacular, though. Maybe a few other strings will be added in the future (only if it makes sense!).