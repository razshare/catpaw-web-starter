FROM libevent
RUN apt-get update -y
RUN apt-get install libyaml-dev -y
RUN pecl install yaml && echo "extension=yaml.so" > /usr/local/etc/php/conf.d/ext-yaml.ini && docker-php-ext-enable yaml
COPY app.phar app.phar
ENTRYPOINT ["php", "-dopcache.enable_cli=1", "-dopcache.jit_buffer_size=100M", "app.phar"]