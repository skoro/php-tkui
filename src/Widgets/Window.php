<?php declare(strict_types=1);

namespace TclTk\Widgets;

use InvalidArgumentException;
use TclTk\App;
use TclTk\Options;

class Window implements TkWidget
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function path(): string
    {
        return '.';
    }

    public function id(): string
    {
        return '.';
    }

    public function exec(string $command, $args, Options $options): string
    {
        if (is_array($args)) {
            $args = implode(' ', $args);
        }
        if (!is_string($args)) {
            throw new InvalidArgumentException('args must be an array or string.');
        }
        $this->app->tk()->interp()->eval($command . ' ' . $args . ' ' . $options);
        return '';
    }
}