<?php declare(strict_types=1);

namespace TclTk\Widgets\Ttk;

use TclTk\Options;
use TclTk\Widgets\Buttons\Command;
use TclTk\Widgets\Widget;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_button.htm
 */
class Button extends TtkWidget
{
    use Command;

    public function __construct(Widget $parent, string $title, array $options = [])
    {
        $options['text'] = $title;

        $command = null;
        if (isset($options['command'])) {
            $command = $options['command'];
            unset($options['command']);
        }

        parent::__construct($parent, 'ttk::button', 'b', $options);

        if ($command !== null) {
            $this->command = $command;
        }
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'text' => null,
            'compound' => null,
            'image' => null,
            'textVariable' => null,
            'underline' => null,
            'width' => null,
            'command' => null,
            'default' => null,
        ]);
    }

    public function invoke(): void
    {
        $this->call('invoke');
    }
}