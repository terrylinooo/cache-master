=== Cache Master ===

Contributors: terrylin
Tags: cache, redis, mongodb, memcached, apc, apcu
Requires at least: 4.7
Tested up to: 5.5.1
Stable tag: 2.0.3
Requires PHP: 7.1.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl.html

== Description ==

Cache Master is an extremely light-weight and high-performace cache plugin that speeds up your WordPress sites on the fly.
The core of Cache Master is driven by Shieldon Simple Cache, a PSR-16 simple cache library.

Open sourced on GitHub:

- [terrylinooo/simple-cache](https://github.com/terrylinooo/simple-cache) (Simple Cache library)
- [terrylinooo/cache-master](https://github.com/terrylinooo/cache-master) (Cache Master plugin)

First release date: October, 1, 2020

== Features ==

* Extremely light-weight and high-performace.
* Support up to 10 cache drivers such as File, Redis, Memcache, Memcached, APC, APCu, WinCache, MySQL, SQLite and MongoDB.
* Detailed cache statistics, easy to manage.
* Support to WooCommerce plugin.
* More...

Notice: 

Before you install and use this plugin, please read the following notices carefully.

- Logged-in users will not trigger the caching processes.
- A debug message will be attached to the end of the page source code. `<!-- This page is cached by Cache Master plugin. //-->`. This is for debugging purpose only, to let us know that the page is caching. This message can be disabled in `Settings` page.

If you find your website doesn't work with Cache Master, please report an issue on GitHub and list all plugins installed on your website. I'll find out the problem and fix it.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/cache-master` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to the Cache Master menu in Plugins and set your options.

== Frequently Asked Questions ==

= Should I disable other cache plugin? =

Cache Master cahces full page to static HTML, it is better to disable other similar cache plugins that cache HTML, too. It's okay to work with object cache plugin together.

== Screenshots ==

1. Setting page - Basic.
2. Setting page - Basic (Bottom).
3. Setting page - Advanced.
4. Setting page - Perferences.
5. Setting page - Benchmark.
6. Setting page - WooCommerce.
7. Setting page - Exclusion.
8. Setting page - Expert mode.
9. Setting page - Cache statistics.
10. Setting page - About author.
11. Front page - Benchmark (footer text)
12. Debug message (Normal mode)
13. Debug message (Expert mode)

== Changelog ==

= 1.0.0 (10/01/2020) =

* First release on WordPress plugin directory.

= 1.2.0 (10/06/2020) =

* Add "Expert Mode".

= 1.2.1 (10/07/2020) =

* Improve debug message.
* New setting option for Expert Mode.
* Add warning message if a user use a plugin having conflicts with Cache Master.

= 1.2.2 (10/07/2020) =

* Improve debug message - Add SQL query numbers.

= 1.3.0 (10/08/2020)

* Add setting option - Visibility of cache for logged-in users.
* Add setting option - Archive pages: category, tag, date and author.
* Add setting option - Homepage.
* Fix some small issues.

= 1.4.0 (10/09/2020) =

* Add setting page - Cache statistics.
* Improve code - Prevent conflicts with others plugins.

= 1.4.1 (10/16/2020) =

* Add feature - Automatic installation of Expert Mode code. (Removed in later versions)

= 1.5.1 (10/17/2020) =

* Add setting page - Benchmark settings.
* Add feature - Benchmark information in widget or footer area.
* Fix some small issues.

= 1.5.2 (10/17/2020) =

* Add a Clear Cache button on admin bar.

= 2.0.0 (10/27/2020) =

* Support to WooCommerce plugin.
* Add setting pages - WooCommerce, Exclusion,  Advanced settings.
* Add an option - HTML debug comment.
* Improve cache statistic page.
* Update translation strings for zh_TW, zh_CN.
* Fix issues.

= 2.0.1 (10/27/2020) =

* Fix SQLite driver error after performing a new installation.

= 2.0.3 (10/31/2020) =

* Support to WP-CLI