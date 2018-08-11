# Latest Ubuntu with Java 8, Apache2, PHP, tesseract, audiveris
# Build image with:  $	docker build -t musicmatcher .
# Run image with:  $ docker run  -p 8000:80 -v /home/tobias/mygits/musicmatcher/src/:/var/www/html/ musicmatcher
# use -d flag to run in background
# stop with $ sudo docker stop $(docker ps -a -q) 

FROM ubuntu:latest
LABEL authors="Tobias Wenzel, Pavel Brodianskyi"



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


COPY ../src/ /var/www/html
#COPY ../res/ /var/www/html/res
#COPY ../out /var/www/html

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
ENV TESSDATA_PREFIX=/usr/share/tesseract-ocr/4.00/





# -------------------------------------------------------------
## crop notes
# -------------------------------------------------------------
RUN apt-get install -y libpng-dev

# -------------------------------------------------------------
# grant permission for file editing
# -------------------------------------------------------------


RUN chown -R www-data:www-data /var/www/html/
RUN chown -R www-data:www-data /var/www/html/out
RUN chown -R www-data:www-data /var/www/html/res

RUN chmod -R 770 /var/www/html/out



# -------------------------------------------------------------
# postgres-section (for testing)
# -------------------------------------------------------------
# Add the PostgreSQL PGP key to verify their Debian packages.
# It should be the same key as https://www.postgresql.org/media/keys/ACCC4CF8.asc
RUN apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys B97B0AFCAA1A47F044F244A07FCC7D46ACCC4CF8

# Add PostgreSQL's repository. It contains the most recent stable release
#     of PostgreSQL, ``9.3``.
RUN echo "deb http://apt.postgresql.org/pub/repos/apt/ precise-pgdg main" > /etc/apt/sources.list.d/pgdg.list

# Install ``python-software-properties``, ``software-properties-common`` and PostgreSQL 9.3
#  There are some warnings (in red) that show up during the build. You can hide
#  them by prefixing each apt-get statement with DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y  software-properties-common postgresql-9.3 postgresql-client-9.3 postgresql-contrib-9.3

# Note: The official Debian and Ubuntu images automatically ``apt-get clean``
# after each ``apt-get``

# Run the rest of the commands as the ``postgres`` user created by the ``postgres-9.3`` package when it was ``apt-get installed``
USER postgres

# Create a PostgreSQL role named ``docker`` with ``docker`` as the password and
# then create a database `docker` owned by the ``docker`` role.
# Note: here we use ``&&\`` to run commands one after the other - the ``\``
#       allows the RUN command to span multiple lines.
RUN    /etc/init.d/postgresql start &&\
    psql --command "CREATE USER docker WITH SUPERUSER PASSWORD 'docker';" &&\
    createdb -O docker docker

# Adjust PostgreSQL configuration so that remote connections to the
# database are possible.
RUN echo "host all  all    0.0.0.0/0  md5" >> /etc/postgresql/9.3/main/pg_hba.conf

# And add ``listen_addresses`` to ``/etc/postgresql/9.3/main/postgresql.conf``
RUN echo "listen_addresses='*'" >> /etc/postgresql/9.3/main/postgresql.conf

# Expose the PostgreSQL port
EXPOSE 5433

# Add VOLUMEs to allow backup of config, logs and databases
VOLUME  ["/etc/postgresql", "/var/log/postgresql", "/var/lib/postgresql"]

# Set the default command to run when starting the container
CMD ["/usr/lib/postgresql/9.3/bin/postgres", "-D", "/var/lib/postgresql/9.3/main", "-c", "config_file=/etc/postgresql/9.3/main/postgresql.conf"]

# -------------------------------------------------------------
## Install Audiveris & it's dependencies
# -------------------------------------------------------------
USER root

RUN apt-get install git -y

## the cloning takes a lot of time.
RUN git clone https://github.com/Audiveris/audiveris.git 
RUN cd audiveris && \
 git checkout development && \
 export TESSDATA_PREFIX=/usr/share/tesseract-ocr/4.00/ && \
  ./gradlew clean build 

## move compiled program 
RUN tar -xf /audiveris/build/distributions/Audiveris.tar -C /home

# this is necessesaray to run apache2

# not sure if we need this
RUN apt-get install sudo
RUN adduser www-data sudo
RUN echo 'www-data ALL=(user) NOPASSWD: /home/docker/Audiveris/bin/Audiveris' >> /etc/sudoers
RUN chown www-data:www-data -R /home/Audiveris


CMD apachectl -D FOREGROUND
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# grant port access
EXPOSE 80



