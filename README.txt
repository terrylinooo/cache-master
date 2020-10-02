=== Cache Master ===

Contributors: terrylin
Tags: cache
Requires at least: 4.7
Tested up to: 5.5.1
Stable tag: 1.1.0
Requires PHP: 7.1.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl.html

== Description ==

Cache Master is an extremely light-weight and high-performace cache plugin that speeds up your WordPress sites on the fly.
The core of Cache Master is driven by Shieldon Simple Cache], a PSR-16 simple cache library.

Open sourced on:

- https://github.com/terrylinooo/simple-cache (Simple Cache library)
- https://github.com/terrylinooo/cache-master (Cache Master plugin)

Notice: 

Before you install and use this plugin, please read the following notices carefully.

- This plugin only caches homepage, posts and pages.
- Logged-in users will not trigger the caching processes.
- A debug message will be attached to the end of the page source code. `<!-- This page is cached by Cache Master plugin. //-->`. This is for debugging purpose only, to let us know that the page is caching.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/cache-master` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to the Cache Master menu in Plugins and set your options.

== Features ==

* Extremely light-weight and high-performace.
* Support up to 8 cache drivers such as Redis, Memcache, Memcached, APC, APCu, WinCache, MySQL and SQLite.

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


