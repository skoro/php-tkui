<?php declare(strict_types=1);

namespace Tkui\Widgets\Menu;

use Tkui\Image;
use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Common\Clickable;
use Tkui\Widgets\Common\WithUnderlinedLabel;
use Tkui\Widgets\Consts\Compound;

/**
 * Implements a simple menu item with a callback.
 *
 * @property string $label
 * @property callable $command
 * @property int $underline
 * @property string $accelerator
 * @property Image $image
 * @property string $compound How to show the menu item when both label and image are present.
 */
class MenuItem extends CommonItem implements Clickable
{
    use WithUnderlinedLabel;

    /**
     * @param callable|null $callback
     */
    public function __construct(string $label, $callback = null, array|Options $options = [])
    {
        parent::__construct($options);
        $this->underline = $this->detectUnderlineIndex($label);
        $this->label = $this->removeUnderlineChar($label);
        $this->command = $callback;
    }

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return new TclOptions([
            'label' => null,
            'command' => null,
            'underline' => null,
            'accelerator' => null,
            'image' => null,
            'compound' => Compound::LEFT,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function type(): string
    {
        return 'command';
    }

    /**
     * @inheritdoc
     */
    public function onClick(callable $callback): self
    {
        $this->command = $callback;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function invoke(): self
    {
        return $this;
    }
}