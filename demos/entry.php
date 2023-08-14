<?php

use Tkui\Layouts\Pack;
use Tkui\Options;
use Tkui\Widgets\Entry;
use Tkui\Widgets\LabelFrame;
use Tkui\Widgets\PasswordEntry;

require_once __DIR__ . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow {

    private Options $packOptions;

    public function __construct()
    {
        parent::__construct('Entry demo');

        $this->packOptions = new Options([
            'fill' => Pack::FILL_X,
            'expand' => true,
            'padx' => '1m',
            'pady' => '1m',
        ]);

        $this->pack($this->passwordEntry(), $this->packOptions);
        $this->pack($this->lengthConstrained(), $this->packOptions);
        $this->pack($this->onlyIntegers(), $this->packOptions);
        $this->pack($this->withScrollbar(), $this->packOptions);
    }

    private function passwordEntry(): LabelFrame
    {
        $frame = new LabelFrame($this, 'Password');

        $entry = new PasswordEntry($frame);

        $frame->pack($entry, $this->packOptions);

        return $frame;
    }

    private function lengthConstrained(): LabelFrame
    {
        $frame = new LabelFrame($this, 'Length-Constrained Entry (only 5 chars is allowed)');

        $entry = new Entry($frame);

        $entry->validate = \Tkui\Widgets\Consts\Validate::KEY;
        $entry->validateCommand = function (Entry $entry, string $newValue, string $currentValue): bool {
            return mb_strlen($newValue) < 6;
        };

        $frame->pack($entry, $this->packOptions);
        return $frame;
    }

    private function onlyIntegers(): LabelFrame
    {
        $frame = new LabelFrame($this, 'Integer Entry');

        $entry = new Entry($frame, options: [
            'validate' => \Tkui\Widgets\Consts\Validate::KEY,
            'validateCommand' => function (Entry $entry, string $newValue, string $currentValue): bool {
                return preg_match('/^[0-9]+$/', $newValue);
            },
        ]);

        $frame->pack($entry, $this->packOptions);

        return $frame;
    }

    private function withScrollbar(): LabelFrame
    {
        $frame = new LabelFrame($this, 'With horizontal scrollbar');

        $scroll = new \Tkui\Widgets\Scrollbar($frame);
        $scroll->orient = \Tkui\Widgets\Consts\Orient::HORIZONTAL;

        $entry = new Entry($frame, 'This entry contains a long value, much too long to fit in the window at one time, so long in fact that you\'ll have to scan or scroll to see the end.');
        $entry->xScrollCommand = $scroll;

        $frame->pack([$entry, $scroll], $this->packOptions);

        return $frame;
    }
};

$demo->run();
