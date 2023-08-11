<?php declare(strict_types=1);

namespace Tkui;

use Stringable;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Widget;

/**
 * Provides the access to low-level API.
 */
interface Evaluator
{
    /**
     * Evaluates a Tcl script in the current interpreter.
     *
     * For example:
     * <code>
     * tclEval('set', 'myVar', 'SomeValue');
     * </code>
     * Will be executed as a Tcl script: set myVar SomeValue
     * <code>
     * tclEval('set myVar SomeValue');
     * </code>
     * Will be treated as a Tcl command {set myVar SomeValue}
     *
     * @param mixed ...$args All the arguments will be concateneted to a Tcl script
     *                       and executed in the Tcl interpreter.
     * 
     * @return mixed The return value depends on script result.
     */
    public function tclEval(mixed ...$args);

    /**
     * Registers the variable in the current Tcl interpreter.
     *
     * @param Stringable|string $varName The variable name.
     */
    public function registerVar(Stringable|string $varName): Variable;

    /**
     * Unregisters the variable.
     *
     * @param Stringable|string $varName The variable name.
     */
    public function unregisterVar(Stringable|string $varName): void;

    /**
     * Registers a widget callback as a Tcl procedure.
     *
     * @param Widget   $widget The widget to which a callback is attached.
     * @param callable $callback The callback, the first parameter will be an instance of the widget.
     * @param string[] $args Any additional arguments to the widget's callback.
     * @param string   $commandName When the widget has several commands, there should be a command name.
     *
     * @return string Returns a Tcl procedure name.
     */
    public function registerCallback(Widget $widget, callable $callback, array $args = [], string $commandName = ''): string;
}
