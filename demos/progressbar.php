<?php

declare(strict_types=1);

use Tkui\Layouts\Pack;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Buttons\Button;
use Tkui\Widgets\Container;
use Tkui\Widgets\Frame;
use Tkui\Widgets\Label;
use Tkui\Widgets\LabelFrame;
use Tkui\Widgets\Progressbar;

require_once __DIR__ . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    const MAX_VALUE = 100;

    private Variable $progressValue;
    /** @var array<Progressbar> */
    private array $autoincrementBars;

    public function __construct()
    {
        parent::__construct('Progressbar Demo');
        
        $this->progressValue = $this->app->registerVar('progressValue');
        $this->progressValue->set(0);

        $this->buildActionButtons($this);

        $this->autoincrementBars = array_merge(
            $this->buildHorizontalProgressBars($this),
            $this->buildVerticalProgressbars($this)
        );
    }

    /**
     * @return array<Progressbar>
     */
    private function buildHorizontalProgressBars(Container $parent): array
    {
        $f = new LabelFrame($parent, 'Horizontal');

        $pbar1 = new Progressbar($f, [
            'mode' => Progressbar::MODE_DETERMINATE,
            'orient' => Progressbar::ORIENT_HORIZONTAL,
            'variable' => $this->progressValue,
            'maximum' => self::MAX_VALUE,
        ]);

        $pbar2 = new Progressbar($f, [
            'mode' => Progressbar::MODE_INDETERMINATE,
            'orient' => Progressbar::ORIENT_HORIZONTAL,
        ]);

        $f->grid(new Label($f, 'Determinate'), [
            'row' => 0,
            'column' => 0,
            'sticky' => 'w'
        ]);
        $f->grid($pbar1, [
            'pady' => 4,
            'row' => 0,
            'column' => 1,
        ]);
        $f->grid(new Label($f, 'Value:'), ['row' => 1, 'column' => 0, 'sticky' => 'w']);
        $f->grid(new Label($f, '-', ['textVariable' => $this->progressValue]), [
            'row' => 1,
            'column' => 1,
            'sticky' => 'w',
        ]);
        
        $f->grid(new Label($f, 'Indeterminate'), [
            'row' => 2,
            'column' => 0,
            'sticky' => 'w',
        ]);
        $f->grid($pbar2, [
            'pady' => 4,
            'row' => 2,
            'column' => 1,
        ]);

        $parent->pack($f, [
            'side' => Pack::SIDE_LEFT,
            'padx' => 4,
            'pady' => 6,
            'anchor' => 'n',
        ]);

        return [$pbar1, $pbar2];
    }

    private function buildVerticalProgressbars(Container $parent): array
    {
        $f = new LabelFrame($parent, 'Vertical');

        $pbar1 = new Progressbar($f, [
            'mode' => Progressbar::MODE_DETERMINATE,
            'orient' => Progressbar::ORIENT_VERTICAL,
            'variable' => $this->progressValue,
            'maximum' => self::MAX_VALUE,
        ]);

        $pbar2 = new Progressbar($f, [
            'mode' => Progressbar::MODE_INDETERMINATE,
            'orient' => Progressbar::ORIENT_VERTICAL,
        ]);

        $f->grid(new Label($f, 'Determinate'), [
            'row' => 0,
            'column' => 0,
            'sticky' => 'w'
        ]);
        $f->grid($pbar1, [
            'pady' => 4,
            'row' => 0,
            'column' => 1,
        ]);
        $f->grid(new Label($f, '-', ['textVariable' => $this->progressValue]), [
            'row' => 1,
            'column' => 1,
        ]);
        
        $f->grid(new Label($f, 'Indeterminate'), [
            'row' => 0,
            'column' => 3,
            'sticky' => 'w',
        ]);
        $f->grid($pbar2, [
            'pady' => 4,
            'row' => 0,
            'column' => 4,
        ]);

        $parent->pack($f, [
            'side' => Pack::SIDE_LEFT,
            'padx' => 4,
            'pady' => 6,
            'anchor' => 'n',
        ]);

        return [$pbar1, $pbar2];
    }

    private function buildActionButtons(Container $parent): void
    {
        $f = new Frame($parent);

        $btnStep = new Button($f, 'Step');
        $btnStep->onClick([$this, 'stepProgress']);
        
        $btnStart = new Button($f, 'Start');
        $btnStart->onClick([$this, 'startProgress']);
        
        $btnStop = new Button($f, 'Stop');
        $btnStop->onClick([$this, 'stopProgress']);

        $f->pack([$btnStep, $btnStart, $btnStop], [
            'side' => Pack::SIDE_LEFT,
        ]);
        
        $parent->pack($f, [
            'side' => Pack::SIDE_BOTTOM,
            'pady' => 8,
            'padx' => 4,
        ]);
    }

    public function startProgress(): void
    {
        $this->progressValue->set(0);
        foreach ($this->autoincrementBars as $progressBar) {
            $progressBar->start();
        }
    }

    public function stopProgress(): void
    {
        foreach ($this->autoincrementBars as $progressBar) {
            $progressBar->stop();
        }
    }

    public function stepProgress(): void
    {
        $value = $this->progressValue->asFloat() + 5.0;
        if ($value >= self::MAX_VALUE) {
            $value = 0;
        }
        $this->progressValue->set($value);
    }
};

$demo->run();
