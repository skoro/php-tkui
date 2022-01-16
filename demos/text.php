<?php

use Tkui\Color;
use Tkui\Image;
use Tkui\Layouts\Pack;
use Tkui\TclTk\TkFont;
use Tkui\Widgets\Buttons\Button;
use Tkui\Widgets\Entry;
use Tkui\Widgets\Frame;
use Tkui\Widgets\Scrollbar;
use Tkui\Widgets\Text\SearchOptions;
use Tkui\Widgets\Text\Text;
use Tkui\Widgets\Text\TextIndex;
use Tkui\Widgets\Text\TextStyle;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    private Text $text;
    private Image $logo;

    public function __construct()
    {
        parent::__construct('Demo Textbox');
        $this->createActions();
        $this->logo = $this->loadImage('nepomuk.png');
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

        $searchValue = new Entry($f);
        $searchValue->onSubmit(function (Entry $self) {
            $this->search($self->getValue());
        });

        $searchExec = new Button($f, 'Search');
        $searchExec->onClick(function () use ($searchValue) {
            if ($this->search($searchValue->getValue()) === false) {
                $searchValue->focus();
            }
        });

        $f->pack([$searchValue, $searchExec], ['side' => Pack::SIDE_LEFT, 'pady' => 2, 'padx' => 2]);
    }

    protected function search(string $value): bool
    {
        if ($value === '') {
            return false;
        }

        $style = $this->text->getStyle('searchHighlight');
        $style->clear(TextIndex::start(), TextIndex::end());

        $options = new SearchOptions();
        $options->setDirection(SearchOptions::FORWARD);
        $options->setAllMatches(true);

        $indexes = $this->text->search($value, $options, TextIndex::start());
        foreach ($indexes as $index) {
            $style->add($index, $index->addChars(mb_strlen($value)));
        }

        return true;
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
        $this->text->createStyle('big')->font = new TkFont('Courier', 12, TkFont::BOLD);
        $this->text->createStyle('verybig')->font = new TkFont('Helvetica', 24, TkFont::BOLD);
        $this->text->createStyle('tiny')->font = new TkFont('Times', 8, TkFont::BOLD);
        $this->text->createStyle('color1')->background = Color::fromHex('#a0b7ce');
        $this->text->createStyle('color2')->foreground = Color::fromName('red');
        $this->text->createStyle('raised', [
                'relief' => TextStyle::RELIEF_RAISED,
                'borderWidth' => 1,
        ]);
        $this->text->createStyle('sunken', [
                'relief' => TextStyle::RELIEF_SUNKEN,
                'borderWidth' => 1,
        ]);
        $this->text->createStyle('bgstipple', [
                'background' => Color::fromName('black'),
                'borderWidth' => 0,
                'bgstipple' => 'gray12',
        ]);
        $this->text->createStyle('fgstipple')->fgstipple = 'gray50';
        $this->text->createStyle('underline')->underline = true;
        $this->text->createStyle('overstrike')->overstrike = true;
        $this->text->createStyle('right')->justify = TextStyle::JUSTIFY_RIGHT;
        $this->text->createStyle('center')->justify = TextStyle::JUSTIFY_CENTER;
        $this->text->createStyle('sub', [
                'offset' => '4p',
                'font' => new TkFont('Courier', 10),
        ]);
        $this->text->createStyle('super', [
                'offset' => '-2p',
                'font' => new TkFont('Courier', 10),
        ]);
        $this->text->createStyle('margins', [
                'lmargin1' => '12m',
                'lmargin2' => '6m',
                'rmargin' => '10m',
        ]);
        $this->text->createStyle('spacing', [
                'spacing1' => '10p',
                'spacing2' => '2p',
                'lmargin1' => '12m',
                'lmargin2' => '6m',
                'rmargin' => '10m',
        ]);
        $this->text->createStyle('searchHighlight', [
            'background' => Color::fromName('yellow'),
        ]);
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
        $this->text->createImage(new TextIndex(2, 10), $this->logo);
    }
};

$demo->run();