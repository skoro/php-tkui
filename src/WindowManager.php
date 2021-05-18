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
     */
    public function setTitle(string $title): void;

    /**
     * Sets the window state: normal, iconic, withdrawn, icon, zoomed.
     * But depends on underlying window manager.
     */
    public function setState(string $state): void;

    /**
     * Gets the window state.
     *
     * @see WindowManager::setState()
     */
    public function getState(): string;

    /**
     * Arrange for window to be iconified.
     */
    public function iconify(): void;

    /**
     * Arrange for window to be displayed in normal (non-iconified) form.
     */
    public function deiconify(): void;

    /**
     * Sets the maximum dimensions for the window.
     */
    public function setMaxSize(int $width, int $height): void;

    /**
     * Gets the maximum dimensions for the window.
     *
     * @return array The list of two width and height values.
     */
    public function getMaxSize(): array;

    /**
     * Sets the minimum dimensions for the window.
     */
    public function setMinSize(int $width, int $height): void;

    /**
     * Gets the minimum dimensions for the window.
     *
     * @return array The list of two width and height values.
     */
    public function getMinSize(): array;
}