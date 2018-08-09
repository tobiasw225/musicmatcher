#!/bin/bash

#/etc/init.d/apache2 stop 

echo "...........................................";
echo "Welcome to our preparation script.";
echo "We simply check whether audiveris has already been cloned and do if necessary.";
printf "...........................................\n\n";

# set project directories
project_dir="$(dirname "$(pwd)")"
audiveris_dir="$project_dir/backend/audiveris";

audiveris_in_folder=false;

# check whether audiveris is already present
if [ -d "$audiveris_dir" ]; then

# check whether audiveris is complete
folder_size="`du -hs $audiveris_dir`";
folder_size=${folder_size%M*};
audiveris_size=300; #actually 398 M


if [ "$folder_size" -ge "$audiveris_size" ]; then
  echo "$audiveris_dir seems ok";
  audiveris_in_folder=true;
else
  echo "$audiveris_dir seems not ok. I'm going to remove it and reclone.";
  audiveris_in_folder=false;
fi
else
  audiveris_in_folder=false;
fi


if [ "$audiveris_in_folder"=true ]; then
  echo "audiveris is already in the correct folder.";
  echo "if there's a new version of audiveris you might have to clone it.";
else
  echo "i'm going to clone a fresh version of audiveris.";
  git clone https://github.com/Audiveris/audiveris.git 
  cd ../backend/audiveris && \
  git checkout development
fi



echo 'finished audiveris part';
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

docker-compose build






