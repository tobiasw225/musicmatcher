#!/bin/bash

#/etc/init.d/apache2 stop 

echo "...........................................";
echo "Welcome to our preparation script.";
printf "...........................................\n\n";


echo '...docker part';


docker_version=="`docker -v`";
if [[ $docker_version = *"Docker"* ]]; then
echo "docker already present";
else
apt-get install docker
fi

echo '... docker compose';
docker_compose_version="`docker-compose --version`";


if [[ $docker_compose_version = *"docker-compose"* ]]; then

echo "docker compose already present";
else
apt-get install curl
curl -L https://github.com/docker/compose/releases/download/1.22.0/docker-compose-$(uname -s)-$(uname -m) -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

fi


printf '\n\n'
echo 'finished build script. you should now be able to run docker compose';
echo "start to build the script..."

wd=${PWD##*/}
if [[ $PWD = *"docker"* ]]; then
    cd .. && docker-compose -f  docker/docker-compose.yml build
    docker-compose -f  docker/docker-compose.yml run
elif [[ $PWD = *"musicmatcher"* ]]; then
    docker-compose -f  docker/docker-compose.yml build
    docker-compose -f  docker/docker-compose.yml run
else
    echo "please change into the 'musicmatcher' dir and run:";
    echo "docker-compose -f  docker/docker-compose.yml build";
fi






