<?php declare(strict_types=1);

namespace Tkui\Tests\Dialogs;

use Tkui\Dialogs\MessageBox;
use Tkui\Tests\TestCase;

class MessageBoxTest extends TestCase
{
    /** @test */
    public function show_message_box()
    {
        $this->tclEvalTest(1, [
            ['tk_messageBox', '-message', 'Text', '-title', 'Test', '-parent', '.'],
        ]);

        (new MessageBox($this->createWindowStub(), 'Test', 'Text'))->showModal();
    }

    /** @test */
    public function show_using_dialog_type()
    {
        $this->tclEvalTest(1, [
            ['tk_messageBox', '-message', 'Text', '-title', 'Test', '-type', 'yesno', '-parent', '.'],
        ]);

        (new MessageBox($this->createWindowStub(), 'Test', 'Text', [
            'type' => MessageBox::TYPE_YES_NO,
        ]))
            ->showModal();
    }

    /** @test */
    public function show_using_dialog_type_and_icon()
    {
        $this->tclEvalTest(1, [
            ['tk_messageBox', '-icon', 'error', '-message', 'Text', '-title', 'Test', '-type', 'okcancel', '-parent', '.'],
        ]);

        (new MessageBox($this->createWindowStub(), 'Test', 'Text', [
            'type' => MessageBox::TYPE_OK_CANCEL,
            'icon' => MessageBox::ICON_ERROR,
        ]))
            ->showModal();
    }
}