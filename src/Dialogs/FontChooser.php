<?php declare(strict_types=1);

namespace TclTk\Dialogs;

use LogicException;
use TclTk\App;
use TclTk\Options;
use TclTk\Widgets\Widget;
use TclTk\Widgets\Window;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/fontchooser.htm
 * 
 * Please keep in mind, the font chooser is different among other dialogs.
 * It doesn't return its value through showModal().
 * It doesn't emit onCancel event.
 * The dialog mimics a widget for register the callback.
 *
 * @property string $title
 * @property Window $parent
 */
class FontChooser extends Dialog implements Widget
{
    private string $onSelectCallback;
    private string $id;
    private App $app;

    public function __construct(Window $parent, array $options = [])
    {
        parent::__construct($parent, $options);
        $this->id = uniqid();
        $this->onSelectCallback = $parent->registerCallback($this, [$this, 'onSelect']);
        $this->app = $parent->app();
    }

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return parent::createOptions()->mergeAsArray([
            'title' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function command(): string
    {
        return 'fontchooser';
    }

    /**
     * @return void
     */
    public function showModal()
    {
        $options = clone $this->getOptions();
        $options->mergeAsArray(['command' => $this->onSelectCallback]);
        $this->call('configure', ...$options->asStringArray());
        $this->call('show');
    }

    public function path(): string
    {
        return 'fontchooser_' . $this->id();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function widget(): string
    {
        return 'tk fontchooser';
    }

    public function window(): Window
    {
        return $this->parent;
    }

    public function options(): Options
    {
        return $this->getOptions();
    }

    public function parent(): Widget
    {
        return $this->parent;
    }

    public function bind(string $event, ?callable $callback): Widget
    {
        throw new LogicException('Cannot bind event to font dialog.');
    }

    public function onSelect(Widget $self, string $fontSpec)
    {
        // TODO: make font instance from $fontSpec.
        $this->doSuccess($fontSpec);
    }

    protected function call(...$args)
    {
        return $this->app->tclEval('tk', $this->command(), ...$args);
    }
}