# Docker 


The recommended way to set up the system is through docker, since it enables easy crossplattform development.
To use the docker-containers, you'll first need docker:

	$ sudo apt-get install docker

Visit [docker.com](https://www.docker.com/docker-windows) to download the windows version.

After having installed docker, move into the musicmatcher directory. If a webserver is running in the background, you can stop it e.g. with 

	$ sudo /etc/init.d/apache2 stop 

## With Single Dockerfile

Finally you build the container with the following command. Make sure to be in the musicmatcher directory, docker will find the Dockerfile automatically. 

	$ docker build -t musicmatcher .

This will install all needed dependecies in our project and set some environment variables. You thus can skip the sections on how to install audiveris and how to install without docker. To run the program, enter the following command. The Docker-container is based on an ubuntu-image for simplicity reasons. This can be changed if need be. Make sure your computer has enough space (~1GB).
**You will have to change the path to the musicmatcher directory!**

	$ docker run -p 80:80 -v /path/to/musicmatcher/src/:/var/www/html/ musicmatcher

You can now access the web-page at your [localhost](http://localhost).

## With Docker-Compose
The new version links several docker-containers with docker-compose. To install docker-compose run the following commands in a shell:


	$ sudo apt-get install curl
	$ sudo curl -L https://github.com/docker/compose/releases/download/1.22.0/docker-compose-$(uname -s)-$(uname -m) -o /usr/local/bin/docker-compose
	$ sudo chmod +x /usr/local/bin/docker-compose
	$ docker-compose --version

If everything is installed you can build the project. Change into the docker directory and run:

	$ docker-compose build
	
This will install all needed dependecies in our project and set some environment variables. You thus can skip the sections on how to install audiveris and how to install without docker. To run the program, enter the following command. Make sure your computer has enough space (~1GB).

To run all containers run:

	$ docker-compose up

You can now access the web-page at your [localhost](http://localhost).

## Postgres - Database

For testing we are using a Postgres-Database. You can access the database e.g. with pgAdmin with the following parameters:

host: 127.0.0.1
port: 5433
user: postgres
psw: cs2018

