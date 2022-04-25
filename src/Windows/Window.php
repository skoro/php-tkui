<?php declare(strict_types=1);

namespace Tkui\Windows;

use Tkui\Widgets\Container;
use Tkui\Widgets\Menu\Menu;
use Tkui\WindowManager;

/**
 * The application window.
 */
interface Window extends Container, ShowAsModal
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

    /**
     * Set the window menu.
     *
     * Will be appeared as a menu bar in top of the window.
     */
    public function setMenu(Menu $menu): self;
}