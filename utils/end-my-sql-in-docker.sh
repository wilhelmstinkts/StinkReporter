#!/bin/bash
docker stop mysql
docker stop myadmin
docker container rm mysql myadmin