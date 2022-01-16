<?php declare(strict_types=1);

use Tkui\Layouts\Pack;
use Tkui\Widgets\Frame;
use Tkui\Widgets\Label;
use Tkui\Widgets\Separator;
use Tkui\Widgets\Sizegrip;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$win = new DemoAppWindow('Sizegrip demo');

$f = new Frame($win);
$win->pack($f, ['side' => Pack::SIDE_BOTTOM, 'fill' => Pack::FILL_X]);
$sizeGrip = new Sizegrip($f);
$win->pack($sizeGrip, ['side' => Pack::SIDE_RIGHT, 'anchor' => 'se']);
$win->getWindowManager()->setSize(400, 200);

$win->pack(new Label($win, 'Sizegrip widget demo.'), ['side' => Pack::SIDE_TOP]);

$win->pack(new Label($win, 'A ttk::sizegrip widget (also known as a grow box) allows the user to resize the containing toplevel window by pressing and dragging the grip.', [
    'wrapLength' => 200,
]), [
    'pady' => 32,
    'padx' => 8,
    'side' => Pack::SIDE_TOP,
]);

$win->pack(new Separator($win, ['orient' => Separator::ORIENT_HORIZONTAL]), [
    'side' => Pack::SIDE_BOTTOM,
    'fill' => Pack::FILL_X
]);

$win->run();
