<?php

declare(strict_types=1);

namespace Tkui\Widgets\Common;

use InvalidArgumentException;
use Tkui\Widgets\Scrollbar;

trait HasScrollBars
{
    private Scrollbar $xScroll;
    private Scrollbar $yScroll;

    public function __get($name)
    {
        switch ($name) {
            case 'xScrollCommand':
                return $this->xScroll;
            case 'yScrollCommand':
                return $this->yScroll;
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'xScrollCommand':
            case 'yScrollCommand':
                if (!($value instanceof Scrollbar)) {
                    throw new InvalidArgumentException("$name must be an instance of " . Scrollbar::class);
                }
                switch ($name) {
                    case 'xScrollCommand':
                        $this->xScroll = $value;
                        break;
                    case 'yScrollCommand':
                        $this->yScroll = $value;
                        break;
                }
                parent::__set($name, $value->path() . ' set');
                $value->command = $this;
                break;

            default:
                parent::__set($name, $value);
        }
    }
}
