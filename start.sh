#!/bin/bash
pushd `dirname $0` > /dev/null
PATH_PWD=`pwd`
popd > /dev/null

source $PATH_PWD/.env

export COMPOSE_FILE=$PATH_PWD/docker/docker-compose.yml
#docker-compose build --build-arg user_id=$USER_ID  --build-arg group_id=$GROUP_ID bigimport_php
docker-compose up -d
#docker-compose build bigimport_php
