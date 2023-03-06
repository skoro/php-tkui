# Tcl/Tk build distribution makefile.
#
# By default, it builds tcl and tk for Windows but the build target can be
# overrided with OS variable, for example, Linux:
# OS=unix make dist
#
# 

TCL_REPO=https://github.com/tcltk/tcl
TK_REPO=https://github.com/tcltk/tk
TCL_TK_TAG=core-8-6-13

OS=win
WORK_DIR=./.build
INSTALL_DIR=/tmp/tcltk

TCL_SOURCE_DIR=$(WORK_DIR)/tcl-$(TCL_TK_TAG)
TCL_RELEASE_DIST=$(TCL_REPO)/archive/refs/tags/$(TCL_TK_TAG).tar.gz
TCL_SOURCE_DIST=$(WORK_DIR)/tcl-$(TCL_TK_TAG).tar.gz
TCL_CONFIGURE=--enable-threads --enable-64bit --prefix=$(INSTALL_DIR)

TK_SOURCE_DIR=$(WORK_DIR)/tk-$(TCL_TK_TAG)
TK_RELEASE_DIST=$(TK_REPO)/archive/refs/tags/$(TCL_TK_TAG).tar.gz
TK_SOURCE_DIST=$(WORK_DIR)/tk-$(TCL_TK_TAG).tar.gz
TK_CONFIGURE=--enable-threads --enable-64bit --enable-embedded-manifest --with-tcl=../../tcl-$(TCL_TK_TAG)/$(OS) --prefix=$(INSTALL_DIR)

##############################################################################################	

help:
	@echo "Usage:"
	@echo "	dist		Build Tcl and Tk distribution"
	@echo "	build-tcl	Build Tcl only"
	@echo "	build-tk	Build Tk only"
	@echo "	clean		Remove build and installation directories"

.PHONY: dist clean build-tcl build-tk

$(WORK_DIR):
	mkdir -p $(WORK_DIR)

dist: build-tcl build-tk
	cd $(INSTALL_DIR) \
		&& zip -r /tmp/tcltk.zip . -x \
			include/* include/ include/X11/ include/X11/* \
			lib/tk8.6/demos lib/tk8.6/demos/* \
			lib/tk8.6/demos/images/ lib/tk8.6/demos/images/* \
			lib/libtcl86.dll.a lib/libtclstub86.a \
			lib/libtk86.dll.a lib/libtkstub86.a \
			lib/tclConfig.sh lib/tclooConfig.sh lib/tkConfig.sh
	[ -f /tmp/tcltk.zip ] && mv /tmp/tcltk.zip $(WORK_DIR)

##############################################################################################	

build-tcl: $(WORK_DIR) $(TCL_SOURCE_DIR)
	cd $(TCL_SOURCE_DIR)/$(OS) \
		&& ./configure $(TCL_CONFIGURE) \
		&& make -j`nproc` \
		&& make install

$(TCL_SOURCE_DIR): $(TCL_SOURCE_DIST)
	tar -zxf $(TCL_SOURCE_DIST) -C $(WORK_DIR)

$(TCL_SOURCE_DIST):
	wget $(TCL_RELEASE_DIST) -O $(TCL_SOURCE_DIST)

##############################################################################################	

build-tk: $(WORK_DIR) $(TK_SOURCE_DIR)
	cd $(TK_SOURCE_DIR)/$(OS) \
		&& ./configure $(TK_CONFIGURE) \
		&& make -j`nproc` \
		&& make install

$(TK_SOURCE_DIR): $(TK_SOURCE_DIST)
	tar -zxf $(TK_SOURCE_DIST) -C $(WORK_DIR)

$(TK_SOURCE_DIST):
	wget $(TK_RELEASE_DIST) -O $(TK_SOURCE_DIST)

##############################################################################################	

clean:
	rm -rf $(WORK_DIR) $(INSTALL_DIR)
