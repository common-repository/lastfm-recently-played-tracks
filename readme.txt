=== Last.fm Recently Played Tracks ===
Contributors: justin-turner
Donate link: http://ijustin.org/donate/
Tags: lastfm, last.fm, recent, tracks, played, music
Requires at least: 2.9.2
Tested up to: 3.0.4
Stable tag: 1.2.0

Plugin to display recently played tracks from Last.fm for a user.

== Description ==

The Last.fm Recently Played Tracks widget is here to feel in the gap of old plugins and other plugins that just don't seem to work right anymore! When you search the WordPress plugins gallery, you'll notice that all of the Last.fm recently playing plugins seem to be at least one to two years old or have low reviews. That's why I took the time to whip up this widget.

= IMPORTANT NOTE =

If you upgraded to version 1.1.8 BEFORE 5:30PM CST on 10/7/2010, please delete and reinstall the plugin. There was a subversion error that caused the stylesheets to not be included in the WordPress download file. The issue has now been resolved.

= Version 1.2.0 =
Version 1.2.0 fixes an XML issue that may occur when Last.fm provides invalid responses. Also fixed issue with incompatibility with Searchlight plugin.

Shortcode Support!

You can now display your latest tracks played anywhere you can insert a shortcode! All you have to do is put the shortcode `[lastfm]` where you want it to appear. You can set the options for it as well.

= Shortcode Options =
* Username - used as `username=xxxx`
* Number of Tracks - used as `tracks=(any number between 1 and 50)`
* Show Album Art - used as `albumart=(0 for no, 1 for yes)`
* Show User Info - used as `userinfo=(0 for no, 1 for yes)`

Example: `[lastfm username=just_in_time90 tracks=3 albumart=1 userinfo=1]`

If you don't set the options, they will default to your widget options.

= Features =
* Selectable Username (of course)
* Shortcode Support
* Widget Title
* Number of tracks to show
* Select whether to show user info or not
* Select whether to show album art or not
* Show Last.fm star icon if no album art available
* Ability to customize style

= Current Limitations =
* Only one instance of the widget is allowed right now

== Installation ==

1. Upload entire `lastfm-recently-played-tracks` folder to `/wp-content/plugins/` directory
2. Activate the plugin in WordPress
3. Visit the widgets section and drag widget to sidebar
4. Select your settings

= Upgrade Instructions =

Now that the plugin utilizes a stylesheet, if you customize it in anyway, you'll need to make a backup copy of the "custom.css" stylesheet before you update the plugin. If you do not, you'll lose all the changes you made.

== Frequently Asked Questions ==

If you have a question, submit it on the contact page [here](http://ijustin.org/contact).

== Screenshots ==

1. In use on iJustin.org
1. Zoomed in

== Changelog ==

= 1.2.0 =
* Added internalization of errors that occur when Last.fm provides bad responses to the plugin. Also fixed issue with incompatibility with Searchlight plugin.

= 1.1.8 =
* Moved styling to external stylesheet. Widget will now default to the font and styling of your theme. You can customize it in the custom.css file by using the Plugin Editor.

= 1.1.7 =
* Fixes for Firefox not displaying widget styling properly.

= 1.1.6 =
* Added requests for link to profile and ability to customize styling.

= 1.1.5 =
* Contains checks and fixes for issues that may arise when a theme is missing certain variables.

= 1.1.4 =
* Major code fix that could cause error on some webhosts with differing PHP setups.

= 1.1.3 =
* Minor code and bug fixes.

= 1.1.2 =
* Code updates and fixes as identified by plugin users.

= 1.1.1 =
* Code updates

= 1.1.0 =
* Updated coding to support shortcode usage as well as code cleanup.

= 1.0.12 =
* Corrected several spelling errors throughout plugin as well as removal of some deprecated PHP functions.

= 1.0.11 =
* Added option to be able to select whether or not to use JS as a temporary fix for some issues working with themes such as FutureBlogger.

= 1.0.10 =
* Cosmetic fix for long song titles

= 1.0.9 =
* Added option to select whether to enable AJAX/JS auto-refresh of tracks.
* Cosmetic updates to settings section.
* In this version of the plugin, auto refresh is DISABLED by default.

= 1.0.8 =
* Addresses caching issue and code fix for if user doesn't have profile picture so that no "X" or "?" appears instead. (Thanks Cidney!)

= 1.0.7 =
* Addresses issue caused if plugin is disabled while someone is on the site and the plugin tries to JavaScript refresh.

= 1.0.6 =
* Fixed issue caused by whitespace in PHP code that caused activation error and on some blogs header output errors

= 1.0.5 =
* Fix that caused play time to show up incorrectly
* Compatibility check for version 3.0.1 of WordPress

= 1.0.4 =
* Added user info functionality

= 1.0.3 =
* Fixed slight spelling issues throughout the plugin

= 1.0.2 =
* Added auto-refresh of tracks using JS

= 1.0.1 =
* Added error message if last.fm is down

= 1.0.0 =
* First released version

== Upgrade Notice ==

= 1.2.0 =
* This update fixes an issue that may occur if Last.fm provides a bad response. Also fixed issue with incompatibility with Searchlight plugin. It is recommended for all users.

= 1.1.8 =
* This version moves all styling to an external stylesheet and makes the plugin "vanilla" and styled to match your plugin. You can customize it in the custom.css file by using the Plugin Editor.

= 1.1.7 =
* This version includes a fix for Firefox not displaying the styling area properly. It is recommended for all users.

= 1.1.6 =
* This version includes new features like a link to view your last.fm profile and the ability to customize the styling of the widget.

= 1.1.5 =
* This version contains checks and fixes for issues that may arise when a theme is missing certain variables.

= 1.1.4 =
* This version includes a major coding check to try to fix coding errors.

= 1.1.3 =
* This update contains a bugfix related to some installations throwing an error message. It is recommended for all users.

= 1.1.2 =
* This update contains code updates and fixes. It is recommended for all users.

= 1.1.1 =
* This version includes code updates. It is recommended for all users.

= 1.1.0 =
* This update adds shortcut support. See the readme file for details.
Example: [lastfm username=just_in_time90 tracks=5 albumart=1 userinfo=1]

= 1.0.12 =
* This update is recommended as it fixes several spelling errors throughout the plugin, but most importantly removes the use of some deprecated PHP functions.

= 1.0.11 =
* This update adds new features to the plugin. If you are using the theme FutureBlogger, this update will give the ability to not use JavaScript so that the plugin will operate correctly.

= 1.0.10 =
This update is a cosmetic update for dealing with long song titles as well as coding cleanup. It is still recommended that you upgrade to this version as soon as possible. If upgrading from 1.0.8, please see 1.0.9 upgrade notice for info about auto-refresh.

= 1.0.9 =
This update provides only minimal code changes and cosmetic updates, but is recommended to all users. Auto-refresh using JavaScript will be disabled by default. Visit the settings to re-enable it.

= 1.0.8 =
This update is recommended as it fixes a caching issue and an issue that occurred if the last.fm profile didn't have a profile picture. Thanks to Cidney for helping catch this bug!

= 1.0.7 =
This update is recommended as it dresses an issue caused if plugin is disabled while someone is on the site and the plugin tries to JavaScript refresh.

= 1.0.6 =
This update is recommended and important as it fixes an issue that may cause your blog to display "headers already sent" errors or an error upon activation.

= 1.0.5 =
This update is recommended as it fixes a problem that would cause time played to show incorrectly and code updates to ensure compatibility with WP 3.0.1

= 1.0.4 =
This update adds new functionality and various code fixes as well.

= 1.0.3 =
For best coding practices and spelling error fixes, this upgrade is recommended.

= 1.0.2 =
For latest features and best coding, upgrade to this version as soon as possible.

= 1.0.1 =
This update is recommended as it addresses error handling if Last.fm is down.