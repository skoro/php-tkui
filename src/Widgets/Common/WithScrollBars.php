<?php

declare(strict_types=1);

namespace Tkui\Widgets\Common;

use Tkui\Exceptions\InvalidValueTypeException;
use Tkui\Widgets\Exceptions\FontNotSupportedException;
use Tkui\Widgets\Scrollbar;

/**
 * Provides 'xScrollCommand' and 'yScrollCommand' to set/get a Scrollbar instance.
 *
 * Used for scrollable containers in tk and ttk implementations.
 */
trait WithScrollBars
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

    /**
     * @throws InvalidValueTypeException When the value is not a Scrollbar instance.
     * @throws FontNotSupportedException
     */
    public function __set($name, $value)
    {
        switch ($name) {
            case 'xScrollCommand':
            case 'yScrollCommand':
                if (!($value instanceof Scrollbar)) {
                    throw new InvalidValueTypeException(Scrollbar::class, $value);
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
