<?php declare(strict_types=1);

namespace TclTk\Tests\Widgets;

use TclTk\Tests\TestCase;
use TclTk\Widgets\Label;

class LabelTest extends TestCase
{
    /** @test */
    public function label_created()
    {
        $this->app->expects($this->once())
                  ->method('tclEval')
                  ->with('label', $this->checkWidget('.lb'), '-text', '{Test}');

        new Label($this->createWindowStub(), 'Test');
    }

    /** @test */
    public function text_changed()
    {
        $this->app->expects($this->exactly(2))
                  ->method('tclEval')
                  ->withConsecutive(
                      ['label', $this->checkWidget('.lb'), '-text', '{Test}'],
                      [$this->checkWidget('.lb'), 'configure', '-text', '{New text}']
                  );

        $l = new Label($this->createWindowStub(), 'Test');
        $l->text = 'New text';
    }
}