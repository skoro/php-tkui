<?php declare(strict_types=1);

namespace Tkui\Windows;

use Tkui\Layouts\Grid;
use Tkui\Layouts\LayoutManager;
use Tkui\Layouts\Pack;
use Tkui\Layouts\Place;
use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\TclTk\TkWindowManager;
use Tkui\Widgets\Container;
use Tkui\Widgets\Menu\Menu;
use Tkui\Widgets\Widget;
use Tkui\WindowManager;

/**
 * Shares the features for window implementations.
 *
 * @property string $title
 */
abstract class BaseWindow implements Window
{
    private readonly Options $options;
    private readonly WindowManager $wm;

    /**
     * Window instance id.
     */
    private readonly int $id;

    private static int $idCounter = 0;

    /**
     * @param string $title The window title.
     */
    public function __construct(string $title)
    {
        $this->id = self::$idCounter++;
        $this->options = $this->initOptions();
        $this->wm = $this->createWindowManager();
        $this->createWindow();
        $this->title = $title;
    }

    public function __destruct()
    {
        // TODO: unregister callback handler.
        // TODO: destroy all variables.
    }

    protected function initOptions(): Options
    {
        return new TclOptions([
            'title' => '',
            'state' => '',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function close(): void
    {
        $this->getEval()->tclEval('destroy', $this->path());
    }

    /**
     * Create the window manager for the window.
     */
    protected function createWindowManager(): WindowManager
    {
        return new TkWindowManager($this->getEval(), $this);
    }

    /**
     * Actual window creation.
     */
    abstract protected function createWindow(): void;

    /**
     * @inheritdoc
     */
    public function widget(): string
    {
        return 'toplevel';
    }

    /**
     * @inheritdoc
     */
    public function window(): Window
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function id(): string
    {
        return 'w' . $this->id;
    }

    /**
     * @inheritdoc
     */
    public function path(): string
    {
        return '.' . $this->id();
    }

    /**
     * @inheritdoc
     */
    public function options(): Options
    {
        return $this->options;
    }

    public function __get($name)
    {
        return $this->options->$name;
    }

    public function __set($name, $value)
    {
        if ($this->options->has($name) && $this->options->$name !== $value) {
            $this->options->$name = $value;
            switch ($name) {
                case 'title':
                    $this->wm->setTitle($value);
                    break;
                case 'state':
                    $this->wm->setState($value);
                    break;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function pack($widget, array|Options $options = []): LayoutManager|Pack
    {
        return $this->doLayout(new Pack($this->getEval()), $widget, $options);
    }

    /**
     * @inheritdoc
     */
    public function grid($widget, array|Options $options = []): LayoutManager|Grid
    {
        return $this->doLayout(new Grid($this->getEval()), $widget, $options);
    }

    /**
     * @inheritdoc
     */
    public function place($widget, array|Options $options = []): LayoutManager|Place
    {
        return $this->doLayout(new Place($this->getEval()), $widget, $options);
    }

    /**
     * @param Widget|Widget[] $widgets
     */
    protected function doLayout(LayoutManager $manager, $widgets, array|Options $options): LayoutManager
    {
        if (! is_array($widgets)) {
            $widgets = array($widgets);
        }

        foreach ($widgets as $widget) {
            $manager->add($widget, $options);
        }

        return $manager;
    }

    /**
     * @inheritdoc
     */
    public function bind(string $event, ?callable $callback): Container
    {
        return $this->bindWidget($this, $event, $callback);
    }

    /**
     * @inheritdoc
     */
    public function getWindowManager(): WindowManager
    {
        return $this->wm;
    }

    /**
     * @inheritdoc
     */
    public function setMenu(Menu $menu): Window
    {
        $this->getEval()->tclEval($this->path(), 'configure', '-menu', $menu->path());
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function showModal()
    {
        $this->getEval()->tclEval('grab', $this->path());
    }

    public function __toString(): string
    {
        return $this->path();
    }
}
