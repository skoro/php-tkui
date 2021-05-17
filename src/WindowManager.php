<?php declare(strict_types=1);

namespace TclTk;

use TclTk\Windows\Window;

/**
 * The application window manager.
 */
interface WindowManager
{
    /**
     * Sets the window title.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M63
     */
    public function setTitle(Window $window, string $title): void;

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M62
     */
    public function setState(Window $window, string $state): void;

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M62
     */
    public function getState(Window $window): string;

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M47
     */
    public function iconify(Window $window): void;

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M38
     */
    public function deiconify(Window $window): void;
}