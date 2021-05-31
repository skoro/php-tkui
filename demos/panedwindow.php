<?php

use TclTk\Widgets\Label;
use TclTk\Widgets\LabelFrame;
use TclTk\Widgets\PanedWindow;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    public function __construct()
    {
        parent::__construct('Paned window demo');

        $vert = new PanedWindow($this);
        $vert->pack()->expand()->fillBoth()->pad(2, 2)->manage();

        $pw = new PanedWindow($vert, ['orient' => PanedWindow::ORIENT_HORIZONTAL]);
        $pw->pack()->expand()->fillBoth()->pad(2, 2)->manage();

        $pw->add($this->makePanel($pw, "Frame 1", "This is the left side."))
           ->add($this->makePanel($pw, "Frame 2", "This is the middle."))
           ->add($this->makePanel($pw, "Frame 3", "This is the right side."));

        $vert->add($pw);
        $vert->add($this->makePanel($vert, 'Frame 4', 'Like A Place In The Sun'));

        $this->getWindowManager()->setMinSize(400, 200);
    }

    protected function makePanel(PanedWindow $parent, string $title, string $label)
    {
        $f = new LabelFrame($parent, $title);
        (new Label($f, $label))->pack()->manage();
        return $f;
    }
};

$demo->run();
