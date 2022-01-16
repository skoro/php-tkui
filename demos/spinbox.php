<?php

use Tkui\Layouts\Pack;
use Tkui\Widgets\Spinbox;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    public function __construct()
    {
        parent::__construct('Spinbox Demo');
        $this->getWindowManager()->setSize(240, 200);
        $this->buildUI();
    }

    private function buildUI()
    {
        $sp1 = new Spinbox($this, 1, [
            'from' => 1,
            'to' => 10,
            'width' => 20,
        ]);

        $sp2 = new Spinbox($this, 0.00, [
            'from' => 0,
            'to' => 3,
            'increment' => 0.5,
            'format' => '%05.2f',
            'width' => 20,
        ]);

        $sp3 = new Spinbox($this, 'Canberra', [
            'values' => ['Canberra', 'Sydney', 'Melbourne', 'Perth', 'Adelaide', 'Brisbane', 'Hobart', 'Darwin', 'Alice Springs'],
            'width' => 20,
        ]);

        $this->pack([$sp1, $sp2, $sp3], [
            'side' => Pack::SIDE_TOP,
            'pady' => 5,
            'padx' => 10,
        ]);
    }
};

$demo->run();
