FROM php:7.4.0RC3-fpm-alpine as stage-dev
WORKDIR /app
RUN apk --update --no-cache add git
RUN docker-php-ext-install pdo_mysql
COPY --from=composer /usr/bin/composer /usr/bin/composer
CMD composer install ;  php-fpm
EXPOSE 9000

FROM nginx:alpine
WORKDIR /app
COPY --from=stage-dev /app ./
CMD ["nginx"]
EXPOSE 3000
