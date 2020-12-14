<?php declare(strict_types=1);

namespace TclTk\Widgets;

class Label extends Widget
{
    public function __construct(TkWidget $parent, string $title, array $options = [])
    {
        parent::__construct($parent, 'lb', $options);
        $this['text'] = $title;
        $this->make('label');
    }
}