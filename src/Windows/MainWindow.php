<?php declare(strict_types=1);

namespace PhpGui\Windows;

use PhpGui\Application;
use PhpGui\Evaluator;
use PhpGui\Widgets\Container;
use PhpGui\Widgets\Widget;

/**
 * The main application window implementation.
 */
class MainWindow extends BaseWindow
{
    private Application $app;

    public function __construct(Application $app, string $title)
    {
        $this->app = $app;
        parent::__construct($title);
    }

    /**
     * @inheritdoc
     */
    protected function createWindow(): void
    {
        // Nothing to create. Main window is created automatically
        // during Tk initialization.
    }

    /**
     * @inheritdoc
     */
    public function id(): string
    {
        // The main window is single and don't need an id.
        return '';
    }

    /**
     * @inheritdoc
     */
    public function getEval(): Evaluator
    {
        return $this->app;
    }

    /**
     * @inheritdoc
     */
    public function parent(): Container
    {
        return $this;
    }

    public function bindWidget(Widget $widget, string $event, ?callable $callback): Container
    {
        if ($callback === null) {
            $this->app->unbindWidget($widget, $event);
        } else {
            $this->app->bindWidget($widget, $event, $callback);
        }
        return $this;
    }
}