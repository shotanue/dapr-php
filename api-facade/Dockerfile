FROM php:7.3-cli-alpine AS base-image

# install php extensions
RUN apk --update --no-cache add libzip-dev && docker-php-ext-install zip

# install composer
ENV COMPOSER_HOME /composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV PATH /composer/vendor/bin:$PATH

COPY --from=composer:1.9.1 /usr/bin/composer /usr/bin/composer

WORKDIR /app

FROM base-image AS composer

ENTRYPOINT ["composer"]
CMD [""]

FROM base-image AS app

EXPOSE 8080
ENTRYPOINT ["/app/rr"]
CMD ["serve", "-v", "-d"]