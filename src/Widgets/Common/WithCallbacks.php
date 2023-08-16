<?php declare(strict_types=1);

namespace Tkui\Widgets\Common;

use Tkui\Exceptions\InvalidValueTypeException;

/**
 * WithCallbacks trait.
 *
 * This trait helps maintain the widget callbacks.
 * When the widget has an option callback like "command" the option must have
 * a Tcl procedure name but not a PHP callback.
 * To resolve that case, we declare a callable variable which will contain a PHP callback
 * and the option will have a Tcl procedure name.
 * <code>
 *     class MyWidget extends TtkWidget
 *     {
 *          use WithCallbacks; // Override __set/__get to substitute callback.
 *
 *         // callable|null
 *         private $checkCommandCallback = null; // The real "checkCommand" callback. "Callback" suffix is required !
 *
 *         protected function createOptions(): Options
 *         {
 *             return new TclOptions([
 *                  // We override __set/__get to substitute a callback from $checkCommandCallback.
 *                  // But if you take a look at the debug log you will see a Tcl procedure is attached
 *                  // instead of PHP callback.
 *                  'checkCommand' => null,
 *             ]);
 *         }
 *     }
 *
 *     $myWidget = new MyWidget($parent);
 *     $myWidget->checkCommand = function (MyWidget $widget) {
 *     };
 * </code>
 *
 * When the command requires additional arguments, declare a variable with the suffix "Args" like this:
 * <code>
 *     private readonly array $checkCommandArgs = ['%W'];
 * </code>
 * Those arguments will be passed to a Tcl procedure and be available as variables in PHP callback:
 * <code>
 *     $myWidget->checkCommand = function (MyWidget $widget, $var1) {
 *         // $var1 is %W
 *     };
 * </code>
 */
trait WithCallbacks
{
    /**
     * @throws InvalidValueTypeException When the value is not a callback or null.
     */
    public function __set(string $name, mixed $value): void
    {
        $callback = $name . 'Callback';

        if (property_exists($this, $callback)) {
            if (is_callable($value)) {
                $this->{$callback} = $value;
                $args = property_exists($this, $name . 'Args') ? $this->{$name . 'Args'} : [];
                $value = $this->parent()->getEval()->registerCallback($this, $value, $args, $name);
            } elseif ($value === null) {
                $this->parent()->getEval()->unregisterCallback($this, $name);
            } else {
                throw new InvalidValueTypeException('callback', $value);
            }
        }

        parent::__set($name, $value);
    }

    public function __get($name): mixed
    {
        $callback = $name . 'Callback';

        if (property_exists($this, $callback)) {
            return $this->{$callback};
        }

        return parent::__get($name);
    }
}