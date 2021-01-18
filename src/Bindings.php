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
        foreach ($this->callbacks as $tag => $callbacks) {
            foreach ($callbacks as $event => $_) {
                $this->deleteCallback($tag, $event);
            }
        }
    }

    public function bindWidget(TkWidget $widget, string $event, callable $callback)
    {
        $tag = $widget->path();
        $this->tkBind($tag, $event, $callback);
    }

    public function unbindWidget(TkWidget $widget, string $event)
    {
        $this->deleteCallback($widget->path(), $event);
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

    protected function deleteCallback(string $tag, string $event)
    {
        if (isset($this->callbacks[$tag][$event])) {
            unset($this->callbacks[$tag][$event]);
            $command = $this->tclCommandName($tag, $event);
            $this->interp->deleteCommand($command);
        }
    }

    protected function createTclBindCallback(string $tag, string $event, callable $callback): string
    {
        $command = $this->tclCommandName($tag, $event);
        $this->interp->createCommand($command, $callback);
        return $command;
    }

    protected function tclCommandName(string $tag, string $event): string
    {
        return 'PHP_Bind_' . str_replace('.', '_', $tag) . '_' . $event;
    }
}