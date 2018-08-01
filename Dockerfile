# Latest Ubuntu with Java 8, Apache2, PHP, tesseract, audiveris
# Build image with:  $	docker build -t musicmatcher .
# Run image with:  $ docker run  -p 8000:80 -v /home/tobias/mygits/musicmatcher/src/:/var/www/html/ musicmatcher
# use -d flag to run in background
# stop with $ sudo docker stop $(docker ps -a -q) 

FROM ubuntu:latest
LABEL authors="Tobias Wenzel, Pavel Brodianskyi & Conal Hanamy"



# -------------------------------------------------------------
## install java 8 and it's dependecies
# -------------------------------------------------------------

ENV TZ Europe/Berlin	
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y  software-properties-common && \
    add-apt-repository ppa:webupd8team/java -y && \
    apt-get update && \
    echo oracle-java7-installer shared/accepted-oracle-license-v1-1 select true | /usr/bin/debconf-set-selections && \
    apt-get install -y oracle-java8-installer && \
    apt-get clean

# -------------------------------------------------------------
## install the webserver & php
## & move project files to web-server dir
# -------------------------------------------------------------

RUN  apt-get install apache2 php7.2 php7.2-gd -y

# @todo copy out, res not inside src
COPY src/ /var/www/html

# -------------------------------------------------------------
## refresh packages & upgrade
# -------------------------------------------------------------

RUN apt-get update && \
 apt-get upgrade -y && \
 apt-get autoremove -y


# -------------------------------------------------------------
## tesseract
## ->  also needed for Audiveris
# -------------------------------------------------------------

RUN apt-get install libfreetype6-dev -y && \
 apt-get install tesseract-ocr tesseract-ocr-deu tesseract-ocr-eng tesseract-ocr-fra  -y 
## pipe into  /etc/environment
# echo "TESSDATA_PREFIX=/usr/share/tesseract-ocr/4.00/" >> /etc/environment 



# -------------------------------------------------------------
## Install Audiveris & it's dependencies
# -------------------------------------------------------------

## not test yet. 
RUN apt-get install git -y

## the cloning takes a lot of time.
RUN git clone https://github.com/Audiveris/audiveris.git 
RUN cd audiveris && \
 git checkout development && \
 export TESSDATA_PREFIX=/usr/share/tesseract-ocr/4.00/ && \
  ./gradlew clean build 

##... set projet variable to executable

# -------------------------------------------------------------
## crop notes
# -------------------------------------------------------------
RUN apt-get install -y libpng-dev

# -------------------------------------------------------------
# grant permission for file editing
# -------------------------------------------------------------

RUN chown www-data:www-data /var/www/html/
RUN chown www-data:www-data /var/www/html/out/
# this is necessesaray to run apache2
CMD apachectl -D FOREGROUND

# grant port access
EXPOSE 80



