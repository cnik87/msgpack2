#!/usr/bin/env bash

if [[ -z "$PHP_RUNTIME" ]] ; then
    PHP_RUNTIME='php:5.6-cli'
fi

RUN_CMDS=''

if [[ $PHP_RUNTIME == php* ]]; then
    RUN_CMDS="$RUN_CMDS && \\\\\n    docker-php-ext-install zip"
fi

if [[ ! -z "$PHP_COVERAGE" ]]; then
    RUN_CMDS="$RUN_CMDS && \\\\\n    git clone https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug"
    RUN_CMDS="$RUN_CMDS && \\\\\n    docker-php-ext-install xdebug"
fi

echo -e "
FROM $PHP_RUNTIME

RUN apt-get update && \\
    apt-get install -y git curl zlib1g-dev${RUN_CMDS} && \\
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \\
    composer global require 'phpunit/phpunit:^4.8|^5.0'

ENV PATH ~/.composer/vendor/bin:\$PATH

CMD if [ ! -f composer.lock ]; then composer install; fi && ~/.composer/vendor/bin/phpunit${PHP_COVERAGE:+ }$PHP_COVERAGE
"