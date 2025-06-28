install:
	composer install
	composer dump-autoload -o
	which bun || (curl -fsSL https://bun.sh/install | bash)
	bun --bun install

update:
	composer update
	composer dump-autoload -o
	which bun || (curl -fsSL https://bun.sh/install | bash)
	bun --bun install

dev: vendor/bin/catpaw src/server/main.php
	bunx --bun vite build
	php -dxdebug.mode=debug -dxdebug.start_with_request=yes \
	vendor/bin/catpaw \
	--environment=env.ini \
	--libraries=src/lib \
	--main=src/server/main.php

watch: vendor/bin/catpaw src/server/main.php
	bunx --bun vite & \
	php -dxdebug.mode=off -dxdebug.start_with_request=no \
	vendor/bin/catpaw \
	--environment=env.ini \
	--libraries=src/lib \
	--main=src/server/main.php \
	--resources=src/server \
	--watch \
	--spawner="php -dxdebug.mode=debug -dxdebug.start_with_request=yes" & \
	wait


start: vendor/bin/catpaw src/server/main.php
	bunx --bun vite build
	php -dxdebug.mode=off -dxdebug.start_with_request=no \
	vendor/bin/catpaw \
	--environment=env.ini \
	--libraries=src/lib \
	--main=src/server/main.php

build: vendor/bin/catpaw-cli
	mkdir out -p
	test -f build.ini || make configure
	bunx --bun vite build --outDir="statics" && \
	php -dxdebug.mode=off -dxdebug.start_with_request=no \
	-dphar.readonly=0 \
	vendor/bin/catpaw-cli \
	--build \
	--optimize

clean:
	rm app.phar -f
	rm vendor -fr

configure:
	@printf "\
	name = out/catpaw\n\
	main = src/server/main.php\n\
	libraries = src/lib\n\
	environment = env.ini\n\
	match = \"/(^\.\/(\.build-cache|src|vendor|bin)\/.*)|(^\.\/(\.env|env\.ini|env\.yml))/\"\n\
	" > build.ini && printf "Build configuration file restored.\n"
	make install

fix: vendor/bin/php-cs-fixer
	php -dxdebug.mode=off -dxdebug.start_with_request=no vendor/bin/php-cs-fixer fix src/server && \
	php -dxdebug.mode=off -dxdebug.start_with_request=no vendor/bin/php-cs-fixer fix tests/server && \
	bunx --bun eslint --fix src/client && \
	bunx --bun eslint --fix tests/client

check: vendor/bin/php-cs-fixer
	php -dxdebug.mode=off -dxdebug.start_with_request=no vendor/bin/php-cs-fixer check src/server && \
	php -dxdebug.mode=off -dxdebug.start_with_request=no vendor/bin/php-cs-fixer check tests/server && \
	bunx --bun eslint src/client && \
	bunx --bun eslint tests/client

test: vendor/bin/phpunit
	php -dxdebug.mode=off -dxdebug.start_with_request=no vendor/bin/phpunit tests/server && \
	bunx --bun vitest tests/client

hooks: vendor/bin/catpaw src/server/main.php
	php -dxdebug.mode=debug -dxdebug.start_with_request=yes \
	vendor/bin/catpaw \
	--environment=env.ini \
	--libraries=src/lib \
	--main=src/server/main.php \
	--install-pre-commit="make test"