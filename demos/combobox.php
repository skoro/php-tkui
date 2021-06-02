<?php

use PhpGui\Widgets\Buttons\Button;
use PhpGui\Widgets\Buttons\CheckButton;
use PhpGui\Widgets\Combobox;
use PhpGui\Widgets\Entry;
use PhpGui\Widgets\Frame;
use PhpGui\Widgets\Label;
use PhpGui\Widgets\LabelFrame;
use PhpGui\Widgets\RadioGroup;
use PhpGui\Widgets\Scrollbar;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    private array $themes;

    public function __construct()
    {
        parent::__construct('Combobox Demo');
        $this->themes = $this->app->getThemeManager()->themes();
        $this->themeSelector()->pack()->pad(6, 6)->fillX()->manage();
        $this->plainSelector()->pack()->pad(6, 6)->fillX()->manage();
        $this->themeDemo()->pack()->pad(6, 6)->fillX()->manage();
    }

    protected function themeSelector(): Frame
    {
        $f = new LabelFrame($this, 'Theme:');
        $l = new Label($f, 'Combobox is disabled.');
        $l->pack()->manage();
        $themes = new Combobox($f, $this->themes, ['state' => 'readonly']);
        $themes->pack()->fillX()->pad(4, 4)->manage();
        $themes->onSelect([$this, 'changeTheme']);

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
        $l->pack()->manage();
        $cb = new Combobox($f, ['Item 1', 'Item 2', 'Item 3']);
        $cb->onSelect(fn () => $l->text = $cb->getValue());
        $cb->pack()->fillX()->pad(4, 4)->manage();
        return $f;
    }

    protected function themeDemo(): Frame
    {
        $f = new LabelFrame($this, 'Theme demo:');
        (new Button($f, 'Button'))->pack()->sideTop()->padY(4)->manage();
        (new Entry($f, 'value...'))->pack()->sideTop()->padY(4)->manage();
        (new Scrollbar($f, ['orient' => Scrollbar::ORIENT_HORIZONTAL]))
            ->pack()->sideTop()->pad(4, 4)->fillX()->expand()->manage();
        (new CheckButton($f, 'Enabled checkbutton', false))->pack()->pad(4, 4)->manage();
        (new CheckButton($f, 'Disabled checkbutton', true))->pack()->pad(4, 4)->manage();
        $rg = new RadioGroup($f);
        $rg->add('Radio button', 1)->pack(['fill' => 'x'])->manage();
        $rg->add('Radio button', 2)->pack(['fill' => 'x'])->manage();
        $rg->add('Radio button', 3)->pack(['fill' => 'x'])->manage();
        $rg->pack()->fillX()->manage();
        return $f;
    }

    public function changeTheme(int $index)
    {
        $theme = $this->themes[$index];
        $this->app->getThemeManager()->useTheme($theme);
    }
};

$demo->run();