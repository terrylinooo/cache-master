#!/usr/bin/env bash

target_path="/tmp/wordpress/wp-content/plugins/cache-master"
rm -rf ${target_path}
mkdir ${target_path}
cp -a ./inc ${target_path}
cp -a ./languages ${target_path}
cp -a ./vendor ${target_path}
cp ./LICENSE ${target_path}
cp ./README.txt ${target_path}
cp ./cache-master.php ${target_path}
cp ./uninstall.php ${target_path}
