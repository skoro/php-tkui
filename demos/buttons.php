<?php

use PhpGui\Widgets\Buttons\Button;
use PhpGui\Widgets\Buttons\CheckButton;
use PhpGui\Widgets\Buttons\RadioButton;
use PhpGui\Widgets\Label;
use PhpGui\Widgets\LabelFrame;
use PhpGui\Widgets\RadioGroup;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    public function __construct()
    {
        parent::__construct('Buttons Demo');
        $this->buttons()
             ->pack()
             ->sideLeft()
             ->ipadX(4)
             ->ipadY(4)
             ->padX(4)
             ->padY(2)
             ->anchor('n')
             ->manage();

        $this->checkboxes()
             ->pack()
             ->padX(2)
             ->padY(2)
             ->sideLeft()
             ->anchor('n')
             ->manage();

        $this->radiobuttons()
             ->pack()
             ->padX(2)
             ->padY(2)
             ->sideLeft()
             ->anchor('n')
             ->manage();
    }

    protected function buttons(): LabelFrame
    {
        $f = new LabelFrame($this, 'Buttons');
        $l = new Label($f, 'Press button');
        $l->pack()->sideTop()->ipadY(2)->manage();
        (new Button($f, 'Button 1'))
            ->onClick(fn (Button $b) => $l->text = $b->text)
            ->pack()
            ->sideTop()
            ->manage();
        (new Button($f, 'Button 2'))
            ->onClick(fn (Button $b) => $l->text = $b->text)
            ->pack()
            ->sideTop()
            ->manage();

        // Disabled button with state in options.
        (new Button($f, 'Disabled', ['state' => Button::STATE_DISABLED]))
            ->pack()
            ->sideTop()
            ->manage();

        return $f;
    }

    protected function checkboxes(): LabelFrame
    {
        $f = new LabelFrame($this, 'Checkboxes');
        $l = new Label($f, 'Selected...');
        $l->pack()->manage();
        foreach (['One', 'Two', 'Three', 'Four'] as $name) {
            $cb = new CheckButton($f, $name);
            $cb->pack()->sideTop()->anchor('w')->fillX()->manage();
            if ($name === 'Three') {
                $cb->select();
            }
            $cb->onClick(fn (CheckButton $cb) => $l->text = $cb->text . ': ' . $cb->getValue());
        }

        // Disabled check button, setting state via method (allows chaining).
        (new CheckButton($f, 'Disabled'))
            ->state(CheckButton::STATE_DISABLED)
            ->pack()->sideTop()->anchor('w')->fillX()->manage();

        return $f;
    }

    protected function radiobuttons(): LabelFrame
    {
        $f = new LabelFrame($this, 'Radio buttons');
        $l = new Label($f, 'Selected...');
        $l->pack()->manage();
        $rg = new RadioGroup($f);
        $rg->setValue('two');
        foreach (['One', 'Two', 'Three', 'Four'] as $name) {
            $rg->add($name, strtolower($name))
                ->onClick(fn (RadioButton $b) => $l->text = $b->text . ': ' . $b->getValue())
                ->pack()
                ->anchor('w')
                ->fillX()
                ->manage();
        }

        // Disabled, setting state as a property.
        $x = $rg->add('Disabled', 'disabled');
        $x->state = RadioButton::STATE_DISABLED;
        $x->pack()->anchor('w')->fillX()->manage();

        $rg->pack()->fillBoth()->expand()->manage();
        return $f;
    }
};

$demo->run();