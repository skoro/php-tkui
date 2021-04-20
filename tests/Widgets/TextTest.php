<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use TclTk\Tests\TestCase;
use TclTk\Widgets\Text;

class TextTest extends TestCase
{
    /** @test */
    public function text_created()
    {
        $this->tclEvalTest(1, [['text', $this->checkWidget('.t')]]);

        new Text($this->createWindowStub());
    }

    /** @test */
    public function insert_end_text()
    {
        $this->tclEvalTest(2, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'insert', 'end', 'Text text text'],
        ]);

        (new Text($this->createWindowStub()))->insert('Text text text');
    }

    /** @test */
    public function clear_all_contents()
    {
        $this->tclEvalTest(2, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'delete', '0.0', 'end'],
        ]);

        (new Text($this->createWindowStub()))->clear();
    }
}