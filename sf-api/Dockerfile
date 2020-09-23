ARG COMPOSER_VERSION=1.10.13
ARG PHP_VERSION=7.4

FROM composer:${COMPOSER_VERSION}
FROM php:${PHP_VERSION}-fpm-alpine

RUN apk add --no-cache \
		acl \
		fcgi \
		file \
		gettext \
		git \
	;

RUN set -xe \
	&& apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		icu-dev \
		postgresql-dev \
		libzip-dev \
		unzip \
        zlib-dev \
        libxml2-dev \
        rabbitmq-c-dev \
	&& docker-php-ext-install -j$(nproc) \
		intl \
		pdo_pgsql \
		zip \
		bcmath \
		sockets \
	&& pecl install \
		apcu-5.1.18 \
		xdebug-2.9.2 \
		amqp \
	&& docker-php-ext-enable amqp \
	&& docker-php-ext-enable --ini-name 20-apcu.ini apcu \
	&& docker-php-ext-enable --ini-name 05-opcache.ini opcache \
	&& docker-php-ext-enable --ini-name xdebug.ini xdebug \
	&& runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)" \
	&& apk add --no-cache --virtual .php-phpexts-rundeps $runDeps \
	&& apk del .build-deps \
    && { \
       echo "xdebug.remote_enable=On"; \
       echo "xdebug.remote_autostart=Off"; \
    }  >> /usr/local/etc/php/conf.d/xdebug.ini

COPY --from=0 /usr/bin/composer /usr/bin/composer
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

WORKDIR /app/sf-api

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER 1
# Install Symfony Flex globally & Prestissimo to speed up download of Composer packages (parallelized prefetching)
RUN set -eux; \
    composer global require "hirak/prestissimo:^0.3" "symfony/flex" --prefer-dist --no-progress --no-suggest --classmap-authoritative; \
    composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"

ARG APP_ENV=dev

# Prevent the reinstallation of vendors at every changes in the source code
COPY composer.json composer.lock symfony.lock ./
RUN set -eux; \
	composer install --prefer-dist --no-dev --no-scripts --no-progress --no-suggest; \
	composer clear-cache

COPY . ./

RUN mkdir -p var/cache var/logs var/sessions \
	&& composer dump-autoload --classmap-authoritative --no-dev \
	&& chown -R www-data var

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]