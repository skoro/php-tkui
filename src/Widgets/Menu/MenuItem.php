<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

use PhpGui\Options;

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
    public function __construct(string $label, $callback, array $options = [])
    {
        parent::__construct($options);
        $this->label = $label;
        $this->command = $callback;
    }

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return new Options([
            'label' => null,
            'command' => null,
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