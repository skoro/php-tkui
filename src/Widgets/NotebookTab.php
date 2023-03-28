<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Common\SubjectItem;
use Tkui\Widgets\Common\WithUnderlinedLabel;

/**
 * @property string $state
 * @property string $sticky
 * @property string $padding TODO
 * @property string $text
 * @property string $image TODO
 * @property string $compound TODO
 * @property int $underline
 */
class NotebookTab extends SubjectItem
{
    use WithUnderlinedLabel;

    private Widget $container;

    public function __construct(Widget $container, string $title, array|Options $options = [])
    {
        parent::__construct($options);
        $this->container = $container;
        $this->text = $this->removeUnderlineChar($title);
        $this->underline = $this->detectUnderlineIndex($title);
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

    public function container(): Widget
    {
        return $this->container;
    }
}
