<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use TclTk\Tests\TestCase;
use TclTk\Widgets\Label;

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
}