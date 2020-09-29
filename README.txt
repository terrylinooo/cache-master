=== Cache Master ===

Contributors: terrylin
Tags: cache
Requires at least: 4.0
Tested up to: 5.3.0
Stable tag: 1.1.0
Requires PHP: 7.1.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl.html

== Description ==

Cache Master is an extremely light-weight and high-performace cache plugin that speeds up your WordPress sites on the fly. The core is driven by Shieldon [Simple Cache](https://github.com/terrylinooo/simple-cache), a PSR-16 simple cache library.

Notice: 

Before you install and use this plugin, please read the following notices carefully.

- This plugin only caches homepage, posts and pages.
- Logged-in users will not trigger the caching processes.
- The cached data outputs at a very eary stage of WordPress, the `init` action hook, so that the admin bar will disappear when browsing homepage, posts and pages, even you are logged in.
- This plugin is designed for performance, not for convenience.
- A debug message will be attached to the end of the page source code. `<!-- This page is cached by Cache Master plugin. //-->`. This is for debugging purpose only, to let us know that the page is caching.
- The cache of a post (page) will be deleted once the post (page) is updated.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/cache-master` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to the Cache Master menu in Plugins and set your options.

== Features ==

* Light-weight and high-performace.
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

= 1.0.0

* First release.
