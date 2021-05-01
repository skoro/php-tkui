<?php declare(strict_types=1);

namespace TclTk;

use TclTk\Widgets\Widget;

/**
 * Provides the access to low-level API.
 */
interface Evaluator
{
    /**
     * Evaluates a script in the current interepreter.
     *
     * @return mixed
     */
    public function tclEval(...$args);

    /**
     * Registers the variable in the interpreter.
     *
     * @param Widget|string $varName
     */
    public function registerVar($varName): Variable;

    /**
     * @param Widget|string $varName
     */
    public function unregisterVar($varName): void;

    /**
     * Registers a widget callback.
     */
    public function registerCallback(Widget $widget, callable $callback): string;
}