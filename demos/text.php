<?php

use PhpGui\Color;
use PhpGui\Layouts\Pack;
use PhpGui\TclTk\TkFont;
use PhpGui\Widgets\Buttons\Button;
use PhpGui\Widgets\Frame;
use PhpGui\Widgets\Scrollbar;
use PhpGui\Widgets\Text\Text;
use PhpGui\Widgets\Text\TextStyle;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    private Text $text;

    public function __construct()
    {
        parent::__construct('Demo Textbox');
        $this->createActions();
        $f = new Frame($this);
        $this->text = $this->createTextbox($f);
        $this->pack($f, ['expand' => true, 'fill' => Pack::FILL_BOTH]);
        $this->registerTextStyles();
        $this->fillText();
    }

    protected function createActions(): void
    {
        $f = new Frame($this);
        $this->pack($f, ['side' => Pack::SIDE_TOP, 'fill' => Pack::FILL_X]);

        $b = new Button($f, 'Clear');
        $b->onClick(function () {
            $this->text->clear();
        });
        $f->pack($b, ['side' => Pack::SIDE_LEFT]);
    }

    protected function createTextbox(Frame $parent): Text
    {
        $t = new Text($parent);
        $t->yScrollCommand = new Scrollbar($parent);
        $t->xScrollCommand = new Scrollbar($parent, ['orient' => Scrollbar::ORIENT_HORIZONTAL]);
        $parent->grid($t, ['sticky' => 'nsew', 'row' => 0, 'column' => 0])
               ->rowConfigure($parent, 0, ['weight' => 1])
               ->columnConfigure($parent, 0, ['weight' => 1]);
        $parent->grid($t->yScrollCommand, ['sticky' => 'nsew', 'row' => 0, 'column' => 1]);
        $parent->grid($t->xScrollCommand, ['sticky' => 'nsew', 'row' => 1, 'column' => 0]);
        return $t;
    }

    protected function registerTextStyles()
    {
        $this->text
            ->setStyle('big', new TextStyle([
                'font' => new TkFont('Courier', 12, TkFont::BOLD),
            ]))
            ->setStyle('verybig', new TextStyle([
                'font' => new TkFont('Helvetica', 24, TkFont::BOLD),
            ]))
            ->setStyle('tiny', new TextStyle([
                'font' => new TkFont('Times', 8, TkFont::BOLD),
            ]))
            ->setStyle('color1', new TextStyle([
                'background' => Color::fromHex('#a0b7ce'),
            ]))
            ->setStyle('color2', new TextStyle([
                'foreground' => Color::fromName('red'),
            ]))
            ->setStyle('raised', new TextStyle([
                'relief' => TextStyle::RELIEF_RAISED,
                'borderWidth' => 1,
            ]))
            ->setStyle('sunken', new TextStyle([
                'relief' => TextStyle::RELIEF_SUNKEN,
                'borderWidth' => 1,
            ]))
        ;
    }

    protected function fillText(): void
    {
        $this->text
            ->appendWithStyle("\n1. Font.", 'big')
            ->append('  You can choose any system font, ')
            ->appendWithStyle('large', 'verybig')
            ->append(' or ')
            ->appendWithStyle('small', 'tiny')
            ->append(".\n")
            ->appendWithStyle("\n2. Color", 'big')
            ->append('  You can change either the ')
            ->appendWithStyle('background', 'color1')
            ->append(' or ')
            ->appendWithStyle('foreground', 'color2')
            ->append("\ncolor, or ")
            ->appendWithStyle('both', 'color1', 'color2')
            ->append('.\n')
            ->appendWithStyle("\n3. Stippling.", 'big')
        ;
    }
};

$demo->run();