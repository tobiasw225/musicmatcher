# Docker 


The recommended way to set up the system is through docker, since it enables easy crossplattform development. To make the installation process as easy as possible we created a build-script which downloads all necessary components. Make the file executable and run the script:

	$ sudo chmod +x docker/build.sh
	$ sudo docker/build.sh
	
Afterwards you can use docker-compose to load the docker-containers and it's content.

## Docker-Compose


If everything is installed you can build the project. Change into the main  directory and run:

	$ docker-compose -f docker/docker-compose.yml build
	
This will install all needed dependecies in our project and set some environment variables. You thus can skip the sections on how to install audiveris and how to install without docker. To run the program, enter the following command. Make sure your computer has enough space (~1GB).

To run all containers run:

	$ docker-compose docker/docker-compose.yml up

You can now access the web-page at your [localhost](http://localhost).

### Postgres - Database

For testing we are using a Postgres-Database. You can access the database e.g. with pgAdmin with the following parameters:

- host: 127.0.0.1
- port: 5433
- user: postgres
- psw: cs2018

## Single Dockerfile

Finally you build the container with the following command. Make sure to be in the musicmatcher directory, docker will find the Dockerfile automatically. 

	$ docker build -t musicmatcher .

This will install all needed dependecies in our project and set some environment variables. You thus can skip the sections on how to install audiveris and how to install without docker. To run the program, enter the following command. The Docker-container is based on an ubuntu-image for simplicity reasons. This can be changed if need be. Make sure your computer has enough space (~1GB).
**You will have to change the path to the musicmatcher directory!**

	$ docker run -p 80:80 -v /path/to/musicmatcher/src/:/var/www/html/ musicmatcher

You can now access the web-page at your [localhost](http://localhost).



