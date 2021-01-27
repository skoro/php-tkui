<?php declare(strict_types=1);

namespace TclTk\Layouts;

use TclTk\Options;
use TclTk\Widgets\Widget;

abstract class Manager implements LayoutManager
{
    private Widget $widget;
    private Options $options;

    public function __construct(Widget $widget, array $options = [])
    {
        $this->options = $this->initOptions()->mergeAsArray($options);
        $this->widget = $widget;
    }

    protected function initOptions(): Options
    {
        return new Options();
    }

    public function widget(): Widget
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

    public function manage(): Widget
    {
        return $this->widget;
    }
}