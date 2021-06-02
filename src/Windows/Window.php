<?php declare(strict_types=1);

namespace PhpGui\Windows;

use PhpGui\Widgets\Container;
use PhpGui\WindowManager;

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