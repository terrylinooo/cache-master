=== Cache Master ===

Contributors: terrylin
Tags: cache, redis, memcache, memcached, apc, apcu
Requires at least: 4.7
Tested up to: 5.5.1
Stable tag: 1.4.3
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
* Support up to 8 cache drivers such as Redis, Memcache, Memcached, APC, APCu, WinCache, MySQL and SQLite.
* Detailed cache statistics, easy to manage.

Notice: 

Before you install and use this plugin, please read the following notices carefully.

- Logged-in users will not trigger the caching processes.
- A debug message will be attached to the end of the page source code. `<!-- This page is cached by Cache Master plugin. //-->`. This is for debugging purpose only, to let us know that the page is caching.

If you find your website doesn't work with Cache Master, please report an issue on GitHub and list all plugins installed on your website. I'll find out the problem and fix it.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/cache-master` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to the Cache Master menu in Plugins and set your options.

== Screenshots ==

1. Main setting page.
2. Main setting page. (Bottom part)
3. Debug message (Normal mode)
4. Debug message (Expert mode)
5. Expert Mode setting page.
6. Cache statistics setting page.

== Copyright ==

Cache Master, Copyright 2020 TerryL.in
Cache Master is distributed under the terms of the GNU GPL

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

== Changelog ==

= 1.1.0

* First release on WordPress plugin directory.

= 1.1.1

* Fix incorrect setting link.

= 1.2.0

* Add "Expert Mode".

= 1.2.1

* Improve debug message.
* New setting option for Expert Mode.
* Add warning message if a user use a plugin having conflicts with Cache Master.

= 1.2.2

* Improve debug message - Add SQL query numbers.

= 1.3.0

* Add setting option - Visibility of cache for logged-in users.
* Add setting option - Archive pages: category, tag, date and author.
* Add setting option - Homepage.
* Fix some small issues.

= 1.4.0

* Add setting page - Cache statistics.
* Improve code - Prevent conflicts with others plugins.

= 1.4.1

* Add feature - Automatic installation of Expert Mode code.