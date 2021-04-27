<?php

use TclTk\App;
use TclTk\Dialogs\ChooseDirectory;
use TclTk\Dialogs\OpenFile;
use TclTk\Dialogs\SaveFile;
use TclTk\Widgets\Buttons\Button;
use TclTk\Widgets\Label;
use TclTk\Widgets\LabelFrame;
use TclTk\Widgets\Window;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$demo = new class extends Window
{
    public function __construct()
    {
        parent::__construct(App::create(), 'Dialogs demo');
        $this->createOpenDialogFrame();
        $this->createSaveDialogFrame();
        $this->createChooseDirectoryFrame();
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

        $dlg1 = new OpenFile($this, ['title' => 'Choose a file']);
        $dlg1->onSuccess(fn ($file) => $res->text = $file);
        $dlg1->onCancel(fn () => $res->text = 'Cancelled');

        $dlg2 = new OpenFile($this, ['title' => 'Choose a file']);
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

        $dlg = new SaveFile($this, ['title' => 'Save the file']);
        $dlg->initialFile = 'test.txt';
        $dlg->onSuccess(fn ($file) => $res->text = $file);
        $dlg->onCancel(fn () => $res->text = 'Cancelled');

        $b->onClick([$dlg, 'showModal']);

        $f->pack()->fillX()->pad(4, 2)->manage();
    }

    private function createChooseDirectoryFrame()
    {
        $f = new LabelFrame($this, 'Choose directory');

        $b = new Button($f, 'Choose directory ...');
        $b->pack()->sideLeft()->pad(2, 2)->manage();

        $res = new Label($f, '');
        $res->pack()->sideRight()->fillX()->expand()->manage();

        $dlg = new ChooseDirectory($this, ['title' => 'Directory']);
        $dlg->onSuccess(fn ($dir) => $res->text = $dir);
        $dlg->onCancel(fn () => $res->text = 'Cancelled');

        $b->onClick([$dlg, 'showModal']);

        $f->pack()->fillX()->pad(4, 2)->manage();
    }
};

$demo->app()->mainLoop();
