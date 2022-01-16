<?php declare(strict_types=1);

namespace Tkui;

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
    public function tclEval(...$args);

    /**
     * Registers the variable in the current Tcl interpreter.
     *
     * @param Widget|string $varName
     */
    public function registerVar($varName): Variable;

    /**
     * Unregisters the variable.
     *
     * @param Widget|string $varName
     */
    public function unregisterVar($varName): void;

    /**
     * Registers a widget callback.
     *
     * @param string[] $args Any additional arguments to the widget's callback.
     *
     * @return string Returns a Tcl procedure name.
     */
    public function registerCallback(Widget $widget, callable $callback, array $args = []): string;
}