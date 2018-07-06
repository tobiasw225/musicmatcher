# Music Matcher

## what we are

## installation
First clone the repository to your computer and copy it to the directory of your choice. First you'll have to install apache2 for PHP-actions.

	$ 	sudo apt-get install apache2 php-7.2 php7.2-gd 
	
If you want to move the files to [/var/www/html/]() make sure you have writing permissions. Otherwise you'll need to setup a docker container.
	
	$ git clone git@github.com:tobiasw225/musicmatcher.git
	$ sudo chown -R yourusername:www-data /folder/used/by/EE


## docker-container
we best set up a simple php-server as a docker-container.


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