<?php

use TclTk\App;
use TclTk\Widgets\Button;
use TclTk\Widgets\Frame;
use TclTk\Widgets\Listbox;
use TclTk\Widgets\ListboxItem;
use TclTk\Widgets\Scrollbar;
use TclTk\Widgets\Window;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$app = App::create();

$win = new Window($app, 'Demo PHP & TclTk');

$main = new Frame($win);
$main->pack(['side' => 'top', 'fill' => 'both', 'expand' => 1]);

$scroll = new Scrollbar($main);
$scroll->pack(['side' => 'right', 'fill' => 'y']);

$listbox = new Listbox($main, [
    new ListboxItem('PHP 8.0'),
    new ListboxItem('PHP 7.4'),
    new ListboxItem('Apache'),
    new ListboxItem('Nginx'),
    new ListboxItem('MySQL'),
    new ListboxItem('PostgreSQL'),
]);
$listbox->selectMode = Listbox::SELECTMODE_MULTIPLE;
$listbox->yScrollCommand = $scroll;
for ($i = 1; $i <= 20; $i++) {
    $listbox->append(new ListboxItem("Test ($i)"));
}
$listbox->pack(['side' => 'left', 'fill' => 'both', 'expand' => 1]);

$bottom = new Frame($win);
$bottom->pack(['side' => 'bottom', 'fill' => 'x']);
$ok = new Button($bottom, 'OK');
$ok->pack(['side' => 'right']);
$ok->onClick(function () use ($listbox) {
    var_dump($listbox->curselection());
});

$app->mainLoop();
