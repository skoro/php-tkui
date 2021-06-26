<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

/**
 * @property string $label
 */
class MenuItem extends CommonItem implements Clickable
{
    private $callback;

    public function __construct(string $label, $callback = null)
    {
        parent::__construct([
            'label' => $label,
        ]);
        $this->callback = $callback;
    }

    public function type(): string
    {
        return 'command';
    }

    public function onClick(callable $callback): self
    {
        $this->callback = $callback;
        return $this;
    }

    public function callback(): ?callable
    {
        return $this->callback;
    }

    public function hasCallback(): bool
    {
        return $this->callback !== null;
    }
}