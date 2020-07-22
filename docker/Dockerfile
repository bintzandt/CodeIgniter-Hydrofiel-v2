FROM php:7.4.1-apache-buster
RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++ libmagickwand-dev imagemagick
RUN pecl install imagick
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl pdo pdo_mysql mysqli
RUN docker-php-ext-enable imagick

RUN apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git &&\
    rm -rf /var/lib/apt/lists/*
RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
RUN go get github.com/mailhog/mhsendmail
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail
RUN echo 'sendmail_path = /usr/bin/mhsendmail --smtp-addr mail:1025' > /usr/local/etc/php/php.ini


# Enable mod_rewrite
RUN a2enmod rewrite

# Enable headers
RUN a2enmod headers

# Restart Apache
RUN service apache2 restart
