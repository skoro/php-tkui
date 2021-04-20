<?php

use TclTk\App;
use TclTk\Widgets\Buttons\Button;
use TclTk\Widgets\Frame;
use TclTk\Widgets\Scrollbar;
use TclTk\Widgets\Text;
use TclTk\Widgets\Window;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$demo = new class extends Window
{
    private Text $text;

    public function __construct()
    {
        parent::__construct(App::create(), 'Demo Textbox');
        $this->createActions();
        $f = new Frame($this);
        $this->text = $this->createTextbox($f);
        $f->pack()->expand()->fillBoth()->manage();
        $this->fillText();
    }

    protected function createActions(): void
    {
        $f = new Frame($this);
        $f->pack()->sideTop()->fillX()->manage();

        (new Button($f, 'Clear'))->onClick(function () {
            $this->text->clear();
        })->pack()->sideLeft()->manage();
    }

    protected function createTextbox(Frame $parent): Text
    {
        $t = new Text($parent);
        $t->yScrollCommand = new Scrollbar($parent);
        $t->yScrollCommand->pack()->sideRight()->fillY()->expand()->manage();
        $t->pack()->sideLeft()->fillBoth()->expand()->manage();
        return $t;
    }

    protected function fillText(): void
    {
        $this->text->insert("This is demo of text widget.\n");
        $this->text->insert("Date: " . date('Y-m-d') . "\n");
    }
};

$demo->app()->mainLoop();