<?php

use TclTk\App;
use TclTk\Widgets\Label;
use TclTk\Widgets\LabelFrame;
use TclTk\Widgets\PanedWindow;
use TclTk\Widgets\Window;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$demo = new class extends Window
{
    public function __construct()
    {
        parent::__construct(App::create(), 'Paned window demo');

        $vert = new PanedWindow($this);
        $vert->pack()->expand()->fillBoth()->pad(2, 2)->manage();

        $pw = new PanedWindow($vert, ['orient' => PanedWindow::ORIENT_HORIZONTAL]);
        $pw->pack()->expand()->fillBoth()->pad(2, 2)->manage();

        $pw->add($this->makePanel($pw, "Frame 1", "This is the left side."))
           ->add($this->makePanel($pw, "Frame 2", "This is the middle."))
           ->add($this->makePanel($pw, "Frame 3", "This is the right side."));

        $vert->add($pw);
        $vert->add($this->makePanel($vert, 'Frame 4', 'Like A Place In The Sun'));
    }

    protected function makePanel(PanedWindow $parent, string $title, string $label)
    {
        $f = new LabelFrame($parent, $title);
        (new Label($f, $label))->pack()->manage();
        return $f;
    }
};

$demo->app()->mainLoop();
