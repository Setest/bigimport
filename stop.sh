#!/bin/bash
pushd `dirname $0` > /dev/null
PATH_PWD=`pwd`
popd > /dev/null

export COMPOSE_FILE=$PATH_PWD/docker/docker-compose.yml
docker-compose down
