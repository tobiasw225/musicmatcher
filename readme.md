# Music Matcher
$ indicates bash-comma

## what we are

## installation
First clone the repository to your computer and copy it to the directory of your choice. First you'll have to install apache2 for PHP-actions.

	$ 	sudo apt-get install apache2 php-7.2 php7.2-gd 
	
If you want to move the files to [/var/www/html/]() make sure you have writing permissions. Otherwise you'll need to setup a docker container.
	
	$ git clone git@github.com:tobiasw225/musicmatcher.git
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



## docker-container
we best set up a simple php-server as a docker-container.

probably we don't need that much

	$ sudo chmod 0777 .
	$ sudo /etc/init.d/apache2 stop 
	$ docker build -t mockup .

change filepath

	$ docker run -p 80:80 -v ~/musicmatcher/src/:/var/www/html/ musicmatcher
access page at 
http://localhost:8080/


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