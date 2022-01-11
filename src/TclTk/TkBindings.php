<?php declare(strict_types=1);

namespace Tkui\TclTk;

use Tkui\Bindings;
use Tkui\Widgets\Widget;

class TkBindings implements Bindings
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

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/bind.htm
     */
    public function bindWidget(Widget $widget, string $event, callable $callback): void
    {
        $tag = $widget->path();
        $this->tkBind($tag, $event, $callback);
    }

    /**
     * @inheritdoc
     */
    public function unbindWidget(Widget $widget, string $event): void
    {
        $this->deleteCallback($widget->path(), $event);
    }

    protected function tkBind(string $tag, string $event, callable $callback)
    {
        $command = $this->createTclBindCallback($tag, $event, $callback);
        if (!($event[0] === '<' && substr($event, -1, 1) === '>')) {
            $tkEvent = '<' . $event . '>';
        } else {
            $tkEvent = $event;
        }
        $script = sprintf('bind %s %s %s', $tag, $tkEvent, $command);
        $this->interp->eval($script);
        $this->callbacks[$tag][$event] = $callback;
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