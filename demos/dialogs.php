<?php

use Tkui\Dialogs\ColorDialog;
use Tkui\Dialogs\DirectoryDialog;
use Tkui\Dialogs\FontDialog;
use Tkui\Dialogs\OpenFileDialog;
use Tkui\Dialogs\SaveFileDialog;
use Tkui\Font;
use Tkui\Layouts\Pack;
use Tkui\Widgets\Buttons\Button;
use Tkui\Widgets\Label;
use Tkui\Widgets\LabelFrame;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    public function __construct()
    {
        parent::__construct('Dialogs demo');
        $this->pack([
            $this->createOpenDialogFrame(),
            $this->createSaveDialogFrame(),
            $this->createChooseDirectoryFrame(),
            $this->createChooseColorFrame(),
            $this->createChooseFontFrame(),
        ], [
            'fill' => Pack::FILL_X, 'padx' => 4, 'pady' => 2,
        ]);
    }

    private function createOpenDialogFrame()
    {
        $f = new LabelFrame($this, 'Open file');

        $b1 = new Button($f, 'Open ...');
        $b2 = new Button($f, 'Open with filter...');

        $f->pack([$b1, $b2], ['side' => Pack::SIDE_LEFT, 'padx' => 2, 'pady' => 2]);

        $res = new Label($f, '');
        $f->pack($res, ['side' => Pack::SIDE_RIGHT, 'fill' => Pack::FILL_X, 'expand' => true]);

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

        return $f;
    }

    private function createSaveDialogFrame()
    {
        $f = new LabelFrame($this, 'Save file');

        $b = new Button($f, 'Save ...');
        $f->pack($b, ['side' => Pack::SIDE_LEFT, 'padx' => 2, 'pady' => 2]);

        $res = new Label($f, '');
        $f->pack($res, ['side' => Pack::SIDE_RIGHT, 'fill' => Pack::FILL_X, 'expand' => true]);

        $dlg = new SaveFileDialog($this, ['title' => 'Save the file']);
        $dlg->initialFile = 'test.txt';
        $dlg->onSuccess(fn ($file) => $res->text = $file);
        $dlg->onCancel(fn () => $res->text = 'Cancelled');

        $b->onClick([$dlg, 'showModal']);

        return $f;
    }

    private function createChooseDirectoryFrame()
    {
        $f = new LabelFrame($this, 'Directory');

        $b = new Button($f, 'Choose directory ...');
        $f->pack($b, ['side' => Pack::SIDE_LEFT, 'padx' => 2, 'pady' => 2]);

        $res = new Label($f, '');
        $f->pack($res, ['side' => Pack::SIDE_RIGHT, 'fill' => Pack::FILL_X, 'expand' => true]);

        $dlg = new DirectoryDialog($this, ['title' => 'Directory']);
        $dlg->onSuccess(fn ($dir) => $res->text = $dir);
        $dlg->onCancel(fn () => $res->text = 'Cancelled');

        $b->onClick([$dlg, 'showModal']);

        return $f;
    }

    private function createChooseColorFrame()
    {
        $f = new LabelFrame($this, 'Color');

        $btnFg = new Button($f, 'Foreground');
        $btnBg = new Button($f, 'Background');
        $f->pack([$btnFg, $btnBg], [
            'side' => Pack::SIDE_LEFT,
            'padx' => 2,
            'pady' => 2,
        ]);

        $res = new Label($f, 'Color');
        $f->pack($res, [
            'side' => Pack::SIDE_RIGHT, 'fill' => Pack::FILL_X, 'expand' => true,
        ]);

        $dlgFg = new ColorDialog($this);
        $dlgFg->title = 'Foreground';
        $dlgFg->onSuccess(fn ($color) => $res->foreground = $color);

        $dlgBg = new ColorDialog($this);
        $dlgBg->title = 'Background';
        $dlgBg->onSuccess(fn ($color) => $res->background = $color);

        $btnFg->onClick([$dlgFg, 'showModal']);
        $btnBg->onClick([$dlgBg, 'showModal']);

        return $f;
    }

    private function createChooseFontFrame()
    {
        $f = new LabelFrame($this, 'Font');

        $b = new Button($f, 'Font');
        $f->pack($b, ['side' => Pack::SIDE_LEFT, 'padx' => 2, 'pady' => 2]);

        $res = new Label($f, 'Text Sample');
        $f->pack($res, ['side' => Pack::SIDE_RIGHT, 'fill' => Pack::FILL_X, 'expand' => true]);

        $dlg = new FontDialog($this, $this->app->getFontManager(), ['title' => 'Choose a font']);
        $dlg->onSuccess(fn (Font $font) => $res->font = $font);

        $b->onClick([$dlg, 'showModal']);

        return $f;
    }
};

$demo->run();
