<?php declare(strict_types=1);

use TclTk\App;
use TclTk\Widgets\Buttons\Button;
use TclTk\Widgets\Frame;
use TclTk\Widgets\LabelFrame;
use TclTk\Widgets\Notebook;
use TclTk\Widgets\NotebookTab;
use TclTk\Widgets\Window;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$demo = new class extends Window
{
    public function __construct()
    {
        parent::__construct(App::create(), 'Notebook demo');

        $nb = new Notebook($this);
        $nb->add($this->createTab1($nb));
        $nb->add($this->createTab2($nb));
        $nb->pack()->expand()->fillBoth()->manage();
        $nb->onChanged([$this, 'OnChangeTab']);
    }

    private function createTab1(Notebook $parent): NotebookTab
    {
        $f = new Frame($parent);
        $tab = new NotebookTab($f, 'First tab');

        (new Button($f, 'Click to change tab text'))
            ->onClick(function () use ($tab) {
                $tab->text = 'Changed !';
            })->pack()->padY(8)->manage();

        return $tab;
    }

    private function createTab2(Notebook $parent): NotebookTab
    {
        $f = new LabelFrame($parent, 'Second frame');

        return new NotebookTab($f, 'Second tab', ['padding' => 4]);
    }

    public function onChangeTab(Notebook $nb): void
    {
        echo 'Changed.'.PHP_EOL;
    }
};

$demo->app()->mainLoop();
