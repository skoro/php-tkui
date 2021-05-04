<?php declare(strict_types=1);

use TclTk\Application;
use TclTk\TkApplication;
use TclTk\Windows\MainWindow;

require_once dirname(__DIR__) . '/vendor/autoload.php';

class DemoAppWindow extends MainWindow
{
    protected Application $app;

    public function __construct(string $title)
    {
        $this->app = TkApplication::create();
        parent::__construct($this->app, $title);        
    }

    public function run(): void
    {
        $this->app->run();
    }
}