# Catpaw Starter

You can run your program in one of three modes.

# Development Mode

Enter Development Mode with

```bash
make dev
```

This mode will run your program with [XDebug](https://xdebug.org) enabled.

> [!NOTE]
> See [section Debugging with VSCode](#debugging-with-vscode)


# Watch Mode

Enter Watch Mode with

```bash
make watch
```

This mode will run your program with [XDebug](https://xdebug.org) enabled and 
it will restart your program every time you make a change to your source code.

> [!NOTE]
> See [section Debugging with VSCode](#debugging-with-vscode)

> [!NOTE]
> By default "source code" means the "src" directory.\
> You can change this configuration in your [makefile](./makefile), see section `watch`, parameter `resources`.

# Production Mode

Enter Production Mode with

```bash
make start
```

It's just as it sounds, run your program directly.\
No debuggers, not extra overhead.

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

- `src`
- `vendor`
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
