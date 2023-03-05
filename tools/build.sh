#!/bin/bash

if [ ! -f .env ]; then
    echo ".env is required, please create .env file to proceed"
    exit 1
fi

. .env

[ ! -d $WORK_DIR ] && mkdir $WORK_DIR

TCL_WORK_DIR=$WORK_DIR/tcl
TK_WORK_DIR=$WORK_DIR/tk
ROOT_DIR=$(pwd)

case "$(uname -o)" in
    Msys)
        OS="win"
        ;;
    Linux)
        OS="unix"
        ;;
    *)
        echo "Unsupported os"
        exit 1
        ;;
esac

if [ ! -d $TCL_WORK_DIR ]; then
    git clone $TCL_REPO $TCL_WORK_DIR
fi

if [ ! -d $TK_WORK_DIR ]; then
    git clone $TK_REPO $TK_WORK_DIR
fi

build_tcl() {
    echo "Building Tcl ..."
    cd $TCL_WORK_DIR
    git checkout main
    git fetch
    git checkout $TCL_TK_TAG
    cd $OS
    [ -f Makefile ] && make distclean
    ./configure $TCL_CONFIGURE --prefix=$INSTALL_DIR
    make -j$(nproc)
    make install
}

build_tk() {
    echo "Building Tk ..."
    cd $TK_WORK_DIR
    git checkout main
    git fetch
    git checkout $TCL_TK_TAG
    cd $OS
    [ -f Makefile ] && make distclean
    ./configure $TK_CONFIGURE --prefix=$INSTALL_DIR
    make -j$(nproc)
    make install
}

#rm -rf $INSTALL_DIR
#cd $ROOT_DIR
#build_tcl
cd $ROOT_DIR
build_tk
cd $INSTALL_DIR && zip -r $ROOT_DIR/tcltk.zip * -x include/* include/ include/X11/ include/X11/* lib/tk8.6/demos/ lib/tk8.6/demos/* lib/tk8.6/demos/images/ lib/tk8.6/demos/images/*
