<?php

use Tkui\Widgets\Container;
use Tkui\Widgets\Scrollbar;
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
        $tv = new TreeView($parent, $options);
        $tv->xScrollCommand = new Scrollbar($parent, ['orient' => Scrollbar::ORIENT_HORIZONTAL]);
        $tv->yScrollCommand = new Scrollbar($parent, ['orient' => Scrollbar::ORIENT_VERTICAL]);

        $parent->grid($tv, ['sticky' => 'news', 'row' => 0, 'column' => 0])
            ->rowConfigure($parent, 0, ['weight' => 1])
            ->columnConfigure($parent, 0, ['weight' => 1]);
        $parent->grid($tv->yScrollCommand, ['sticky' => 'nsew', 'row' => 0, 'column' => 1]);
        $parent->grid($tv->xScrollCommand, ['sticky' => 'nsew', 'row' => 1, 'column' => 0]);

        return $tv;
    }
};

$demo->run();
