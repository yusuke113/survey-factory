FROM php:8.1-fpm

ENV TZ Asia/Tokyo

RUN apt-get update && \
	apt-get install -y git unzip libzip-dev libicu-dev libonig-dev && \
	docker-php-ext-install intl pdo_mysql zip bcmath
		
COPY ./docker/api/php.ini /usr/local/etc/php/php.ini

COPY ./docker/api/php-fpm.conf /etc/php81/php-fpm.d/www.conf

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt update && apt install nodejs

WORKDIR /api/src
