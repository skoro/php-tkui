<?php declare(strict_types=1);

namespace Tkui\Widgets;

use SplObserver;
use SplSubject;
use Tkui\Options;
use Tkui\Widgets\Common\DetectUnderline;

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
    use DetectUnderline;

    private Widget $container;
    private Options $options;

    /** @var SplObserver[] */
    private array $observers = [];

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

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(SplObserver $observer): void
    {
        if (($index = array_search($observer, $this->observers, true)) !== false) {
            unset($this->observers[$index]);
        }
    }
}