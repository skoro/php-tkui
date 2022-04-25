<?php declare(strict_types=1);

namespace Tkui\Dialogs;

use Tkui\TclTk\Exceptions\TkException;
use Tkui\Options;
use Tkui\Windows\ShowAsModal;
use Tkui\Windows\Window;

/**
 * Base class for dialog windows
 *
 * @property Window $parent.
 */
abstract class Dialog implements ShowAsModal
{
    private Options $options;
    private Window $parent;

    /** @var callable|null */
    private $callbackSuccess = null;
    /** @var callable|null */
    private $callbackCancel = null;

    public function __construct(Window $parent, array $options = [])
    {
        $this->parent = $parent;
        $options['parent'] = $parent;
        $this->options = $this->createOptions()->mergeAsArray($options);
    }

    protected function createOptions(): Options
    {
        return new Options([
            'parent' => null,
        ]);
    }

    /**
     * The Tk command implementing the dialog.
     */
    abstract public function command(): string;

    public function __get($name)
    {
        switch ($name) {
            case 'parent':
                return $this->parent;
        }

        return $this->options->$name;
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'parent':
                if (! $value instanceof Window) {
                    throw new TkException('Parent must be a Window instance.');
                }
                $this->parent = $value;
                /** @phpstan-ignore-next-line */
                $this->options->parent = $value->path();
                break;
            
            default:
                $this->options->$name = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function showModal()
    {
        $result = $this->parent->getEval()->tclEval($this->command(), ...$this->options->asStringArray());
        return $this->handleResult($result);
    }

    /**
     * @return mixed
     */
    protected function handleResult($result)
    {
        if ($result === '') {
            $this->doCancel();
        } else {
            $this->doSuccess($result);
        }
        return $result;
    }

    /**
     * Fires when the user confirms the dialog action.
     */
    public function onSuccess(callable $callback): self
    {
        $this->callbackSuccess = $callback;
        return $this;
    }

    /**
     * Fires when the user cancels the dialog.
     */
    public function onCancel(callable $callback): self
    {
        $this->callbackCancel = $callback;
        return $this;
    }

    protected function doSuccess($value)
    {
        if ($this->callbackSuccess) {
            $this->doCallback($this->callbackSuccess, $value);
        }
    }

    protected function doCancel()
    {
        if ($this->callbackCancel) {
            $this->doCallback($this->callbackCancel);
        }
    }

    protected function doCallback(callable $callback, ...$args)
    {
        $callback(...$args);
    }

    public function getOptions(): Options
    {
        return $this->options;
    }
}