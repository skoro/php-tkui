<?php declare(strict_types=1);

namespace TclTk;

/**
 * Application.
 */
interface Application extends Evaluator, Bindings
{
    /**
     * Process the application events.
     */
    public function run();

    /**
     * Get the theme manager.
     */
    public function getThemeManager(): ThemeManager;

    /**
     * The application window manager.
     */
    public function getWindowManager(): WindowManager;
}