FROM php:7.3-cli-alpine AS base-image

RUN apk --update --no-cache add wget bash

# install dapr-cli
RUN wget -q https://raw.githubusercontent.com/dapr/cli/master/install/install.sh -O - | /bin/bash

# dapr-cli requires daprd
# ref. https://github.com/dapr/cli/blob/d585612185a4a525c05fb62b86e288ccad510006/pkg/standalone/standalone.go#L265
RUN curl -Lo /tmp/daprd.tar.gz \
      https://github.com/dapr/dapr/releases/download/v0.3.0/daprd_linux_amd64.tar.gz \
  && tar xzvf /tmp/daprd.tar.gz -C /usr/local/bin

# install php extensions
RUN apk --update --no-cache add libzip-dev && docker-php-ext-install zip

WORKDIR /app

FROM base-image AS composer

# install composer
ENV COMPOSER_HOME /composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV PATH /composer/vendor/bin:$PATH

COPY --from=composer:1.9.1 /usr/bin/composer /usr/bin/composer

ENTRYPOINT ["composer"]
CMD [""]

FROM base-image AS app

EXPOSE 8080
ENTRYPOINT [\
  "dapr",\
  "run",\
  "--app-port",\
  "8080",\
  "sh",\
  "invoke-service.sh"\
]
CMD [""]