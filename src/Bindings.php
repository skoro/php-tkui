<?php declare(strict_types=1);

namespace TclTk;

use TclTk\Widgets\TkWidget;

class Bindings
{
    private Interp $interp;
    private array $callbacks = [];

    public function __construct(Interp $interp)
    {
        $this->interp = $interp;
    }

    public function __destruct()
    {
        // TODO: delete all the bindings.
    }

    public function bindWidget(TkWidget $widget, string $event, callable $callback)
    {
        $tag = $widget->path();
        $this->tkBind($tag, $event, $callback);
    }

    protected function tkBind(string $tag, string $event, callable $callback)
    {
        if (isset($this->callbacks[$tag][$event])) {
            return;
        }
        $command = $this->createTclBindCallback($tag, $event, $callback);
        $script = sprintf('bind %s <%s> %s', $tag, $event, $command);
        $this->interp->eval($script);
    }

    protected function createTclBindCallback(string $tag, string $event, callable $callback): string
    {
        $command = 'PHP_Bind_' . str_replace('.', '_', $tag) . '_' . $event;
        $this->interp->createCommand($command, $callback);
        return $command;
    }
}