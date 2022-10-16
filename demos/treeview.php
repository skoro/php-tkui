<?php

use Tkui\Widgets\Container;
use Tkui\Widgets\Scrollbar;
use Tkui\Widgets\TreeView\Column;
use Tkui\Widgets\TreeView\Item;
use Tkui\Widgets\TreeView\TreeView;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    private array $data = [
        ['Argentina', 'Buenos Aires', 'ARS'],
        ['Australia', 'Canberra', 'AUD'],
        ['Brazil', 'Brazilia', 'BRL'],
        ['Canada', 'Ottawa', 'CAD'],
        ['China', 'Beijing', 'CNY'],
        ['France', 'Paris', 'EUR'],
        ['Germany', 'Berlin', 'EUR'],
        ['India', 'New Delhi', 'INR'],
        ['Italy', 'Rome', 'EUR'],
        ['Japan', 'Tokyo', 'JPY'],
        ['Mexico', 'Mexico City', 'MXN'],
        ['South Africa', 'Pretoria', 'ZAR'],
        ['United Kingdom', 'London', 'GBP'],
        ['United States', 'Washington, D.C.', 'USD'],
    ];

    private TreeView $tv;

    public function __construct()
    {
        parent::__construct('TreeView demo');
        $this->buildUI();
        $this->addValues();

        $this->tv->onSelect([$this, 'onSelectItem']);
    }

    private function buildUI(): void
    {
        $this->tv = $this->buildTreeView($this);
    }

    private function buildTreeView(Container $parent, array $options = []): TreeView
    {
        $columns = $this->createColumns();

        $tv = new TreeView($parent, $columns, $options);
        $tv->xScrollCommand = new Scrollbar($parent, ['orient' => Scrollbar::ORIENT_HORIZONTAL]);
        $tv->yScrollCommand = new Scrollbar($parent, ['orient' => Scrollbar::ORIENT_VERTICAL]);

        $parent->grid($tv, ['sticky' => 'news', 'row' => 0, 'column' => 0])
            ->rowConfigure($parent, 0, ['weight' => 1])
            ->columnConfigure($parent, 0, ['weight' => 1]);
        $parent->grid($tv->yScrollCommand, ['sticky' => 'nsew', 'row' => 0, 'column' => 1]);
        $parent->grid($tv->xScrollCommand, ['sticky' => 'nsew', 'row' => 1, 'column' => 0]);

        return $tv;
    }

    /**
     * @return array<Column>
     */
    private function createColumns(): array
    {
        return [
            Column::create('country', 'Country'),
            Column::create('capital', 'Capital'),
            Column::create('currency', 'Currency'),
        ];
    }

    private function addValues(): void
    {
        foreach ($this->data as $values) {
            $this->tv->add(new Item($values));
        }
    }

    public function onSelectItem(array $selected): void
    {
        foreach ($selected as $itemId) {
            echo "$itemId" . PHP_EOL;
        }
    }
};

$demo->run();
