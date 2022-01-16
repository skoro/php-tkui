<?php

use Tkui\Layouts\Pack;
use Tkui\Widgets\Buttons\Button;
use Tkui\Widgets\Entry;
use Tkui\Widgets\Frame;
use Tkui\Widgets\Label;
use Tkui\Widgets\LabelFrame;
use Tkui\Widgets\Listbox;
use Tkui\Widgets\ListboxItem;
use Tkui\Widgets\Scrollbar;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    private Listbox $listBox;

    public function __construct()
    {
        parent::__construct('Demo Listbox');
        $this->pack([
            $this->helpFrame(),
            $this->newItemFrame(),
        ], [
            'side' => Pack::SIDE_TOP,
            'fill' => Pack::FILL_X,
        ]);
        $this->pack($this->listControlsFrame(), [
            'side' => Pack::SIDE_RIGHT,
            'fill' => Pack::FILL_Y,
        ]);
        $lf = new Frame($this);
        $this->pack($lf, ['side' => Pack::SIDE_LEFT, 'fill' => Pack::FILL_BOTH, 'expand' => true]);
        $this->listBox = $this->createListBox($lf);
        $this->initItems();
    }

    protected function newItemFrame(): Frame
    {
        $f = new Frame($this);
        $f->pack(new Label($f, 'New item:'), ['side' => Pack::SIDE_LEFT]);

        $e = new Entry($f, 'Demo');
        $f->pack($e, ['side' => Pack::SIDE_LEFT, 'fill' => Pack::FILL_X, 'expand' => true]);

        $btn = new Button($f, 'Add');
        $btn->onClick(function () use ($e) {
            $this->addNewItem($e->getValue());
            $e->clear();
        });
        $f->pack($btn, ['side' => Pack::SIDE_RIGHT]);

        $e->bind('Return', fn () => $btn->invoke());

        return $f;
    }

    protected function createListBox(Frame $parent): Listbox
    {
        $l = new Label($parent, 'Selected...');
        $parent->pack($l, ['side' => Pack::SIDE_BOTTOM, 'anchor' => 'w']);

        $lb = new Listbox($parent);
        $lb->yScrollCommand = new Scrollbar($parent);
        $parent->pack($lb->yScrollCommand, ['side' => Pack::SIDE_RIGHT, 'fill' => Pack::FILL_Y]);
        $parent->pack($lb, [
            'side' => Pack::SIDE_LEFT,
            'fill' => Pack::FILL_BOTH,
            'expand' => true,
        ]);

        /** @var ListboxItem[] $items */
        $lb->onSelect(function (array $items) use ($l) {
            $l->text = 'Selected: ' . implode(', ', array_map(fn ($item) => $item->value(), $items));
        });

        return $lb;
    }

    protected function listControlsFrame(): Frame
    {
        $f = new Frame($this);

        $btnDel = new Button($f, 'Delete');
        $btnDel->onClick(fn () => $this->deleteItems());
        $this->bind('Control-d', [$btnDel, 'invoke']);

        $btnClear = new Button($f, 'Clear');
        $btnClear->onClick(fn () => $this->listBox->clear());
        $this->bind('Control-l', [$btnClear, 'invoke']);

        $btnAppend = new Button($f, 'Append');
        $btnAppend->onClick(fn () => $this->initItems());
        $this->bind('Control-a', [$btnAppend, 'invoke']);

        $f->pack([$btnDel, $btnClear, $btnAppend], ['fill' => 'x']);

        return $f;
    }

    protected function helpFrame(): LabelFrame
    {
        $f = new LabelFrame($this, 'Help');
        $f->pack(new Label($f, 'Button demo'));
        $text = [
            'Use the following shortcuts:',
            '* Control-D = delete item',
            '* Control-L = clear items',
            '* Control-A = append items'
        ];
        foreach ($text as $t) {
            $f->pack(new Label($f, $t), [
                'side' => Pack::SIDE_TOP,
                'anchor' => 'w',
            ]);
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