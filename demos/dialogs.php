<?php

use PhpGui\Dialogs\ColorDialog;
use PhpGui\Dialogs\DirectoryDialog;
use PhpGui\Dialogs\FontDialog;
use PhpGui\Dialogs\OpenFileDialog;
use PhpGui\Dialogs\SaveFileDialog;
use PhpGui\Widgets\Buttons\Button;
use PhpGui\Widgets\Label;
use PhpGui\Widgets\LabelFrame;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    public function __construct()
    {
        parent::__construct('Dialogs demo');
        $this->createOpenDialogFrame();
        $this->createSaveDialogFrame();
        $this->createChooseDirectoryFrame();
        $this->createChooseColorFrame();
        $this->createChooseFontFrame();
    }

    private function createOpenDialogFrame()
    {
        $f = new LabelFrame($this, 'Open file');

        $b1 = new Button($f, 'Open ...');
        $b1->pack()->sideLeft()->pad(2, 2)->manage();

        $b2 = new Button($f, 'Open with filter...');
        $b2->pack()->sideLeft()->pad(2, 2)->manage();

        $res = new Label($f, '');
        $res->pack()->sideRight()->fillX()->expand()->manage();

        $dlg1 = new OpenFileDialog($this, ['title' => 'Choose a file']);
        $dlg1->onSuccess(fn ($file) => $res->text = $file);
        $dlg1->onCancel(fn () => $res->text = 'Cancelled');

        $dlg2 = new OpenFileDialog($this, ['title' => 'Choose a file']);
        $dlg2->addFileType('PHP', '.php');
        $dlg2->addFileType('Text files', '.txt');
        $dlg2->addFileType('Pictures', ['.png', '.jpg', '.jpeg', '.gif', '.svg']);
        $dlg2->addFileType('All files', '*');

        $dlg2->onSuccess(fn ($file) => $res->text = $file);
        $dlg2->onCancel(fn () => $res->text = 'Cancelled');

        $b1->onClick([$dlg1, 'showModal']);
        $b2->onClick([$dlg2, 'showModal']);

        $f->pack()->fillX()->pad(4, 2)->manage();
    }

    private function createSaveDialogFrame()
    {
        $f = new LabelFrame($this, 'Save file');

        $b = new Button($f, 'Save ...');
        $b->pack()->sideLeft()->pad(2, 2)->manage();

        $res = new Label($f, '');
        $res->pack()->sideRight()->fillX()->expand()->manage();

        $dlg = new SaveFileDialog($this, ['title' => 'Save the file']);
        $dlg->initialFile = 'test.txt';
        $dlg->onSuccess(fn ($file) => $res->text = $file);
        $dlg->onCancel(fn () => $res->text = 'Cancelled');

        $b->onClick([$dlg, 'showModal']);

        $f->pack()->fillX()->pad(4, 2)->manage();
    }

    private function createChooseDirectoryFrame()
    {
        $f = new LabelFrame($this, 'Directory');

        $b = new Button($f, 'Choose directory ...');
        $b->pack()->sideLeft()->pad(2, 2)->manage();

        $res = new Label($f, '');
        $res->pack()->sideRight()->fillX()->expand()->manage();

        $dlg = new DirectoryDialog($this, ['title' => 'Directory']);
        $dlg->onSuccess(fn ($dir) => $res->text = $dir);
        $dlg->onCancel(fn () => $res->text = 'Cancelled');

        $b->onClick([$dlg, 'showModal']);

        $f->pack()->fillX()->pad(4, 2)->manage();
    }

    private function createChooseColorFrame()
    {
        $f = new LabelFrame($this, 'Color');

        $btnFg = new Button($f, 'Foreground');
        $btnFg->pack()->sideLeft()->pad(2, 2)->manage();
        $btnBg = new Button($f, 'Background');
        $btnBg->pack()->sideLeft()->pad(2, 2)->manage();

        $res = new Label($f, 'Color');
        $res->pack()->sideRight()->fillX()->expand()->manage();

        $dlgFg = new ColorDialog($this);
        $dlgFg->title = 'Foreground';
        $dlgFg->onSuccess(fn ($color) => $res->foreground = $color);

        $dlgBg = new ColorDialog($this);
        $dlgBg->title = 'Background';
        $dlgBg->onSuccess(fn ($color) => $res->background = $color);

        $btnFg->onClick([$dlgFg, 'showModal']);
        $btnBg->onClick([$dlgBg, 'showModal']);

        $f->pack()->fillX()->pad(4, 2)->manage();
    }

    private function createChooseFontFrame()
    {
        $f = new LabelFrame($this, 'Font');

        $b = new Button($f, 'Font');
        $b->pack()->sideLeft()->pad(2, 2)->manage();

        $res = new Label($f, 'Text Sample');
        $res->pack()->sideRight()->fillX()->expand()->manage();

        $dlg = new FontDialog($this, ['title' => 'Choose a font']);
        $dlg->onSuccess(fn ($font) => $res->text = $font);

        $b->onClick([$dlg, 'showModal']);

        $f->pack()->fillX()->padX(4, 2)->manage();
    }
};

$demo->run();
