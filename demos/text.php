<?php

use PhpGui\Layouts\Pack;
use PhpGui\Widgets\Buttons\Button;
use PhpGui\Widgets\Frame;
use PhpGui\Widgets\Scrollbar;
use PhpGui\Widgets\Text\Text;

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
        $t->xScrollCommand = new Scrollbar($parent, ['orient' => Scrollbar::ORIENT_HORIZONTAL]);
        $parent->grid($t, ['sticky' => 'nsew', 'row' => 0, 'column' => 0])
               ->rowConfigure($parent, 0, ['weight' => 1])
               ->columnConfigure($parent, 0, ['weight' => 1]);
        $parent->grid($t->yScrollCommand, ['sticky' => 'nsew', 'row' => 0, 'column' => 1]);
        $parent->grid($t->xScrollCommand, ['sticky' => 'nsew', 'row' => 1, 'column' => 0]);
        return $t;
    }

    protected function fillText(): void
    {
        $this->text->append("This is demo of text widget.\n");
        $this->text->append("Date: " . date('Y-m-d') . "\n");
    }
};

$demo->run();