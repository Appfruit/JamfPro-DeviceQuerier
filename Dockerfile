FROM php:apache
MAINTAINER Fabian Hartmann <fhartmann@appfruit.ch>

ENV API_URL='https://instance.jamfcloud.com'
ENV API_User='api-user'
ENV API_Password='theverrysecretpassword'

ADD ./querier.php /var/www/html/index.php

# configure php.ini and disable version
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN sed -i -e 's/^expose_php\s*=.*/expose_php = Off/' "$PHP_INI_DIR/php.ini"

# disable apache server verions
RUN echo "ServerTokens Prod\n" >> /etc/apache2/apache2.conf
RUN echo "ServerSignature Off\n" >> /etc/apache2/apache2.conf
