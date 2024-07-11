FROM php:8.2-cli-alpine

WORKDIR /app/

# Core utilites install just for convenience during development
RUN --mount=type=cache,sharing=locked,target=/var/cache/apk/ set -eux \
  && apk add --quiet --update --no-cache \
    bash \
    make


# Easily install PHP extension in Docker containers | https://github.com/mlocati/docker-php-extension-installer
COPY --from=mlocati/php-extension-installer --link /usr/bin/install-php-extensions /usr/local/bin/install-php-extensions
RUN set -eux \
    && install-php-extensions \
        @composer-2

ENV PATH ${PATH}:/app/vendor/bin/
