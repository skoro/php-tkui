<?php declare(strict_types=1);

namespace TclTk\Windows;

use TclTk\Widgets\Container;
use TclTk\WindowManager;

/**
 * The application window.
 */
interface Window extends Container
{
    /**
     * The window states.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M62
     */
    const STATE_NORMAL = 'normal';
    const STATE_ICONIC = 'iconic';
    const STATE_WITHDRAWN = 'withdrawn';
    const STATE_ICON = 'icon';
    const STATE_ZOOMED = 'zoomed';

    public function getWindowManager(): WindowManager;
}