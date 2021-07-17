<?php

use PhpGui\Layouts\Pack;
use PhpGui\Widgets\Buttons\Button;
use PhpGui\Widgets\Frame;
use PhpGui\Widgets\Scrollbar;
use PhpGui\Widgets\Text;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    private Text $text;

    public function __construct()
    {
        parent::__construct('Demo Textbox');
        $this->createActions();
        $f = new Frame($this);
        $this->text = $this->createTextbox($f);
        $this->pack($f, ['expand' => true, 'fill' => Pack::FILL_BOTH]);
        $this->fillText();
    }

    protected function createActions(): void
    {
        $f = new Frame($this);
        $this->pack($f, ['side' => Pack::SIDE_TOP, 'fill' => Pack::FILL_X]);

        $b = new Button($f, 'Clear');
        $b->onClick(function () {
            $this->text->clear();
        });
        $f->pack($b, ['side' => Pack::SIDE_LEFT]);
    }

    protected function createTextbox(Frame $parent): Text
    {
        $t = new Text($parent);
        $t->yScrollCommand = new Scrollbar($parent);
        $parent->pack($t->yScrollCommand, ['side' => Pack::SIDE_RIGHT, 'fill' => Pack::FILL_Y, 'expand' => true]);
        $parent->pack($t, ['side' => Pack::SIDE_LEFT, 'fill' => Pack::FILL_BOTH, 'expand' => true]);
        return $t;
    }

    protected function fillText(): void
    {
        $this->text->append("This is demo of text widget.\n");
        $this->text->append("Date: " . date('Y-m-d') . "\n");
    }
};

$demo->run();