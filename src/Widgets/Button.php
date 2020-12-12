<?php declare(strict_types=1);

namespace TclTk\Widgets;

class Button extends Widget
{
    public function __construct(TkWidget $parent, string $title, array $options = [])
    {
        parent::__construct($parent, 'b', $options);
        $this['text'] = $title;
        $this->make('button');
    }
}