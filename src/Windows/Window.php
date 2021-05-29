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
     * The window manager instance.
     */
    public function getWindowManager(): WindowManager;

    /**
     * Close the window.
     *
     * The window cannot be accessible anymore.
     */
    public function close(): void;
}