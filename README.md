## php-tk

`php-tk` allows you to build desktop ui applications with PHP only. It leverages [FFI](https://www.php.net/manual/en/book.ffi) extension and [Tcl/Tk](https://www.tcl.tk) for that, thus you don't need to compile or install any external extensions.

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
git clone https://github.com/skoro/php-tk.git php-tk
cd php-tk
php demos/buttons.php
```
