<?php declare(strict_types=1);

use TclTk\App;
use TclTk\Widgets\Buttons\Button;
use TclTk\Widgets\Frame;
use TclTk\Widgets\Label;
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

        $l = new Label($this, '');
        $l->pack()->pad(2, 2)->fillX()->manage();

        $nb = new Notebook($this);
        $nb->add($this->createTab1($nb));
        $nb->add($this->createTab2($nb));
        $nb->add($this->createTab3($nb));
        $nb->pack()->expand()->fillBoth()->manage();
        $nb->onChanged(function (NotebookTab $tab) use ($l) {
            $this->showCurrentTabname($l, $tab->text);
        });
    }

    private function createTab1(Notebook $parent): NotebookTab
    {
        $f = new Frame($parent);
        $tab = new NotebookTab($f, 'First tab');

        (new Button($f, 'Click to change tab text'))
            ->onClick(function () use ($tab) {
                $tab->text = 'Changed !';
            })->pack()->padY(8)->manage();

        (new Button($f, 'Switch to Second'))
            ->onClick(fn () => $parent->select(1))
            ->pack()->padY(8)->manage();

        return $tab;
    }

    private function createTab2(Notebook $parent): NotebookTab
    {
        $f = new LabelFrame($parent, 'Second frame');

        return new NotebookTab($f, 'Second tab', ['padding' => 4]);
    }

    private function createTab3(Notebook $parent): NotebookTab
    {
        $f = new Frame($parent);
        $tab = new NotebookTab($f, 'Hide me');

        (new Button($f, 'Click to hide'))
            ->onClick(function () use ($parent, $tab) {
                $parent->hide($tab);
            })
            ->pack()->pady(8)->manage();

        return $tab;
    }

    protected function showCurrentTabname(Label $l, string $name = '')
    {
        $l->text = 'Current tab: ' . $name;
    }
};

$demo->app()->mainLoop();
