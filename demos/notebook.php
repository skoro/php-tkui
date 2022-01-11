<?php declare(strict_types=1);

use Tkui\Layouts\Pack;
use Tkui\Widgets\Buttons\Button;
use Tkui\Widgets\Frame;
use Tkui\Widgets\Label;
use Tkui\Widgets\LabelFrame;
use Tkui\Widgets\Notebook;
use Tkui\Widgets\NotebookTab;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    public function __construct()
    {
        parent::__construct('Notebook demo');

        $l = new Label($this, '');
        $this->pack($l, ['padx' => 2, 'pady' => 2, 'fill' => Pack::FILL_X]);

        $nb = new Notebook($this);
        $nb->add($this->createTab1($nb));
        $nb->add($this->createTab2($nb));
        $nb->add($this->createTab3($nb));
        $nb->onChanged(function (NotebookTab $tab) use ($l) {
            $this->showCurrentTabname($l, $tab->text);
        });
        $this->pack($nb, ['expand' => true, 'fill' => Pack::FILL_BOTH]);
    }

    private function createTab1(Notebook $parent): NotebookTab
    {
        $f = new Frame($parent);
        $tab = new NotebookTab($f, '_First tab');

        $b1 = new Button($f, 'Click to change tab text');
        $b1->onClick(function () use ($tab) {
            $tab->text = 'Changed !';
        });

        $b2 = new Button($f, 'Switch to Second');
        $b2->onClick(fn () => $parent->select(1));

        $f->pack([$b1, $b2], ['pady' => 8]);

        return $tab;
    }

    private function createTab2(Notebook $parent): NotebookTab
    {
        $f = new LabelFrame($parent, 'Second frame');

        return new NotebookTab($f, '_Second tab', ['padding' => 4]);
    }

    private function createTab3(Notebook $parent): NotebookTab
    {
        $f = new Frame($parent);
        $tab = new NotebookTab($f, 'Hi_de me');

        $b = new Button($f, 'Click to hide');
        $b->onClick(function () use ($parent, $tab) {
            $parent->hide($tab);
        });
        $f->pack($b, ['pady' => 8]);

        return $tab;
    }

    protected function showCurrentTabname(Label $l, string $name = '')
    {
        $l->text = 'Current tab: ' . $name;
    }
};

$demo->run();
