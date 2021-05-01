<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Variable;
use TclTk\Widgets\Buttons\RadioButton;
use TclTk\Widgets\Common\ValueInVariable;

class RadioGroup extends Frame implements ValueInVariable
{
    private Variable $variable;

    public function __construct(Container $parent, array $options = [])
    {
        parent::__construct($parent, $options);
        $this->variable = $this->getEval()->registerVar($this);
    }

    public function add(string $title, $value): RadioButton
    {
        return new RadioButton($this, $title, $value, [
            'variable' => $this->variable,
        ]);
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
}