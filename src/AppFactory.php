<?php declare(strict_types=1);

namespace TclTk;

/**
 * The application factory.
 */
interface AppFactory
{
    /**
     * Creates a new application instance.
     *
     * @param array $config The list of parameters to override default ones.
     */
    public static function create(array $config = []): Application;

    /**
     * The application environment.
     */
    public function getEnvironment(): Environment;
}