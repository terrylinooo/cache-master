# Cache Master - WordPress Cache Plugin

[![Build Status](https://travis-ci.org/terrylinooo/cache-master.svg?branch=master)](https://travis-ci.org/terrylinooo/cache-master) [![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

![WordPress Cache Plugin](./inc/assets/images/banner-772x250.png)

Cache Master is an extremely light-weight and high-performace cache plugin that speeds up your WordPress sites on the fly. The core is driven by Shieldon [Simple Cache](https://github.com/terrylinooo/simple-cache), a PSR-16 simple cache library.

## Requirement

* PHP version > 7.1.0
* WordPress version > 4.7
* Tested up to 5.5.3

## Features

* Extremely light-weight and high-performace.
* Support up to 8 cache drivers such as Redis, Memcache, Memcached, APC, APCu, WinCache, MySQL and SQLite.
* Detailed cache statistics, easy to manage.

## Download

| source | download | 
| --- | --- | 
| WordPress | https://wordpress.org/plugins/cache-master/ |
| GitHub repository | https://github.com/terrylinooo/cache-master/releases | 
| PHP Composer | `composer create-project terrylinooo/cache-master cache-master` |

## Screenshots

![WordPress Cache Plugin](./inc/assets/images/screenshots/screenshot-1.png)

Setting page - Basic.

![Cache Plugin for WordPress](./inc/assets/images/screenshots/screenshot-2.png)

Setting page - Basic (Bottom).

![Best WordPress Cache Plugin](./inc/assets/images/screenshots/screenshot-3.png)

Setting page - Advanced.

![Simplest WordPress Cache Plugin](./inc/assets/images/screenshots/screenshot-4.png)

Setting page - Perferences.

![Best WordPress Cache Plugin](./inc/assets/images/screenshots/screenshot-5.png)

Setting page - Benchmark.

![MySQL WordPress Cache Plugin](./inc/assets/images/screenshots/screenshot-6.png)

Setting page - WooCommerce.

![NoSQL WordPress Cache Plugin](./inc/assets/images/screenshots/screenshot-7.png)

Setting page - Exclusion.

![Memcache WordPress Cache Plugin](./inc/assets/images/screenshots/screenshot-8.png)

Setting page - Expert mode.

![Memcached WordPress Cache Plugin](./inc/assets/images/screenshots/screenshot-9.png)

Setting page - Cache statistics.

![Redis WordPress Cache Plugin](./inc/assets/images/screenshots/screenshot-10.png)

Setting page - About author.

![MongoDB WordPress Cache Plugin](./inc/assets/images/screenshots/screenshot-11.png)

Front page - Benchmark (footer text)

#### Debug message

A debug message will be attached to the end of the page source code. `<!-- This page is cached by Cache Master plugin. //-->`. This is for debugging purpose only, to let us know that the page is caching.

(1)
![WordPress cache plugin](./inc/assets/images/screenshots/screenshot-12.png)

Normal mode.

(2)
![WordPress cache plugin](./inc/assets/images/screenshots/screenshot-13.png)

Expert mode.

### Notice

If you find your website doesn't work with Cache Master, please report an issue on GitHub and list all plugins installed on your website. I'll find out the problem and fix it.


### License

Cache Master is developed by [Terry Lin](https://terryl.in) and released under the terms of the GNU General Public License v3.

