FROM ubuntu
MAINTAINER Vainius Mykolaitis <vmykolaitis1@gmail.com>

ENV TZ=Europe/Vilnius
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apt-get update -y
RUN apt-get upgrade -y
#RUN apt-get install -y apache2
#RUN apt-get install -y php
#RUN apt-get install -y mysql-server

RUN rm -rf /var/www/html/*
ADD index /var/www/html

#RUN chown -R www-data:www-data /var/www
#ENV APACHE_RUN_USER www-data
#ENV APACHE_RUN_GROUP www-data
#ENV APACHE_LOG_DIR /var/log/apache2

EXPOSE 80

