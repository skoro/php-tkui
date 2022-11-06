<?php

declare(strict_types=1);

namespace Tkui\Tests\Widgets;

use Tkui\Tests\TestCase;
use Tkui\Widgets\Progressbar;

class ProgressbarTest extends TestCase
{
    /** @test */
    public function it_issues_progressbar_create_command(): void
    {
        $this->tclEvalTest(1, [
            ['ttk::progressbar', $this->checkWidget('.prbr')],
        ]);

        new Progressbar($this->createWindowStub());
    }

    /** @test */
    public function it_issues_progressbar_with_options(): void
    {
        $this->tclEvalTest(1, [
            [
                'ttk::progressbar', $this->checkWidget('.prbr'),
                '-maximum', '100',
                '-mode', 'determinate',
                '-orient', 'vertical',
            ],
        ]);

        new Progressbar($this->createWindowStub(), [
            'mode' => Progressbar::MODE_DETERMINATE,
            'maximum' => 100,
            'orient' => Progressbar::ORIENT_VERTICAL,
        ]);
    }

    /** @test */
    public function it_issues_progressbar_start_command(): void
    {
        $this->tclEvalTest(2, [
            ['ttk::progressbar', $this->checkWidget('.prbr')],
            [$this->checkWidget('.prbr'), 'start', '150'],
        ]);

        (new Progressbar($this->createWindowStub()))->start(150);
    }

    /** @test */
    public function it_issues_progressbar_stop_command(): void
    {
        $this->tclEvalTest(2, [
            ['ttk::progressbar', $this->checkWidget('.prbr')],
            [$this->checkWidget('.prbr'), 'stop'],
        ]);

        (new Progressbar($this->createWindowStub()))->stop();
    }

    /** @test */
    public function it_issues_progressbar_step_command(): void
    {
        $this->tclEvalTest(2, [
            ['ttk::progressbar', $this->checkWidget('.prbr')],
            [$this->checkWidget('.prbr'), 'step', '1.5'],
        ]);

        (new Progressbar($this->createWindowStub()))->step(1.5);
    }
}