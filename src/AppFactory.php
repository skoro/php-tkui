<?php declare(strict_types=1);

namespace Tkui;

/**
 * The application factory.
 */
interface AppFactory
{
    /**
     * Creates a new application instance based on environment state.
     */
    public function createFromEnvironment(Environment $env): Application;

    /**
     * Creates an application with default values.
     */
    public function create(): Application;
}