<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

use PhpGui\Options;
use PhpGui\TclTk\Variable;
use PhpGui\Widgets\Common\ValueInVariable;

/**
 * Implementation of menu radio button item.
 *
 * @property string $label
 * @property Variable $variable
 * @property callable $command
 */
class MenuRadioItem extends MenuItem implements ValueInVariable
{
    /** @var mixed */
    private $value;

    /**
     * @param mixed $value
     * @param callable|null $callback
     */
    public function __construct(string $label, $value, $callback = null)
    {
        parent::__construct($label, $callback);
        $this->value = $value;
    }

    public function type(): string
    {
        return 'radiobutton';
    }

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return new Options([
            'label' => null,
            'variable' => null,
            'command' => null,
        ]);
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}