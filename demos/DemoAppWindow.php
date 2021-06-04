<?php declare(strict_types=1);

use PhpGui\Application;
use PhpGui\DotEnv;
use PhpGui\TclTk\TkAppFactory;
use PhpGui\Windows\MainWindow;

require_once dirname(__DIR__) . '/vendor/autoload.php';

class DemoAppWindow extends MainWindow
{
    protected Application $app;

    public function __construct(string $title)
    {
        $factory = new TkAppFactory();
        $this->app = $factory->createFromEnvironment(DotEnv::create(dirname(__DIR__)));
        parent::__construct($this->app, $title);
    }

    public function run(): void
    {
        $this->app->run();
    }
}