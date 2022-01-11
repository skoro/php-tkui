<?php

use Tkui\Widgets\Buttons\Button;
use Tkui\Widgets\Label;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

(new class extends DemoAppWindow
{
    const WIDTH = 360;
    const HEIGHT = 180;

    public function __construct()
    {
        parent::__construct('Demo of place layout manager');

        $this->getWindowManager()
             ->setSize(self::WIDTH, self::HEIGHT);

        $this->buildUI();
    }

    protected function buildUI(): void
    {
        $this->place(new Label($this, 'All widgets are placed as fixed.'), [
            'x' => 4,
            'y' => 10,
        ]);

        $this->place(new Label($this, 'Try to resize window, widgets will remain on its positions.'), [
            'x' => 4,
            'y' => 32,
        ]);

        $this->place(new Button($this, 'Static size'), [
            'width' => 120,
            'height' => 40,
            'x' => self::WIDTH - 124,
            'y' => self::HEIGHT - 44,
        ]);

        $this->place(new Button($this, 'Center'), [
            'width' => 80,
            'height' => 60,
            'x' => self::WIDTH / 2 - 40,
            'y' => self::HEIGHT / 2 - 30,
        ]);
    }

})->run();
