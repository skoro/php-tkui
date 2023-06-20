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
    }

    private function passwordEntry()
    {
        $frame = new LabelFrame($this, 'Password');
        $entry = new PasswordEntry($frame);
        $frame->pack($entry, $this->packOptions);
        return $frame;
    }

    private function lengthConstrained()
    {
        $frame = new LabelFrame($this, 'Length-Constrained Entry');
        $entry = new Entry($frame);
        $entry->validate = \Tkui\Widgets\Consts\Validate::KEY;
        $entry->validateCommand = function () {var_dump(func_get_args());return true;};
        $frame->pack($entry, $this->packOptions);
        return $frame;
    }
};

$demo->run();
