<?php

use TclTk\App;
use TclTk\Widgets\Buttons\Button;
use TclTk\Widgets\Entry;
use TclTk\Widgets\Frame;
use TclTk\Widgets\Label;
use TclTk\Widgets\Listbox;
use TclTk\Widgets\ListboxItem;
use TclTk\Widgets\Scrollbar;
use TclTk\Widgets\Window;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$demo = new class extends Window
{
    private Listbox $listBox;

    public function __construct()
    {
        parent::__construct(App::create(), 'Demo Listbox');
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

        return $f;
    }

    protected function createListBox(Frame $parent): Listbox
    {
        $lb = new Listbox($parent);
        $lb->yScrollCommand = new Scrollbar($parent);
        $lb->yScrollCommand->pack()->sideRight()->fillY()->manage();
        $lb->pack()->sideLeft()->fillBoth()->expand()->manage();
        return $lb;
    }

    protected function listControlsFrame(): Frame
    {
        $f = new Frame($this);

        $fillX = ['fill' => 'x'];

        $btnDel = new Button($f, 'Delete');
        $btnDel->pack($fillX)->manage();
        $btnDel->onClick(fn () => $this->deleteItems());

        $btnClear = new Button($f, 'Clear');
        $btnClear->pack($fillX)->manage();
        $btnClear->onClick(fn () => $this->listBox->clear());

        $btnAppend = new Button($f, 'Append');
        $btnAppend->pack($fillX)->manage();
        $btnAppend->onClick(fn () => $this->initItems());

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

$demo->app()->mainLoop();