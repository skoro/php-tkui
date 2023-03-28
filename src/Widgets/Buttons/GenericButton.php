<?php declare(strict_types=1);

namespace Tkui\Widgets\Buttons;

use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Common\Clickable;
use Tkui\Widgets\Common\WithCommand;
use Tkui\Widgets\Common\WithUnderlinedLabel;
use Tkui\Widgets\Container;
use Tkui\Widgets\TtkWidget;

/**
 * @property callable $command
 * @property int $underline
 * @property int $width
 * @property string $compound
 * @property string $text
 */
abstract class GenericButton extends TtkWidget implements Clickable
{
    use WithCommand;
    use WithUnderlinedLabel;

    public function __construct(Container $parent, array|Options $options = [])
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
    protected function createOptions(): Options
    {
        return new TclOptions([
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