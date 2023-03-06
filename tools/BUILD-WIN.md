Building Tcl and Tk for Windows with MSYS2
==========================================

1. Get MSYS2: https://www.msys2.org/
2. Open `MSYS2 UCRT64`
3. Install all the required build dependencies:
    ```sh
    pacman -Syuu
    pacman -S mingw-w64-ucrt-x86_64-gcc make git zip wget
    ```
4. cd into the project `tools` directory and run `OS=win make dist`
5. `tcltk.zip` will be created in `.build` directory

