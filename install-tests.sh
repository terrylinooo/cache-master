#!/usr/bin/env bash

bash bin/install-wp-tests.sh wordpress_unittest shieldon taiwan localhost latest true
ln -s $(pwd) /tmp/wordpress/wp-content/plugins/cache-master
