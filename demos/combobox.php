<?php

use Tkui\Color;
use Tkui\Layouts\Pack;
use Tkui\Widgets\Buttons\Button;
use Tkui\Widgets\Buttons\CheckButton;
use Tkui\Widgets\Combobox;
use Tkui\Widgets\Entry;
use Tkui\Widgets\Frame;
use Tkui\Widgets\Label;
use Tkui\Widgets\LabelFrame;
use Tkui\Widgets\RadioGroup;
use Tkui\Widgets\Scrollbar;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    private array $themes;

    public function __construct()
    {
        parent::__construct('Combobox Demo');
        $this->themes = $this->app->getThemeManager()->themes();

        $this->pack([
            $this->themeSelector(),
            $this->plainSelector(),
            $this->themeDemo(),
        ], [
            'padx' => 6,
            'pady' => 6,
            'fill' => Pack::FILL_X,
        ]);
    }

    protected function themeSelector(): Frame
    {
        $f = new LabelFrame($this, 'Theme:');
        $l = new Label($f, 'Theme selector');
        $l->background = Color::fromName('black');
        $l->foreground = Color::fromName('white');
        $f->pack($l);
        $themes = new Combobox($f, $this->themes, ['state' => 'readonly']);
        $themes->onSelect([$this, 'changeTheme']);
        $f->pack($themes, ['padx' => 4, 'pady' => 4]);

        $cur = $this->app->getThemeManager()->currentTheme();
        if (($idx = array_search($cur, $this->themes)) !== false) {
            $themes->setSelection($idx);
        }

        return $f;
    }

    protected function plainSelector(): Frame
    {
        $f = new LabelFrame($this, 'Combobox:');
        $l = new Label($f, 'Selected...');
        $f->pack($l);
        $cb = new Combobox($f, ['Item 1', 'Item 2', 'Item 3']);
        $cb->onSelect(fn () => $l->text = $cb->getValue());
        $f->pack($cb, ['padx' => 4, 'pady' => 4, 'fill' => Pack::FILL_X]);
        return $f;
    }

    protected function themeDemo(): Frame
    {
        $f = new LabelFrame($this, 'Theme demo:');
        $f->pack([
            new Button($f, 'Button'),
            new Entry($f, 'value...'),
        ], [
            'side' => Pack::SIDE_TOP,
            'pady' => 4,
        ]);
        $f->pack(new Scrollbar($f, ['orient' => Scrollbar::ORIENT_HORIZONTAL]), [
            'side' => Pack::SIDE_TOP,
            'fill' => Pack::FILL_X,
            'expand' => true,
            'padx' => 4,
            'pady' => 4,
        ]);
        $f->pack([
            new CheckButton($f, 'Enabled checkbutton', false),
            new CheckButton($f, 'Disabled checkbutton', true),
        ], [
            'padx' => 4,
            'pady' => 4,
        ]);
        $rg = new RadioGroup($f);
        $f->pack([
            $rg->add('Radio button', 1),
            $rg->add('Radio button', 2),
            $rg->add('Radio button', 3),
            $rg,
        ], ['fill' => Pack::FILL_X]);
        // $rg->pack()->fillX()->manage();
        return $f;
    }

    public function changeTheme(int $index)
    {
        $theme = $this->themes[$index];
        $this->app->getThemeManager()->useTheme($theme);
    }
};

$demo->run();