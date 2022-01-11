<?php declare(strict_types=1);

namespace Tkui\Dialogs;

use Tkui\FontManager;
use Tkui\Options;
use Tkui\Widgets\Container;
use Tkui\Widgets\Widget;
use Tkui\Windows\Window;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/fontchooser.htm
 * 
 * Please keep in mind, the font chooser is different among other dialogs.
 * It doesn't return its value through showModal().
 * It doesn't emit onCancel event.
 * The dialog mimics a widget for register the callback.
 *
 * <example>
 * use PhpGui\Dialogs\FontDialog;
 * use PhpGui\Font;
 *
 * $dlg = new FontDialog($parent, $fontManager);
 * $dlg->onSuccess(function (Font $font) {
 *     //
 * });
 * </example>
 *
 * @property string $title
 * @property Window $parent
 */
class FontDialog extends Dialog implements Widget
{
    private string $onSelectCallback;
    private string $id;
    private FontManager $fontManager;

    public function __construct(Window $parent, FontManager $fontManager, array $options = [])
    {
        parent::__construct($parent, $options);
        $this->id = uniqid();
        $this->fontManager = $fontManager;
        $this->onSelectCallback = $parent->getEval()->registerCallback($this, [$this, 'onSelect']);
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

    public function options(): Options
    {
        return $this->getOptions();
    }

    public function parent(): Container
    {
        return $this->parent;
    }

    public function onSelect(Widget $self, string $fontSpec)
    {
        $font = $this->fontManager->createFontFromString('{' . $fontSpec . '}');
        $this->doSuccess($font);
    }

    protected function call(...$args)
    {
        return $this->parent()->getEval()->tclEval('tk', $this->command(), ...$args);
    }

    public function getFontManager(): FontManager
    {
        return $this->fontManager;
    }
}