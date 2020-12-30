<?php declare(strict_types=1);

namespace TclTk\Layouts;

use TclTk\Options;
use TclTk\Widgets\TkWidget;

abstract class Manager implements LayoutManager
{
    private TkWidget $widget;
    private Options $options;

    public function __construct(TkWidget $widget, array $options = [])
    {
        $this->options = $this->initOptions()->mergeAsArray($options);
        $this->widget = $widget;
    }

    protected function initOptions(): Options
    {
        return new Options();
    }

    public function widget(): TkWidget
    {
        return $this->widget;
    }

    protected function call(string $command)
    {
        return $this->widget
                    ->window()
                    ->app()
                    ->tclEval($command, $this->widget->path(), ...$this->options->asStringArray());
    }

    public function __get($name)
    {
        return $this->options->$name;
    }

    public function __set($name, $value)
    {
        $this->options->$name = $value;
    }

    public function manage(): TkWidget
    {
        return $this->widget;
    }
}