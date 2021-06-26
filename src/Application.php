<?php declare(strict_types=1);

namespace PhpGui;

/**
 * The application instance.
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
     * Get the font manager.
     */
    public function getFontManager(): FontManager;

    /**
     * Stop the application and free up resources.
     */
    public function quit();
}