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
        $t->wrap = Text::WRAP_WORD;
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
            ->setStyle('bgstipple', new TextStyle([
                'background' => Color::fromName('black'),
                'borderWidth' => 0,
                'bgstipple' => 'gray12',
            ]))
            ->setStyle('fgstipple', new TextStyle([
                'fgstipple' => 'gray50',
            ]))
            ->setStyle('underline', new TextStyle([
                'underline' => true,
            ]))
            ->setStyle('overstrike', new TextStyle([
                'overstrike' => true,
            ]))
            ->setStyle('right', new TextStyle([
                'justify' => TextStyle::JUSTIFY_RIGHT,
            ]))
            ->setStyle('center', new TextStyle([
                'justify' => TextStyle::JUSTIFY_CENTER,
            ]))
            ->setStyle('sub', new TextStyle([
                'offset' => '4p',
                'font' => new TkFont('Courier', 10),
            ]))
            ->setStyle('super', new TextStyle([
                'offset' => '-2p',
                'font' => new TkFont('Courier', 10),
            ]))
            ->setStyle('margins', new TextStyle([
                'lmargin1' => '12m',
                'lmargin2' => '6m',
                'rmargin' => '10m',
            ]))
            ->setStyle('spacing', new TextStyle([
                'spacing1' => '10p',
                'spacing2' => '2p',
                'lmargin1' => '12m',
                'lmargin2' => '6m',
                'rmargin' => '10m',
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
            ->append(".\n")
            ->appendWithStyle("\n3. Stippling.", 'big')
            ->append('  You can cause either the ')
            ->appendWithStyle('background', 'bgstipple')
            ->append(' or ')
            ->appendWithStyle('foreground', 'fgstipple')
            ->append("information to be drawn with a stipple fill instead of a solid fill.\n")
            ->appendWithStyle("\n4. Underlining.", 'big')
            ->append('  You can ')
            ->appendWithStyle('underline', 'underline')
            ->append(" ranges of text.\n")
            ->appendWithStyle("\n5. Overstrikes.", 'big')
            ->append('  You can ')
            ->appendWithStyle('draw lines through', 'overstrike')
            ->append(" ranges of text.\n")
            ->appendWithStyle("\n6. 3-D effects.", 'big')
            ->append('  You can arrange for the background to be drawn with a border that makes characters appear either ')
            ->appendWithStyle('raised', 'raised')
            ->append(' or ')
            ->appendWithStyle('sunken', 'sunken')
            ->appendWithStyle("\n\n7. Justification.", 'big')
            ->append(" You can arrange for lines to be displayed\n")
            ->append("left-justified,\n")
            ->appendWithStyle("right-justified, or\n", 'right')
            ->appendWithStyle("centered.\n", 'center')
            ->appendWithStyle("\n8. Superscripts and subscripts.", 'big')
            ->append(" You can control the vertical\n")
            ->append("position of text to generate superscript effects like 10")
            ->appendWithStyle("n", 'super')
            ->append(" or\nsubscript effects like X")
            ->appendWithStyle("i", 'sub')
            ->append(".\n")
            ->appendWithStyle("\n9. Margins.", 'big')
            ->append(" You can control the amount of extra space left")
            ->append(" on\neach side of the text:\n")
            ->appendWithStyle("This paragraph is an example of the use of ", 'margins')
            ->appendWithStyle("margins.  It consists of a single line of text ", 'margins')
            ->appendWithStyle("that wraps around on the screen.  There are two ", 'margins')
            ->appendWithStyle("separate left margin values, one for the first ", 'margins')
            ->appendWithStyle("display line associated with the text line, ", 'margins')
            ->appendWithStyle("and one for the subsequent display lines, which ", 'margins')
            ->appendWithStyle("occur because of wrapping.  There is also a ", 'margins')
            ->appendWithStyle("separate specification for the right margin, ", 'margins')
            ->appendWithStyle("which is used to choose wrap points for lines.\n", 'margins')
            ->appendWithStyle("\n10. Spacing.", 'big')
            ->append(" You can control the spacing of lines with three\n")
            ->append("separate parameters.  \"Spacing1\" tells how much ")
            ->append("extra space to leave\nabove a line, \"spacing3\" ")
            ->append("tells how much space to leave below a line,\nand ")
            ->append("if a text line wraps, \"spacing2\" tells how much ")
            ->append("space to leave\nbetween the display lines that ")
            ->append("make up the text line.\n")
            ->appendWithStyle("These indented paragraphs illustrate how spacing ", 'spacing')
            ->appendWithStyle("can be used.  Each paragraph is actually a ", 'spacing')
            ->appendWithStyle("single line in the text widget, which is ", 'spacing')
            ->appendWithStyle("word-wrapped by the widget.\n", 'spacing')
            ->appendWithStyle("Spacing1 is set to 10 points for this text, ", 'spacing')
            ->appendWithStyle("which results in relatively large gaps between ", 'spacing')
            ->appendWithStyle("the paragraphs.  Spacing2 is set to 2 points, ", 'spacing')
            ->appendWithStyle("which results in just a bit of extra space ", 'spacing')
            ->appendWithStyle("within a pararaph.  Spacing3 isn't used ", 'spacing')
            ->appendWithStyle("in this example.\n", 'spacing')
            ->appendWithStyle("To see where the space is, select ranges of ", 'spacing')
            ->appendWithStyle("text within these paragraphs.  The selection ", 'spacing')
            ->appendWithStyle("highlight will cover the extra space.", 'spacing')
        ;
    }
};

$demo->run();