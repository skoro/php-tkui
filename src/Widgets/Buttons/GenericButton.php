<?php declare(strict_types=1);

namespace Tkui\Widgets\Buttons;

use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Common\Clickable;
use Tkui\Widgets\Common\WithCallbacks;
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
    use WithCallbacks;
    use WithUnderlinedLabel;

    /** @var callable|null */
    private $commandCallback = null;

    public function __construct(Container $parent, array|Options $options = [])
    {
        if (isset($options['text'])) {
            $title = $options['text'];
            $options['text'] = $this->removeUnderlineChar($title);
            $options['underline'] = $this->detectUnderlineIndex($title);
        }

        parent::__construct($parent, $options);
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
    public function invoke(): static
    {
        $this->call('invoke');
        return $this;
    }

    public function onClick(callable $callback): static
    {
        $this->command = $callback;
        return $this;
    }
}
