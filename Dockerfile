FROM php:7.0-apache

# @todo copy out, res not inside src
COPY src/ /var/www/html

RUN apt-get update 
RUN apt-get upgrade -y
RUN apt-get autoremove -y

## install audiveris & it's dependencies

## still a bug here
## -> probably because of differences between oracle + linux

#RUN add-apt-repository ppa:webupd8team/java -y

#RUN apt-get install openjdk-8-jre -y
#RUN apt-get update
#RUN apt-get install -y oracle-java8-installer
#RUN apt-get install openjdk-8-jdk -y



RUN apt-get install libfreetype6-dev -y
RUN apt-get install tesseract-ocr tesseract-ocr-deu tesseract-ocr-eng tesseract-ocr-fra  -y

RUN export TESSDATA_PREFIX=/usr/share/tesseract-ocr/

## not test yet
RUN apt-get install git -y
# RUN cd backend/ && git clone https://github.com/Audiveris/audiveris.git
# RUN git checkout .
# RUN git checkout developement
# RUN cd audiveris &&  audiveris/gradlew clean build 
##... set projet variable to executable


## to crop notes

RUN apt-get install -y libpng-dev
RUN docker-php-ext-install gd

# grant permission for file editing
RUN chown www-data:www-data /var/www/html/
RUN chown www-data:www-data out/
EXPOSE 80



