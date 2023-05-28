#!/usr/bin/env bash

# Plugin intergration tests
# https://make.wordpress.org/cli/handbook/misc/plugin-unit-tests/

bash bin/install-wp-tests.sh wordpress_unittest shieldon taiwan localhost latest true
ln -s $(pwd) /tmp/wordpress/wp-content/plugins/cache-master
