<?php

use TclTk\App;
use TclTk\Widgets\Button;
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
        $this->newItemFrame()->pack(['side' => 'top', 'fill' => 'x']);
        $this->listControlsFrame()->pack(['side' => 'right', 'fill' => 'y']);
        $lf = new Frame($this);
        $lf->pack(['side' => 'left', 'fill' => 'both', 'expand' => 1]);
        $this->listBox = $this->createListBox($lf);
        $this->initItems();
    }

    protected function newItemFrame(): Frame
    {
        $f = new Frame($this);

        $l = new Label($f, 'New item:');
        $l->pack(['side' => 'left']);

        $e = new Entry($f);
        $e->pack(['side' => 'left', 'fill' => 'x', 'expand' => 1]);

        $add = new Button($f, 'Add');
        $add->pack(['side' => 'right']);
        $add->onClick(function () use ($e) {
            $this->addNewItem($e->get());
            $e->clear();
        });

        return $f;
    }

    protected function createListBox(Frame $parent): Listbox
    {
        $lb = new Listbox($parent);
        $lb->yScrollCommand = new Scrollbar($parent);
        $lb->yScrollCommand->pack(['side' => 'right', 'fill' => 'y']);
        $lb->pack(['side' => 'left', 'fill' => 'both', 'expand' => 1]);
        return $lb;
    }

    protected function listControlsFrame(): Frame
    {
        $f = new Frame($this);

        $btnDel = new Button($f, 'Delete');
        $btnDel->pack(['fill' => 'x']);
        $btnDel->onClick(fn () => $this->deleteItems());

        $btnClear = new Button($f, 'Clear');
        $btnClear->pack(['fill' => 'x']);
        $btnClear->onClick(fn () => $this->listBox->clear());

        $btnAppend = new Button($f, 'Append');
        $btnAppend->pack(['fill' => 'x']);
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