=== CC-Update ===
Contributors: ClearcodeHQ, PiotrPress
Tags: update, autoupdate, git, deploy, repository, deployment, clearcode, piotrpress
Requires PHP: 7.0
Requires at least: 4.8.2
Tested up to: 4.9.6
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

This plugin allows you to automatically send changes to your GIT repository, immediately after any update is made on your site.

== Description ==

This plugin allows you to automatically send changes to your GIT repository, immediately after any update is made on your site.

If you store the source code of your website in the GIT repository, you can use this plugin to automatically send changes in the website's code to the repository after each update.
The plugin checks for updates (core, plugin, theme, translation) in a selected time interval, creates a new commit, and makes a push to the GIT repository.
The plugin supports automatic WordPress updates. After each action the plugin saves the status to logs which are available through wp-admin and also are sent by email to defined recipients.

== Installation ==

= From your WordPress Dashboard =

1. Go to 'Plugins > Add New'
2. Search for 'CC-Update'
3. Activate the plugin from the Plugin section on your WordPress Dashboard.

= From WordPress.org =

1. Download 'CC-Update'.
2. Upload the 'cc-update' directory to your '/wp-content/plugins/' directory using your favorite method (ftp, sftp, scp, etc...)
3. Activate the plugin from the Plugin section in your WordPress Dashboard.

= Once Activated =

1. Visit the 'Update> Settings' page, select your preferred options and save them.

= Multisite =

The plugin can be activated and used for just about any use case.

* Activate at the site level to load the plugin on that site only.
* Activate at the network level for full integration with all sites in your network (this is the most common type of multisite installation).

== Screenshots ==

1. **CC-Update Settings** - Visit the 'Update > Settings' page, select your preferred options and save them.
2. **CC-Update Logs** - Visit the 'Update > Logs' page to review latest updates logs.

== Changelog ==

= 1.0.0 =
*Release date: 19.06.2018*

* First stable version of the plugin.