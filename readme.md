# Music Matcher


use 

	$ git clone git@github.com:tobiasw225/musicmatcher.git
to clone the repository to the folder of your choice.	

## Who we are and what we do:
@todo who we are

For many years, music has been transferred from generation to generation by two traditions: aural sharing and in the form of written documents, typically known as a musical scores. Many of these scores are available in the form of unpublished handwriting. To correct and edit these sheets of music, some form of typesetting or even an instrument that can automatically match the symbols images and create new scores can be used. As there are already existing projects in which documents are digitized and corrected, e.g. trove, sheet music represents yet another form to be put into digital format. Stains, different styles and other artifacts make a suitable *OCR* difficult to achieve. Interested citizen scientists should correct these mistakes. The result could be make public and the page or optionally used for further projects and education.

The **Musikalisches Wochenblatt** - Organ für Musiker und Musikfreunde (short: MWb), was a music journal in the time of the german empire. It was founded in 1870 by Oscal Paul and published until 1910 in Leipzig. Henceforward it was published by  Ernst Wilhelm Fritsch as the Neue Zeitschrift für Musik (short: NZFM). It discusses developments in music, concerts and features critics from all over Germany with a focus led on Leipzig. In this project we chose to use these documents as our research corpus because of the regional connection to our univerisity and it's rich information about the 19th  as well as the beginning of the 20th century.




## Installation
### Set up Docker-Container

The recommended way to set up the system is through docker and docker-compose, since it enables easy crossplattform development. To learn more about how to set up the docker container have a look at our [this page](docker/readme.md).


## Installation without Docker

First clone the repository to your computer and copy it to the directory of your choice. First you'll have to install apache2 for PHP-actions.

	$ 	sudo apt-get install apache2 php-7.2 php7.2-gd 
	
If you want to move the files to [/var/www/html/]() make sure you have writing permissions. Otherwise you'll need to setup a docker container.
	
	$ sudo chown -R yourusername:www-data /folder/used/by/EE

#### How to install audiveris
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



#### crop music notes

So far I only tested [crop-select-js](https://github.com/zara-4/crop-select-js)(GNU 3.0, 2017), which is the newest and - in my opinion- the easiest to handle.



(So far) It only works with png or jpeg, but that's not a huge problem, since svg can be converted easily to png.

- convert SVG to png konvertieren
https://developer-blog.net/svg-zu-png-konvertieren-in-php/
- another project, licence not sur ~ 2013, but very small
http://odyniec.net/projects/imgareaselect/
- also very easy, also ~2013
http://deepliquid.com/content/Jcrop.html


#### note correction

# Documentation

For further documentation have a look at the [documenation](doku/readme.md)-page.
