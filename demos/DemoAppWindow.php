<?php declare(strict_types=1);

use Tkui\Application;
use Tkui\DotEnv;
use Tkui\Image;
use Tkui\TclTk\TkAppFactory;
use Tkui\Windows\MainWindow;

require_once dirname(__DIR__) . '/vendor/autoload.php';

class DemoAppWindow extends MainWindow
{
    protected Application $app;
    private string $imageDir;

    public function __construct(string $title)
    {
        $factory = new TkAppFactory();
        $this->app = $factory->createFromEnvironment(DotEnv::create(dirname(__DIR__)));
        parent::__construct($this->app, $title);
        $this->imageDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'icons' . DIRECTORY_SEPARATOR;
    }

    public function run(): void
    {
        $this->app->run();
    }

    protected function loadImage(string $filename): Image
    {
        return $this->app->getImageFactory()->createFromFile($this->imageDir . $filename);
    }
}