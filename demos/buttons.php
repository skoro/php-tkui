<?php

use TclTk\App;
use TclTk\Widgets\Buttons\Button;
use TclTk\Widgets\Buttons\CheckButton;
use TclTk\Widgets\Buttons\RadioButton;
use TclTk\Widgets\Label;
use TclTk\Widgets\LabelFrame;
use TclTk\Widgets\RadioGroup;
use TclTk\Widgets\Window;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$demo = new class extends Window
{
    public function __construct()
    {
        parent::__construct(App::create(), 'Buttons Demo');
        $this->buttons()
             ->pack()
             ->sideLeft()
             ->ipadX(4)
             ->ipadY(4)
             ->anchor('n')
             ->manage();

        $this->checkboxes()
             ->pack()
             ->sideLeft()
             ->anchor('n')
             ->manage();

        $this->radiobuttons()
             ->pack()
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
        return $f;
    }

    protected function checkboxes(): LabelFrame
    {
        $f = new LabelFrame($this, 'Checkboxes');
        $l = new Label($f, 'Selected...');
        $l->pack()->manage();
        foreach (['One', 'Two', 'Three', 'Four'] as $name) {
            $cb = new CheckButton($f, $name);
            $cb->pack()->sideTop()->anchor('w')->manage();
            if ($name === 'Three') {
                $cb->select();
            }
            $cb->onClick(fn (CheckButton $cb) => $l->text = $cb->text . ': ' . $cb->getValue());
        }
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
                ->manage();
        }
        $rg->pack()->fillBoth()->expand()->manage();
        return $f;
    }
};

$demo->app()->mainLoop();