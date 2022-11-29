<?php declare(strict_types=1);

namespace Tkui\Layouts;

use Tkui\Options;
use Tkui\Widgets\Widget;

/**
 * Layout manager interface.
 *
 * Layout manager arranges widgets in the container.
 */
interface LayoutManager
{
    /**
     * Pack the widget.
     */
    public function add(Widget $widget, array|Options $options = []): self;

    /**
     * Remove the widget.
     */
    public function remove(Widget $widget): self;
}