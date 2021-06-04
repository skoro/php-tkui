<?php declare(strict_types=1);

namespace PhpGui;

/**
 * The application factory.
 */
interface AppFactory
{
    /**
     * Creates a new application instance.
     */
    public function create(Environment $env): Application;
}