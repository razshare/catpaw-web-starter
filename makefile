configure:
	which bun || (curl -fsSL https://bun.sh/install | bash)
	chmod +x ./devw
	chmod +x ./devkwm
	@printf "\
	name = out/app\n\
	main = src/server/main.php\n\
	libraries = src/server/lib\n\
	environment = env.ini\n\
	match = \"/(^\.\/(\.build-cache|src\/server|vendor|statics)\/.*)|(^\.\/(\.env|env\.ini|env\.yml))/\"\n\
	" > build.ini && printf "Build configuration file restored.\n"

clean:
	rm build.ini -f
	rm composer.lock -f
	rm .php-cs-fixer.cache -f
	rm .phpunit.result.cache -f
	rm out -fr
	rm statics -fr
	rm vendor -fr
	rm src/client/node_modules -fr
	rm src/client/bun.lockb -f

load:
	cd src/client && bun i
	composer update
	composer dump-autoload -o

test: vendor/bin/phpunit
	php \
	-dxdebug.mode=off \
	-dxdebug.start_with_request=no \
	vendor/bin/phpunit tests

start: build-client vendor/bin/catpaw src/server/main.php
	php \
	-dopcache.enable_cli=1 \
	-dopcache.jit_buffer_size=100M \
	vendor/bin/catpaw \
	--environment=env.ini \
	--libraries=src/server/lib \
	--main=src/server/main.php

dev: src/server/main.php vendor/bin/catpaw
	./devw

build-client: src/client/node_modules src/client/vite.config.js
	bun i && \
	bun run lint && \
	bun run build

build-server: vendor vendor/bin/catpaw-cli src/server/main.php
	test -f build.ini || make configure
	test -d out || mkdir out
	php \
	-dxdebug.mode=off \
	-dxdebug.start_with_request=no \
	-dphar.readonly=0 \
	vendor/bin/catpaw-cli \
	--build \
	--optimize

build:
	make build-client && make build-server