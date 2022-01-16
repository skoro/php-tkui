<?php declare(strict_types=1);

namespace Tkui\Widgets\Buttons;

use Tkui\Options;
use Tkui\Widgets\Container;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_button.htm
 *
 * @property string $text
 * @property callable $command
 * @property string $default
 * @property int $underline
 * @property int $width
 * @property string $compound
 */
class Button extends GenericButton
{
    protected string $widget = 'ttk::button';
    protected string $name = 'b';

    /**
     * @inheritdoc
     */
    public function __construct(Container $parent, string $title, array $options = [])
    {
        $options['text'] = $title;
        parent::__construct($parent, $options);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return parent::initWidgetOptions()->mergeAsArray([
            'default' => null,
        ]);
    }
}