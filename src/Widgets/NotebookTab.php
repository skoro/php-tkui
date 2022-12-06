<?php declare(strict_types=1);

namespace Tkui\Widgets;

use SplSubject;
use Tkui\Options;
use Tkui\Support\WithObservable;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Common\WithUnderlinedLabel;

/**
 * @property string $state
 * @property string $sticky
 * @property string $padding TODO
 * @property string $text
 * @property string $image TODO
 * @property string $compound TODO
 * @property int $underline
 *
 * @todo Just options instance ?
 */
class NotebookTab implements SplSubject
{
    use WithUnderlinedLabel;
    use WithObservable;

    private Widget $container;
    private Options $options;

    public function __construct(Widget $container, string $title, array|Options $options = [])
    {
        $optionsObj = $this->createOptions()->with($options);
        $optionsObj->text = $this->removeUnderlineChar($title);
        $optionsObj->underline = $this->detectUnderlineIndex($title);
        $this->options = $this->createOptions()->with($optionsObj);
        $this->container = $container;
    }

    protected function createOptions(): Options
    {
        return new TclOptions([
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
