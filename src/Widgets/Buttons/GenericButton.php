<?php declare(strict_types=1);

namespace TclTk\Widgets\Buttons;

use TclTk\Options;
use TclTk\Widgets\Buttons\Command;
use TclTk\Widgets\Container;
use TclTk\Widgets\TtkWidget;

/**
 * @property callable $command
 * @property int $underline
 * @property int $width
 * @property string $compound
 */
abstract class GenericButton extends TtkWidget
{
    use Command;

    public function __construct(Container $parent, array $options = [])
    {
        $command = null;
        if (isset($options['command'])) {
            $command = $options['command'];
            unset($options['command']);
        }

        parent::__construct($parent, $options);

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