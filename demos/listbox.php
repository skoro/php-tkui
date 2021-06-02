<?php

use PhpGui\Widgets\Buttons\Button;
use PhpGui\Widgets\Entry;
use PhpGui\Widgets\Frame;
use PhpGui\Widgets\Label;
use PhpGui\Widgets\LabelFrame;
use PhpGui\Widgets\Listbox;
use PhpGui\Widgets\ListboxItem;
use PhpGui\Widgets\Scrollbar;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    private Listbox $listBox;

    public function __construct()
    {
        parent::__construct('Demo Listbox');
        $this->helpFrame()->pack()->sideTop()->fillX()->manage();
        $this->newItemFrame()->pack()->sideTop()->fillX()->manage();
        $this->listControlsFrame()->pack()->sideRight()->fillY()->manage();
        $lf = new Frame($this);
        $lf->pack()->sideLeft()->fillBoth()->expand()->manage();
        $this->listBox = $this->createListBox($lf);
        $this->initItems();
    }

    protected function newItemFrame(): Frame
    {
        $f = new Frame($this);

        $this->pack(new Label($f, 'New item:'))->sideLeft()->manage();

        /** @var Entry $e */
        $e = $this->pack(new Entry($f, 'Demo'))
                  ->sideLeft()
                  ->fillX()
                  ->expand()
                  ->manage();

        $btn = $this->pack(new Button($f, 'Add'))
                    ->sideRight()
                    ->manage();
        /** @var Button $btn */
        $btn->onClick(function () use ($e) {
            $this->addNewItem($e->getValue());
            $e->clear();
        });

        $e->bind('Return', fn () => $btn->invoke());

        return $f;
    }

    protected function createListBox(Frame $parent): Listbox
    {
        $l = new Label($parent, 'Selected...');
        $l->pack()->sideBottom()->anchor('w')->manage();

        $lb = new Listbox($parent);
        $lb->yScrollCommand = new Scrollbar($parent);
        $lb->yScrollCommand->pack()->sideRight()->fillY()->manage();
        $lb->pack()->sideLeft()->fillBoth()->expand()->manage();

        /** @var ListboxItem[] $items */
        $lb->onSelect(function (array $items) use ($l) {
            $l->text = 'Selected: ' . implode(', ', array_map(fn ($item) => $item->value(), $items));
        });

        return $lb;
    }

    protected function listControlsFrame(): Frame
    {
        $f = new Frame($this);

        $fillX = ['fill' => 'x'];

        $btnDel = new Button($f, 'Delete');
        $btnDel->pack($fillX)->manage();
        $btnDel->onClick(fn () => $this->deleteItems());
        $this->bind('Control-d', [$btnDel, 'invoke']);

        $btnClear = new Button($f, 'Clear');
        $btnClear->pack($fillX)->manage();
        $btnClear->onClick(fn () => $this->listBox->clear());
        $this->bind('Control-l', [$btnClear, 'invoke']);

        $btnAppend = new Button($f, 'Append');
        $btnAppend->pack($fillX)->manage();
        $btnAppend->onClick(fn () => $this->initItems());
        $this->bind('Control-a', [$btnAppend, 'invoke']);

        return $f;
    }

    protected function helpFrame(): LabelFrame
    {
        $f = new LabelFrame($this, 'Help');
        (new Label($f, 'Button demo'))
            ->pack()
            ->sideTop()
            ->manage();
        $text = [
            'Use the following shortcuts:',
            '* Control-D = delete item',
            '* Control-L = clear items',
            '* Control-A = append items'
        ];
        foreach ($text as $t) {
            (new Label($f, $t))
                ->pack()
                ->sideTop()
                ->anchor('w')
                ->manage();
        }
        return $f;
    }

    protected function initItems(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $this->listBox->append(new ListboxItem("Test [$i]"));
        }
    }

    protected function addNewItem(string $value): void
    {
        if (!empty($value)) {
            $this->listBox->append(new ListboxItem($value));
        }
    }

    protected function deleteItems(): void
    {
        /** @var ListboxItem $item */
        foreach ($this->listBox->curselection() as $index => $item) {
            $this->listBox->delete($index);
        }
    }
};

$demo->run();