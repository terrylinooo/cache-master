# Cache Master - WordPress Cache Plugin

Cache Master is an extremely light-weight and high-performace cache plugin that speeds up your WordPress sites on the fly. The core is driven by Shieldon [Simple Cache](https://github.com/terrylinooo/simple-cache), a PSR-16 simple cache library.


![WordPress cache plugin](https://i.imgur.com/P1utVVR.png)

## Requirement

* PHP version > 7.1.0
* WordPress version > 4.7
* Tested up to 5.5.1


#### Notice: 

Before you install and use this plugin, please read the following notices carefully.

- This plugin only caches homepage, posts and pages.
- Logged-in users will not trigger the caching processes.
- A debug message will be attached to the end of the page source code. `<!-- This page is cached by Cache Master plugin. //-->`. This is for debugging purpose only, to let us know that the page is caching.

## Download

| source | download | 
| --- | --- | 
| WordPress | https://wordpress.org/plugins/cache-master/ |
| GitHub repository | https://github.com/terrylinooo/cache-master/releases | 
| PHP Composer | `composer create-project terrylinooo/cache-master cache-master` |


## Features

* Extremely light-weight and high-performace.
* Support up to 8 cache drivers such as Redis, Memcache, Memcached, APC, APCu, WinCache, MySQL and SQLite.

### License

Cache Master is developed by [Terry Lin](https://terryl.in) and released under the terms of the GNU General Public License v3.

