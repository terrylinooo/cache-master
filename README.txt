=== Cache Master ===

Contributors: terrylin
Tags: cache, redis, mongodb, memcached, apc, apcu
Requires at least: 4.7
Tested up to: 6.0.1
Stable tag: 2.1.3
Requires PHP: 7.1.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl.html

== Description ==

Cache Master is an extremely lightweight, high-performance cache plugin that speeds up your WordPress sites on the fly. The core of Cache Master is driven by Shieldon Simple Cache, a PSR-16 simple cache library.

Open sourced on GitHub:

- [terrylinooo/simple-cache](https://github.com/terrylinooo/simple-cache) (Simple Cache library)
- [terrylinooo/cache-master](https://github.com/terrylinooo/cache-master) (Cache Master plugin)

First release date: October, 1, 2020

== Features ==

* Extremely lightweight and high-performance.
* Support up to 10 cache drivers such as File, Redis, Memcache, Memcached, APC, APCu, WinCache, MySQL, SQLite, and MongoDB.
* Provide detailed cache statistics, easy to manage.
* Compatible with the WooCommerce plugin.
* And more...

Notice:

Before you install and use this plugin, please read the following notices carefully:

- Logged-in users will not trigger the caching process.
- A debug message will be appended to the end of the page's source code: `<!-- This page is cached by the Cache Master plugin. //-->`. This is intended for debugging purposes only, confirming that the page is being cached. This message can be disabled in the Settings page.

If you encounter issues with your website when using Cache Master, please report the problem on GitHub and list all plugins installed on your website. I'll investigate the problem and provide a fix.

== Installation ==

- Upload the plugin files to the /wp-content/plugins/cache-master directory, or install the plugin directly through the WordPress plugins screen.
- Activate the plugin via the 'Plugins' screen in WordPress.
- Navigate to the Cache Master menu in the Plugins section and configure your options.

== Frequently Asked Questions ==

= Should I disable other cache plugins? =

Cache Master caches entire webpages into static HTML files. Therefore, it is recommended to disable other similar cache plugins that perform the same function. However, it can function alongside object cache plugins without issue.

= How can I determine whether the caching is working or not? =

Be aware that logged-in users will not trigger the caching process. To verify caching, use incognito mode or a different browser to revisit the same webpage, and then you can check the cache status in one of the following ways:

- View the source code of the webpage and check the debug message as shown in screenshot (L).
- Enable the benchmark information in the footer section as shown in screenshot (K), where you can see the cache status.

If there is no debug message in the source code, or if the cache status consistently displays 'No', there might be a plugin conflict with Cache Master that prevents it from working correctly.

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

== Translation ==

Japanese (ja_JP) by [Colocal](https://colocal.com).

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

= 2.1.0 (11/15/2020) =

* Add options - Now, you can use unix socket or TCP in Redis, MongoDB and Memcaced Drivers.
* Update core library to 1.3.1
* Add unit tests and run the tests before releasing new updates.
* Fix issues.

= 2.1.1 (10/31/2021) =

* Fix type hint.
* Driver will fall back to File driver if current driver is unavailable.
* Test up to PHP 8.0
* Test up to WordPress 5.8.1

= 2.1.2 (8/28/2022) =

* Fix a type hint issue that occurs a PHP 8 fatal error.
* Test up to PHP 8.0
* Test up to WordPress 6.0.1
* Fix coding style to fit the WordPress coding standard.

= 2.1.3 (5/29/2023) =

* Test up to PHP 8.2.5
* Test up to WordPress 6.2.2
* Add Japanese translation.
