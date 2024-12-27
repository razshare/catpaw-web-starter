# Catpaw Starter

First off, configure your project.

```bash
make configure
```

> [!NOTE]
> If you don't have [Bun](https://bun.sh) installed in your path, this step will install it for you.

Then load your dependencies.

```bash
make load
```

> [!NOTE]
> You can run `make clean` at any time in order to clean created directories, downloaded dependencies and so on.\
> Running `make clean` will __not__ uninstall [Bun](https://bun.sh).

# Watch Mode

Enter Watch Mode with

```bash
make watch
```

This mode will run the Vite server and your server with [XDebug](https://xdebug.org) enabled.\
Each time your make any change to your server source code, the server will restart automatically.

> [!NOTE]
> By default "server source code" means the "src/server" directory.\
> You can change this configuration in your [devkwm file](./devkwm).

> [!NOTE]
> See [section Debugging with VSCode](#debugging-with-vscode)

# Development Mode

Enter Watch Mode with

```bash
make dev
```

This mode will build the Svelte application and run your server with [XDebug](https://xdebug.org) enabled.\
Unlike [Watch Mode](#watch-mode), your server will not restart when you make changes to your code.\
This mode is useful for quick debugging.

# Production Mode

Enter Production Mode with

```bash
make start
```

This will build your client bundle and run your server without any debuggers or any other extra overhead.

# Build

It is possible, but no required, to bundle your program into a single `.phar` file with

```bash
make build
```

The building process can be configured inside the `build.ini` file.

After building your application, you can simply run it using

```
php out/app.phar
```

The resulting `.phar` will include the following directories

- `src/server`
- `vendor`
- `statics`
- `.build-cache` (created at build time)

It's a portable bundle, you just need to make
sure php is installed on whatever machine you're trying to run it on.

# Debugging with VSCode

Install xdebug

```php
apt install php8.3-xdebug
```

Configure your `.vscode/launch.json`

```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen",
      "type": "php",
      "request": "launch",
      "port": 9003
    }
  ]
}
```

Start debugging.
