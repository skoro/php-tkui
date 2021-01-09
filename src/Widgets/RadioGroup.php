<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Variable;
use TclTk\Widgets\Buttons\RadioButton;

class RadioGroup extends Frame
{
    private Variable $variable;

    public function __construct(TkWidget $parent, array $options = [])
    {
        parent::__construct($parent, $options);
        $this->variable = $this->window()->registerVar($this);
    }

    public function add(string $title, $value): RadioButton
    {
        return new RadioButton($this, $title, $value, [
            'variable' => $this->variable,
        ]);
    }

    public function get()
    {
        return $this->variable->asString();
    }

    public function setValue($value)
    {
        $this->variable->set($value);
    }
}