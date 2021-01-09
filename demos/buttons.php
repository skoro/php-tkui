<?php

use TclTk\App;
use TclTk\Widgets\Buttons\Button;
use TclTk\Widgets\Buttons\CheckButton;
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
        // $this->app()->tk()->interp()->createVariable('w0_wgd', '', 'one');
        // $this->app()->tk()->interp()->eval('set w0_wgd');
        $this->buttons()->pack()->sideLeft()->ipadX(4)->ipadY(4)->manage();
        $this->checkboxes()->pack()->sideLeft()->manage();
        $this->radiobuttons()->pack()->sideLeft()->manage();
    }

    protected function buttons(): LabelFrame
    {
        $f = new LabelFrame($this, 'Buttons');
        $l = new Label($f, 'Press button');
        $l->pack()->sideTop()->ipadY(2)->manage();
        (new Button($f, 'Button 1'))
            ->onClick(fn () => $l->text = 'Button 1')
            ->pack()
            ->sideTop()
            ->manage();
        (new Button($f, 'Button 2'))
            ->onClick(fn () => $l->text = 'Button 2')
            ->pack()
            ->sideTop()
            ->manage();
        return $f;
    }

    protected function checkboxes(): LabelFrame
    {
        $f = new LabelFrame($this, 'Checkboxes');
        foreach (['One', 'Two', 'Three', 'Four'] as $name) {
            $cb = new CheckButton($f, $name);
            $cb->pack()->sideTop()->anchor('w')->manage();
            if ($name === 'Three') {
                $cb->select();
            }
        }
        return $f;
    }

    protected function radiobuttons(): LabelFrame
    {
        $f = new LabelFrame($this, 'Radio buttons');
        $rg = new RadioGroup($f);
        $rg->setValue('two');
        foreach (['One', 'Two', 'Three', 'Four'] as $name) {
            $rg->add($name, strtolower($name))
                ->pack()
                ->anchor('w')
                ->manage();
        }
        $rg->pack()->fillBoth()->expand()->manage();
        return $f;
    }
};

$demo->app()->mainLoop();