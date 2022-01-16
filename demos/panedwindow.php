<?php

use Tkui\Layouts\Pack;
use Tkui\Widgets\Label;
use Tkui\Widgets\LabelFrame;
use Tkui\Widgets\PanedWindow;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    public function __construct()
    {
        parent::__construct('Paned window demo');

        $packOptions = [
            'fill' => Pack::FILL_BOTH,
            'padx' => 2,
            'pady' => 2,
            'expand' => true,
        ];

        $vert = new PanedWindow($this);
        $this->pack($vert, $packOptions);

        $pw = new PanedWindow($vert, ['orient' => PanedWindow::ORIENT_HORIZONTAL]);
        $this->pack($pw, $packOptions);

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
        $f->pack(new Label($f, $label));
        return $f;
    }
};

$demo->run();
