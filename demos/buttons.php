<?php

use Tkui\Layouts\Pack;
use Tkui\Widgets\Buttons\Button;
use Tkui\Widgets\Buttons\CheckButton;
use Tkui\Widgets\Buttons\MenuButton;
use Tkui\Widgets\Buttons\RadioButton;
use Tkui\Widgets\Label;
use Tkui\Widgets\LabelFrame;
use Tkui\Widgets\Menu\Menu;
use Tkui\Widgets\Menu\MenuItem;
use Tkui\Widgets\Menu\MenuItemGroup;
use Tkui\Widgets\RadioGroup;

require_once dirname(__FILE__) . '/DemoAppWindow.php';

$demo = new class extends DemoAppWindow
{
    public function __construct()
    {
        parent::__construct('Buttons Demo');

        $this->pack($this->buttons(), [
            'side' => Pack::SIDE_LEFT,
            'ipadx' => 4,
            'ipady' => 4,
            'padx' => 4,
            'pady' => 2,
            'anchor' => 'n',
        ]);

        $packOptions = [
            'padx' => 2,
            'pady' => 2,
            'side' => Pack::SIDE_LEFT,
            'anchor' => 'n',
        ];

        $this->pack($this->checkboxes(), $packOptions);
        $this->pack($this->radiobuttons(), $packOptions);
    }

    protected function buttons(): LabelFrame
    {
        $f = new LabelFrame($this, 'Buttons');

        $l = new Label($f, 'Press button');
        $f->pack($l, ['side' => 'top', 'ipady' => 2]);

        $b1= new Button($f, 'Button 1');
        $b1->onClick(fn (Button $b) => $l->text = $b->text);
        $this->pack($b1, ['side' => Pack::SIDE_TOP]);
        
        $b2 = new Button($f, 'Button 2');
        $b2->onClick(fn (Button $b) => $l->text = $b->text);
        $this->pack($b2, ['side' => Pack::SIDE_TOP]);

        // Disabled button with state in options.
        $this->pack(
            new Button($f, 'Disabled', ['state' => Button::STATE_DISABLED]),
            ['side' => 'top'],
        );

        $withImage = new Button($f, 'With icon');
        $withImage->compound = Button::COMPOUND_LEFT;
        $withImage->image = $this->loadImage('document-new.png');
        $withImage->onClick(fn (Button $b) => $l->text = $b->text);
        $this->pack($withImage, ['side' => Pack::SIDE_TOP]);        

        $menu = new Menu($f);
        $menu->addGroup(new MenuItemGroup([
            new MenuItem('Option _1'),
            new MenuItem('Option _2'),
            new MenuItem('Option _3'),
        ], fn (MenuItem $i) => $l->text = $i->label));

        $this->pack(new MenuButton($f, 'Menu button', $menu), ['side' => Pack::SIDE_TOP]);

        return $f;
    }

    protected function checkboxes(): LabelFrame
    {
        $f = new LabelFrame($this, 'Checkboxes');
        $l = new Label($f, 'Selected...');
        $f->pack($l);

        $packOptions = [
            'side' => Pack::SIDE_TOP,
            'fill' => Pack::FILL_X,
            'anchor' => 'n',
        ];

        foreach (['One', 'Two', 'Three', 'Four'] as $name) {
            $cb = new CheckButton($f, $name);
            $f->pack($cb, $packOptions);
            if ($name === 'Three') {
                $cb->select();
            }
            $cb->onClick(fn (CheckButton $cb) => $l->text = $cb->text . ': ' . $cb->getValue());
        }

        // Disabled check button, setting state via method (allows chaining).
        $disabled = (new CheckButton($f, 'Disabled'))
            ->state(CheckButton::STATE_DISABLED);
        $this->pack($disabled, $packOptions);

        return $f;
    }

    protected function radiobuttons(): LabelFrame
    {
        $f = new LabelFrame($this, 'Radio buttons');
        $l = new Label($f, 'Selected...');
        $f->pack($l);

        $packOptions = [
            'fill' => Pack::FILL_X,
            'anchor' => 'w',
        ];

        $rg = new RadioGroup($f);
        $rg->setValue('two');
        foreach (['One', 'Two', 'Three', 'Four'] as $name) {
            $w = $rg->add($name, strtolower($name))
                ->onClick(fn (RadioButton $b) => $l->text = $b->text . ': ' . $b->getValue());
            $rg->pack($w, $packOptions);
        }

        // Disabled, setting state as a property.
        $x = $rg->add('Disabled', 'disabled');
        $x->state = RadioButton::STATE_DISABLED;
        $rg->pack($x, $packOptions);

        $f->pack($rg, ['fill' => Pack::FILL_BOTH, 'expand' => true]);
        return $f;
    }
};

$demo->run();