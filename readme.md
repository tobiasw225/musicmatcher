# Music Matcher

$ indicates bash-command

use 

	$ git clone git@github.com:tobiasw225/musicmatcher.git
to clone the repository to the folder of your choice.	

## Who we are and what we do:

## Set up Docker-Container

The recommended way to set up the system is through docker, since it enables easy crossplattform development.
To use the docker-container, you'll first need docker:

	$ sudo apt-get install docker

Visit [docker.com](https://www.docker.com/docker-windows) to download the windows version.
After having installed docker, move into the musicmatcher directory. If a webserver is running in the background, you can stop it e.g. with 

	$ sudo /etc/init.d/apache2 stop 


Finally you build the container with the following command. Make sure to be in the musicmatcher directory, docker will find the Dockerfile automatically. 

	$ docker build -t musicmatcher .

This will install all needed dependecies in our project and set some environment variables. You thus can skip the sections on how to install audiveris and how to install without docker. To run the program, enter the following command. The Docker-container is based on an ubuntu-image for simplicity reasons. This can be changed if need be. Make sure your computer has enough space (~1GB).
**You will have to change the path to the musicmatcher directory!**

	$ docker run -p 80:80 -v /path/to/musicmatcher/src/:/var/www/html/ musicmatcher

You can now access the web-page at your [localhost](http://localhost).


## Installation without Docker

First clone the repository to your computer and copy it to the directory of your choice. First you'll have to install apache2 for PHP-actions.

	$ 	sudo apt-get install apache2 php-7.2 php7.2-gd 
	
If you want to move the files to [/var/www/html/]() make sure you have writing permissions. Otherwise you'll need to setup a docker container.
	
	$ sudo chown -R yourusername:www-data /folder/used/by/EE

### How to install audiveris
The following steps describe how to install everything in order to run the OMR. It's not necessary  to install gradle, you can simply run

	$ /audiveris/gradlew

with the corresponding command.

	$ sudo apt-get update
	$ sudo apt-get install openjdk-8-jdk	
	$ sudo apt-get install libfreetype6-dev
For Audiveris to work you need at least the four language-packages

	$ sudo apt-get install tesseract-ocr tesseract-ocr-deu tesseract-ocr-eng tesseract-ocr-fra tesseract-ita

The installation location might be different like /usr/share/tesseract-ocr depending on operating system. To use the tesseract files, you have to add the following system variable:

	$ export TESSDATA_PREFIX=/usr/share/tesseract-ocr/
	
if you want to add it permanently, add the same command at the end of ~/.profile

Now clone the repository, change to the development-branch and install everything with gradle clean build. Gradle will download and install all necessary  dependencies.

	$ git clone https://github.com/Audiveris/audiveris.git
	$ git checkout .
	$ git checkout developement
	$ cd audiveris
	$ ./gradlew clean build 

	$ cd build/distributions
Unzip the directory inside and start the (gui-) programm with:  

	$ ./bin/Audiveris

Alternatively you can start Audiveris with

	$ audiveris/gradlew run 
	
We will use the bash interface.





## crop music notes

So far I only tested [crop-select-js](https://github.com/zara-4/crop-select-js)(GNU 3.0, 2017), which is the newest and - in my opinion- the easiest to handle.



(So far) It only works with png or jpeg, but that's not a huge problem, since svg can be converted easily to png.

- convert SVG to png konvertieren
https://developer-blog.net/svg-zu-png-konvertieren-in-php/
- another project, licence not sur ~ 2013, but very small
http://odyniec.net/projects/imgareaselect/
- also very easy, also ~2013
http://deepliquid.com/content/Jcrop.html


## note correction

## documentation


so far consists of google-drive document + presentation 