<?php declare(strict_types=1);

namespace TclTk;

use TclTk\Widgets\Widget;

/**
 * Provides the access to low-level Tcl API.
 */
interface Evaluator
{
    /**
     * Evaluates a script in the current interpreter.
     *
     * @param string ...$args The tokenized Tcl script.
     *
     * @return mixed The return value depends on script result.
     */
    public function tclEval(string ...$args);

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
     * @return string Returns a Tcl procedure name.
     */
    public function registerCallback(Widget $widget, callable $callback): string;
}