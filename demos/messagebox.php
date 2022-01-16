<?php

use Tkui\Dialogs\MessageBox;
use Tkui\Layouts\Pack;
use Tkui\Widgets\Buttons\Button;
use Tkui\Widgets\Buttons\RadioButton;
use Tkui\Widgets\Frame;
use Tkui\Widgets\Label;
use Tkui\Widgets\RadioGroup;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    private string $boxType;
    private string $boxIcon;
    private MessageBox $dialog;
    private Label $labelResult;

    public function __construct()
    {
        parent::__construct('MessageBox demo');

        $this->description('Choose the icon and type option of the message box. Then press the "Message Box" button to see the message box.');

        $this->pack([$this->buildActionControls(), $this->buildModalResult()], [
            'side' => Pack::SIDE_BOTTOM,
            'pady' => '.3c',
        ]);

        $this->pack([
            $this->buildIconList(),
            $this->buildTypeList(),
        ], [
            'side' => Pack::SIDE_LEFT,
            'expand' => 1,
            'fill' => Pack::FILL_Y,
            'pady' => '.5c',
            'padx' => '.5c',
        ]);

        $this->dialog = new MessageBox($this, 'Test', 'MessageBox');
    }

    protected function description(string $text): void
    {
        $this->pack(new Label($this, $text, [
            'wrapLength' => '4i',
            'justify' => Label::JUSTIFY_LEFT,
        ]));
    }

    protected function buildIconList(): Frame
    {
        $this->boxIcon = MessageBox::ICON_INFO;

        $list = $this->buildList('Icon', [
            MessageBox::ICON_ERROR,
            MessageBox::ICON_INFO,
            MessageBox::ICON_QUESTION,
            MessageBox::ICON_WARNING
        ]);

        $list->setValue($this->boxIcon);
        $list->onClick(fn (RadioButton $b) => $this->boxIcon = $b->getValue());

        return $list->parent();
    }

    protected function buildTypeList(): Frame
    {
        $this->boxType = MessageBox::TYPE_OK;

        $list = $this->buildList('Type', [
            MessageBox::TYPE_OK,
            MessageBox::TYPE_ABORT_RETRY_IGNORE,
            MessageBox::TYPE_OK_CANCEL,
            MessageBox::TYPE_RETRY_CANCEL,
            MessageBox::TYPE_YES_NO,
            MessageBox::TYPE_YES_NO_CANCEL,
        ]);

        $list->setValue($this->boxType);
        $list->onClick(fn (RadioButton $b) => $this->boxType = $b->getValue());

        return $list->parent();
    }

    protected function buildList(string $name, array $items): RadioGroup
    {
        $f = new Frame($this);
        $this->pack(new Label($f, $name));
        $this->pack(new Frame($f, [
            'relief' => Frame::RELIEF_RIDGE,
            'height' => 2,
            'borderWidth' => 1,
        ]), [
            'side' => Pack::SIDE_TOP,
            'fill' => Pack::FILL_X,
            'expand' => false,
        ]);

        $selections = new RadioGroup($f);
        foreach ($items as $item) {
            $this->pack($selections->add($item, $item), [
                'side' => Pack::SIDE_TOP,
                'fill' => Pack::FILL_X,
                'pady' => 2,
                'anchor' => 'w',
            ]);
        }

        $this->pack($selections);

        return $selections;
    }

    protected function buildActionControls(): Frame
    {
        $f = new Frame($this);

        $this->pack(new Button($f, 'Message Box', [
            'command' => [$this, 'testMessageBox'],
        ]));

        return $f;
    }

    protected function buildModalResult(): Frame
    {
        $f = new Frame($this);

        $this->labelResult = new Label($f, '');

        $this->pack($this->labelResult);

        return $f;
    }

    public function testMessageBox()
    {
        $this->dialog->type = $this->boxType;
        
        if ($this->boxIcon) {
            $this->dialog->icon = $this->boxIcon;
        }

        $this->dialog->message = "This is a \"{$this->boxType}\" message box with the \"{$this->boxIcon}\" icon.";
        $this->labelResult->text = 'Modal result: ' . $this->dialog->showModal();
    }
};

$demo->run();
