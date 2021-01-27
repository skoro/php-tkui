<?php declare(strict_types=1);

namespace TclTk\Widgets;

use InvalidArgumentException;

abstract class ScrollableWidget extends TkWidget
{
    private Scrollbar $xScroll;
    private Scrollbar $yScroll;

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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