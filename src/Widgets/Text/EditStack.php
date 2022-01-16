<?php declare(strict_types=1);

namespace Tkui\Widgets\Text;

/**
 * EditStack provides undo/redo operations and checking its state.
 */
class EditStack
{
    private TextApiMethodBridge $bridge;

    public function __construct(TextApiMethodBridge $bridge)
    {
        $this->bridge = $bridge;
    }

    /**
     * Checks whether can perform the redo operation.
     */
    public function canRedo(): bool
    {
        return (bool) $this->bridge->callMethod('canredo');
    }

    /**
     * Checks whether can performs the undo operation.
     */
    public function canUndo(): bool
    {
        return (bool) $this->bridge->callMethod('canundo');
    }

    public function isModified()
    {
        return (bool) $this->bridge->callMethod('modified');
    }

    /**
     * Sets the modified state for the text widget.
     */
    public function setModified(bool $flag): self
    {
        $this->bridge->callMethod('modified', $flag);
        return $this;
    }

    /**
     * Reapplies the last undone edit.
     */
    public function redo(): self
    {
        // TODO: the docs says redo can return error in case of the redo stack is empty.
        $this->bridge->callMethod('redo');
        return $this;
    }

    /**
     * Undoes the last edit action.
     */
    public function undo(): self
    {
        // TODO: the docs says undo can return error in case of the undo stack is empty.
        $this->bridge->callMethod('undo');
        return $this;
    }

    /**
     * Clears the undo and redo stacks.
     */
    public function reset(): self
    {
        $this->bridge->callMethod('reset');
        return $this;
    }

    /**
     * Inserts a separator (boundary) on the undo stack.
     */
    public function separator(): self
    {
        $this->bridge->callMethod('separator');
        return $this;
    }
}