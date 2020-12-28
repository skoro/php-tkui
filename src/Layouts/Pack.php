<?php declare(strict_types=1);

namespace TclTk\Layouts;

use TclTk\Options;
use TclTk\Widgets\TkWidget;

/**
 * pack geometry manager.
 */
class Pack implements LayoutManager
{
    private TkWidget $widget;

    public function __construct(TkWidget $widget)
    {
        $this->widget = $widget;
    }

    public function pack(array $options = []): self
    {
        $opts = new Options($options);
        $this->widget
             ->window()
             ->app()
             ->tclEval('pack', $this->widget->path(), ...$opts->asStringArray());
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function widget(): TkWidget
    {
        return $this->widget;
    }
}