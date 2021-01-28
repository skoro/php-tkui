<?php declare(strict_types=1);

namespace TclTk\Widgets\Ttk;

use TclTk\Options;
use TclTk\Widgets\Buttons\Command;
use TclTk\Widgets\Widget;

/**
 * @property callable $command
 * @property int $underline
 * @property int $width
 * @property string $compound
 */
abstract class GenericButton extends TtkWidget
{
    use Command;

    public function __construct(
        Widget $parent,
        string $widget,
        string $name,
        array $options = []
    ) {
        $command = null;
        if (isset($options['command'])) {
            $command = $options['command'];
            unset($options['command']);
        }

        parent::__construct($parent, $widget, $name, $options);

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
            'state' => null,
        ]);
    }

    public function invoke(): void
    {
        $this->call('invoke');
    }
}