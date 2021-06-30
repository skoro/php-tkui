<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

/**
 * Implements a simple menu item with a callback.
 *
 * @property string $label
 * @property callable $command
 */
class MenuItem extends CommonItem
{
    /**
     * @param callable $callback
     */
    public function __construct(string $label, $callback)
    {
        parent::__construct([
            'label' => $label,
            'command' => $callback,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function type(): string
    {
        return 'command';
    }

    public function onClick(callable $callback): self
    {
        $this->command = $callback;
        return $this;
    }
}