<?php

use Tkui\Widgets\Container;
use Tkui\Widgets\Scrollbar;
use Tkui\Widgets\TreeView\Column;
use Tkui\Widgets\TreeView\Header;
use Tkui\Widgets\TreeView\TreeView;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    private TreeView $tv;

    public function __construct()
    {
        parent::__construct('TreeView demo');
        $this->buildUI();
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
            new Column('country', new Header('Country')),
            new Column('capital', new Header('Capital')),
            new Column('id', new Header('Currenry')),
        ];
    }
};

$demo->run();
