<?php declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\Text\EditStack;
use Tkui\Widgets\Text\Text;

class TextEditStackTest extends TestCase
{
    protected function checkCommand(...$args)
    {
        $this->tclEvalTest(3, [
            ['text', $this->checkWidget('.t')],
            [$this->checkWidget('.t'), 'tag', 'configure', 'sel'],
            [$this->checkWidget('.t'), 'edit', ...$args],
        ]);
    }

    private function getEditStack(): EditStack
    {
        return (new Text($this->createWindowStub()))->getEditStack();
    }

    /** @test */
    public function can_undo()
    {
        $this->checkCommand('canundo');
        $this->getEditStack()->canUndo();
    }

    /** @test */
    public function can_redo()
    {
        $this->checkCommand('canredo');
        $this->getEditStack()->canRedo();
    }

    /** @test */
    public function get_modified_status()
    {
        $this->checkCommand('modified');
        $this->getEditStack()->isModified();
    }

    /** @test */
    public function set_modified_true()
    {
        $this->checkCommand('modified', 1);
        $this->getEditStack()->setModified(true);
    }

    /** @test */
    public function set_modified_false()
    {
        $this->checkCommand('modified', 0);
        $this->getEditStack()->setModified(false);
    }

    /** @test */
    public function run_redo()
    {
        $this->checkCommand('redo');
        $this->getEditStack()->redo();
    }

    /** @test */
    public function run_undo()
    {
        $this->checkCommand('undo');
        $this->getEditStack()->undo();
    }

    /** @test */
    public function do_reset()
    {
        $this->checkCommand('reset');
        $this->getEditStack()->reset();
    }

    /** @test */
    public function do_separator()
    {
        $this->checkCommand('separator');
        $this->getEditStack()->separator();
    }
}
