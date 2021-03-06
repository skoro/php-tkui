<?php declare(strict_types=1);

use TclTk\App;
use TclTk\Widgets\Frame;
use TclTk\Widgets\Label;
use TclTk\Widgets\Separator;
use TclTk\Widgets\Sizegrip;
use TclTk\Widgets\Window;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$app = App::create();

$win = new Window($app, 'Sizegrip demo');

$f = new Frame($win);
$f->pack()->sideBottom()->fillX()->manage();
$sizeGrip = new Sizegrip($f);
$sizeGrip->pack()->sideRight()->anchor('se')->manage();

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

$app->mainLoop();
