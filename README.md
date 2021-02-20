## php-tk

`php-tk` allows you to build desktop ui applications with only php. It leverages [FFI](https://www.php.net/manual/en/book.ffi) and [Tcl/Tk](https://www.tcl.tk) for that, thus you don't need to compile any extensions.

### Requirements

* PHP >= 7.4
* `ffi` extension must be enabled
* Tcl/Tk >= 8.6

### Getting started

Make sure that Tcl/Tk is installed in your OS. For Debian/Ubuntu based distros you can install it with `apt`:
```sh
sudo apt install tcl tk
```

Clone this repository and try demos:
```sh
git clone https://github.com/skoro/php-tk.git php-tk
cd php-tk/demos
php buttons.php
```
