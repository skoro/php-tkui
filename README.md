<p align="center">
    <img src="logo.png" width="280" height="160">
</p>

## php-gui

`php-gui` allows you to build desktop ui applications with PHP only. It leverages [FFI](https://www.php.net/manual/en/book.ffi) extension and [Tcl/Tk](https://www.tcl.tk) for that, thus you don't need to compile or install any external extensions.

<p align="center"><img src="screen-demo-buttons-win.png"></p>

### Requirements

* PHP >= 7.4
* `ffi` extension must be enabled
* Tcl/Tk >= 8.6

### Getting started

Make sure that Tcl/Tk is installed in your OS. For Debian/Ubuntu based distros you may install it with `apt`:
```sh
sudo apt install tcl tk
```

Clone this repository and try out demos:
```sh
git clone https://github.com/skoro/php-gui.git php-gui
cd php-gui
php demos/buttons.php
```

### Options

You may enable some application features like:
- debug mode
- appearance

Copy the provided `.env.example` into `.env` and customize the options.

Debug mode allows you to find out which commands execute by Tcl engine. To enable
the debug mode set:
```
DEBUG=true
DEBUG_LOG=php://stdout
```
All the debug messages will go to the console. You may specify a file name instead of console.

To change the application appearance comment out `THEME` option and set one of:
_clam_, _alt_, _default_, _vista_ (only available on Windows OS).

### Windows

You need to install Tcl/Tk binary distribution and set path to dlls
in `.env` file like this:

```
WINDOWS_LIB_TCL=c:\\tcltk\\bin\\tcl86t.dll
WINDOWS_LIB_TK=c:\\tcltk\\bin\\tk86t.dll
```
