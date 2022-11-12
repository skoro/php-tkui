<?php declare(strict_types=1);

namespace Tkui\Widgets;

use SplSubject;
use Tkui\Observable;
use Tkui\Options;
use Tkui\Widgets\Common\HasUnderlinedLabel;

/**
 * @property string $state
 * @property string $sticky
 * @property string $padding TODO
 * @property string $text
 * @property string $image TODO
 * @property string $compound TODO
 * @property int $underline
 */
class NotebookTab implements SplSubject
{
    use HasUnderlinedLabel;
    use Observable;

    private Widget $container;
    private Options $options;

    public function __construct(Widget $container, string $title, array $options = [])
    {
        $this->container = $container;
        $options['text'] = $this->removeUnderlineChar($title);
        $options['underline'] = $this->detectUnderlineIndex($title);
        $this->options = $this->initWidgetOptions()->mergeAsArray($options);
    }

    protected function initWidgetOptions(): Options
    {
        return new Options([
            'state' => null,
            'sticky' => null,
            'padding' => null,
            'text' => null,
            'image' => null,
            'compound' => null,
            'underline' => null,
        ]);
    }

    public function __get($name)
    {
        return $this->options->$name;
    }

    public function __set($name, $value)
    {
        $this->options->$name = $value;
        $this->notify();
    }

    public function options(): Options
    {
        return $this->options;
    }

    public function container(): Widget
    {
        return $this->container;
    }
}
