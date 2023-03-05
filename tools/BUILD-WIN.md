Building Tcl and Tk for Windows with MSYS2
==========================================

1. Get MSYS2: https://msys2.github.io/
2. Open MSYS2 MINGW64
3. Install all the required build dependencies:
    ```sh
    pacman -Syuu make mingw-w64-i686-gcc tar wget zip unzip
    ```
4. `./build.sh`

