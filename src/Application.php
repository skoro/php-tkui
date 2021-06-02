<?php declare(strict_types=1);

namespace PhpGui;

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
}