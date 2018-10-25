FROM ubuntu

ENV TZ=Europe/Vilnius
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apt-get update -y
RUN apt-get upgrade -y
RUN apt-get install -y apache2
RUN apt-get install -y php7.2
RUN apt-get install -y mysql-server
RUN apt-get install -y php-pear php7.2-curl php7.2-dev php7.2-gd php7.2-mbstring php7.2-zip php7.2-mysql php7.2-xml
RUN apt-get install -y git
RUN apt-get install -y composer

WORKDIR /var/www/html
RUN git clone https://github.com/wmx11/hyphenation.git .
RUN composer update
COPY config/php.ini /etc/php/7.2/apache2/
COPY config/000-default.conf /etc/apache2/sites-available/
COPY config/web.conf /etc/apache2/sites-available/
COPY config/Config.php /var/www/html/Inc/Resources/

RUN a2ensite web
RUN /etc/init.d/apache2 restart

EXPOSE 80

ENTRYPOINT service apache2 start &&\
/bin/bash