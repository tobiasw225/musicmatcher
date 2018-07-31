# Latest Ubuntu with Java 8, Apache2, PHP, tesseract, audiveris
# Build image with:  $	docker build -t musicmatcher .
# Run image with:  $ docker run  -p 8000:80 -v /home/tobias/mygits/musicmatcher/src/:/var/www/html/ musicmatcher
# use -d flag to run in background
# stop with $ sudo docker stop $(docker ps -a -q) 

FROM ubuntu:latest
LABEL authors="Tobias Wenzel, Pavel Brodianskyi & Conal Hanamy"


## install java 8 and it's dependecies

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


## install the webserver & php
RUN  apt-get install apache2 php7.2 php7.2-gd -y


# @todo copy out, res not inside src
COPY src/ /var/www/html

RUN apt-get update 
RUN apt-get upgrade -y
RUN apt-get autoremove -y

## Install Audiveris & it's dependencies

## install tesseract
RUN apt-get install libfreetype6-dev -y
RUN apt-get install tesseract-ocr tesseract-ocr-deu tesseract-ocr-eng tesseract-ocr-fra  -y
RUN export TESSDATA_PREFIX=/usr/share/tesseract-ocr/

## not test yet. 
RUN apt-get install git -y
# RUN cd backend/ && git clone https://github.com/Audiveris/audiveris.git
# RUN git checkout .
# RUN git checkout developement
# RUN cd audiveris &&  audiveris/gradlew clean build 
##... set projet variable to executable


## to crop notes these packages are needed.

RUN apt-get install -y libpng-dev
#RUN docker-php-ext-install gd

# grant permission for file editing
RUN chown www-data:www-data /var/www/html/
RUN chown www-data:www-data /var/www/html/out/
CMD apachectl -D FOREGROUND

EXPOSE 80



