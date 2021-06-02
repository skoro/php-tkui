<?php declare(strict_types=1);

use PhpGui\Widgets\Frame;
use PhpGui\Widgets\Label;
use PhpGui\Widgets\Separator;
use PhpGui\Widgets\Sizegrip;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$win = new DemoAppWindow('Sizegrip demo');

$f = new Frame($win);
$f->pack()->sideBottom()->fillX()->manage();
$sizeGrip = new Sizegrip($f);
$sizeGrip->pack()->sideRight()->anchor('se')->manage();
$win->getWindowManager()->setSize(400, 200);

(new Label($win, 'Sizegrip widget demo.'))
    ->pack()
    ->sideTop()
    ->manage();

(new Label($win, 'A ttk::sizegrip widget (also known as a grow box) allows the user to resize the containing toplevel window by pressing and dragging the grip.', [
    'wrapLength' => 200,
]))
    ->pack()
    ->padY(32)
    ->padX(8)
    ->sideTop()
    ->manage();

(new Separator($win, ['orient' => Separator::ORIENT_HORIZONTAL]))
    ->pack()
    ->sideBottom()
    ->fillX()
    ->manage();

$win->run();
