<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\TclTk\TkFont;
use Tkui\Tests\TestCase;
use Tkui\Widgets\Label;

class LabelTest extends TestCase
{
    /** @test */
    public function label_created()
    {
        $this->tclEvalTest(1, [['ttk::label', $this->checkWidget('.lb'), '-text', '{Test}']]);

        new Label($this->createWindowStub(), 'Test');
    }

    /** @test */
    public function text_changed()
    {
        $this->tclEvalTest(2, [
            ['ttk::label', $this->checkWidget('.lb'), '-text', '{Test}'],
            [$this->checkWidget('.lb'), 'configure', '-text', '{New text}']
        ]);

        $l = new Label($this->createWindowStub(), 'Test');
        $l->text = 'New text';
    }

    /** @test */
    public function set_font_as_property()
    {
        $this->tclEvalTest(2, [
            ['ttk::label', $this->checkWidget('.lb'), '-text', '{Test}'],
            [$this->checkWidget('.lb'), 'configure', '-font', '{{Foo Font} 14 normal bold}'],
        ]);

        $l = new Label($this->createWindowStub(), 'Test');
        $l->font = new TkFont('Foo Font', 14, TkFont::BOLD);
    }

    /** @test */
    public function create_label_with_font_as_option()
    {
        $this->tclEvalTest(1, [
            ['ttk::label', $this->checkWidget('.lb'), '-text', '{Test}', '-font', '{{Foo Font} 14 normal bold}'],
        ]);

        new Label($this->createWindowStub(), 'Test', [
            'font' => new TkFont('Foo Font', 14, TkFont::BOLD),
        ]);
    }
}