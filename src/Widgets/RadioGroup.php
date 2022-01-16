<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\TclTk\Variable;
use Tkui\Widgets\Buttons\RadioButton;
use Tkui\Widgets\Common\Clickable;
use Tkui\Widgets\Common\ValueInVariable;

// TODO: array iterable
class RadioGroup extends Frame implements ValueInVariable, Clickable
{
    private Variable $variable;
    /** @var RadioButton[] */
    private array $buttons;

    public function __construct(Container $parent, array $options = [])
    {
        parent::__construct($parent, $options);
        $this->variable = $this->getEval()->registerVar($this);
        $this->buttons = [];
    }

    public function add(string $title, $value): RadioButton
    {
        $button = new RadioButton($this, $title, $value, [
            'variable' => $this->variable,
        ]);
        $this->buttons[] = $button;
        return $button;
    }

    public function getValue(): string
    {
        return $this->variable->asString();
    }

    public function setValue($value): self
    {
        $this->variable->set($value);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function onClick(callable $callback): self
    {
        /** @var RadioButton $button */
        foreach ($this->buttons as $button) {
            $button->onClick($callback);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function invoke(): self
    {
        // Does nothing.
        return $this;
    }
}