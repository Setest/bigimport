#!/bin/bash
pushd `dirname $0` > /dev/null
PATH_PWD=`pwd`
popd > /dev/null

source $PATH_PWD/.env

export COMPOSE_FILE=$PATH_PWD/docker/docker-compose.yml
docker exec -it bigimport_php sh -c 'php /var/www/bin/console import data/categories.json data/products.json'
#docker exec -it bigimport_php sh -c 'php -d xdebug.profiler_enable=0 -d xdebug.remote_enable=0 -d xdebug.default_enable=0 -f /var/www/bin/console import data/categories.json data/products.json'