<?php declare(strict_types=1);

namespace PhpGui\Tests\Widgets;

use PhpGui\Tests\TestCase;
use PhpGui\Widgets\Text\Text;

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
}