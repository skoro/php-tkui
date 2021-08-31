<?php declare(strict_types=1);

namespace PhpGui\Widgets\Buttons;

use PhpGui\Options;
use PhpGui\Widgets\Common\Clickable;
use PhpGui\Widgets\Common\DetectUnderline;
use PhpGui\Widgets\Container;
use PhpGui\Widgets\TtkWidget;

/**
 * @property callable $command
 * @property int $underline
 * @property int $width
 * @property string $compound
 * @property string $text
 */
abstract class GenericButton extends TtkWidget implements Clickable
{
    use Command;
    use DetectUnderline;

    public function __construct(Container $parent, array $options = [])
    {
        $command = null;
        if (isset($options['command'])) {
            $command = $options['command'];
            unset($options['command']);
        }

        if (isset($options['text'])) {
            $title = $options['text'];
            $options['text'] = $this->removeUnderlineChar($title);
            $options['underline'] = $this->detectUnderlineIndex($title);
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

    /**
     * @inheritdoc
     */
    public function invoke(): self
    {
        $this->call('invoke');
        return $this;
    }
}