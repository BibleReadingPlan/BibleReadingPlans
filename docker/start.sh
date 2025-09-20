#!/bin/sh

# https://hub.docker.com/_/wordpress
docker stack deploy -c docker-compose.yml wordpress
