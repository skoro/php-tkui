<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Image;
use Tkui\Tests\TestCase;
use Tkui\Widgets\Text\Range;
use Tkui\Widgets\Text\Text;
use Tkui\Widgets\Text\TextIndex;
use PHPUnit\Framework\MockObject\MockObject;
use Tkui\TclTk\TkImage;

class TextTest extends TestCase
{
    /** @test */
    public function text_created()
    {
        $this->tclEvalTest(2, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
        ]);

        new Text($this->createWindowStub());
    }

    /** @test */
    public function append_text()
    {
        $this->tclEvalTest(3, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'insert', 'end', 'Text text text'],
        ]);

        (new Text($this->createWindowStub()))->append('Text text text');
    }

    /** @test */
    public function append_text_with_style()
    {
        $this->tclEvalTest(3, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'insert', 'end', 'Text text text', ['myStyle']],
        ]);

        (new Text($this->createWindowStub()))->appendWithStyle('Text text text', 'myStyle');
    }

    /** @test */
    public function clear_all_contents()
    {
        $this->tclEvalTest(3, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'delete', '0.0', 'end'],
        ]);

        (new Text($this->createWindowStub()))->clear();
    }

    /** @test */
    public function get_content()
    {
        $this->tclEvalTest(4, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'insert', 'end', 'test'],
            [$this->checkWidget('.t'), 'get', '0.0'],
        ]);

        (new Text($this->createWindowStub()))
            ->append('test')
            ->getContent();
    }

    /** @test */
    public function delete_text_range()
    {
        $this->tclEvalTest(3, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'delete', '3.12', '101.0'],
        ]);

        (new Text($this->createWindowStub()))
            ->delete(Range::create(3, 12, 101, 0))
            ;
    }

    /** @test */
    public function insert_text()
    {
        $this->tclEvalTest(3, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'insert', '5.4', 'new text'],
        ]);

        (new Text($this->createWindowStub()))->insert(new TextIndex(5, 4), 'new text');
    }

    /** @test */
    public function insert_with_style()
    {
        $this->tclEvalTest(3, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'insert', '15.40', 'new text', ['myStyle1', 'myStyle2']],
        ]);

        (new Text($this->createWindowStub()))->insert(new TextIndex(15, 40), 'new text', 'myStyle1', 'myStyle2');
    }

    /** @test */
    public function get_cursor_pos()
    {
        $this->tclEvalTest(3, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'index', 'insert'],
        ]);

        try {
            (new Text($this->createWindowStub()))->getCursorPos();
        } catch (\Exception $e) {
            // Ignore TextIndex exception
            // We must check only tcl command.
        }
    }

    /** @test */
    public function set_cursor_pos()
    {
        $this->tclEvalTest(3, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'mark', 'set', 'insert', '11.25'],
        ]);

        (new Text($this->createWindowStub()))->setCursorPos(new TextIndex(11, 25));
    }

    /** @test */
    public function get_char_range()
    {
        $this->tclEvalTest(3, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'get', '1.1', '99.11'],
        ]);

        (new Text($this->createWindowStub()))->getCharRange(Range::create(1, 1, 99, 11));
    }

    /** @test */
    public function get_character_at_specified_position()
    {
        $this->tclEvalTest(3, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'get', '11.25'],
        ]);

        (new Text($this->createWindowStub()))->getCharAt(new TextIndex(11, 25));
    }

    /** @test */
    public function insert_embedded_image_into_specified_position()
    {
        $this->tclEvalTest(3, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'image', 'create', '5.12', '-image', 'i0'],
        ]);

        /** @var Image|MockObject */
        // FIXME: Since Image doesn't have Stringable TkImage is used here, after switching
        // to PHP8 it must be changed to Image interface instead of TkImage.
        $image = $this->createMock(TkImage::class);
        $image->expects($this->once())
              ->method('__toString')
              ->willReturn('i0')
        ;

        (new Text($this->createWindowStub()))
            ->createImage(new TextIndex(5, 12), $image)
        ;
    }
}
