<?php declare(strict_types=1);

namespace PhpGui\Layouts;

use PhpGui\Options;
use PhpGui\Widgets\Widget;

/**
 * pack geometry manager.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/pack.htm
 *
 * @property string $side
 * @property string $fill
 * @property bool $expand
 * @property string $ipadx
 * @property string $ipady
 * @property string $anchor
 */
class Pack extends Manager
{
    const SIDE_LEFT = 'left';
    const SIDE_RIGHT = 'right';
    const SIDE_TOP = 'top';
    const SIDE_BOTTOM = 'bottom';

    const FILL_X = 'x';
    const FILL_Y = 'y';
    const FILL_BOTH = 'both';

    protected function initOptions(): Options
    {
        return new Options([
            'side' => null,
            'fill' => null,
            'expand' => null,
            'ipadx' => null,
            'ipady' => null,
            'padx' => null,
            'pady' => null,
            'anchor' => null,
            'after' => null,
            'before' => null,
        ]);
    }

    public function side(string $side): self
    {
        $this->side = $side;
        return $this;
    }

    public function sideLeft(): self
    {
        return $this->side(self::SIDE_LEFT);
    }

    public function sideRight(): self
    {
        return $this->side(self::SIDE_RIGHT);
    }

    public function sideTop(): self
    {
        return $this->side(self::SIDE_TOP);
    }

    public function sideBottom(): self
    {
        return $this->side(self::SIDE_BOTTOM);
    }

    public function fill(string $fill): self
    {
        $this->fill = $fill;
        return $this;
    }

    public function fillX(): self
    {
        return $this->fill(self::FILL_X);
    }

    public function fillY(): self
    {
        return $this->fill(self::FILL_Y);
    }

    public function fillBoth(): self
    {
        return $this->fill(self::FILL_BOTH);
    }

    public function expand(): self
    {
        $this->expand = 1;
        return $this;
    }

    /**
     * @param int|string $amount
     */
    public function ipadX($amount): self
    {
        $this->ipadx = $amount;
        return $this;
    }

    /**
     * @param int|string $amount
     */
    public function ipadY($amount): self
    {
        $this->ipady = $amount;
        return $this;
    }

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/pack.htm#M19
     */
    public function padX($amount): self
    {
        $this->padx = $amount;
        return $this;
    }

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/pack.htm#M20
     */
    public function padY($amount): self
    {
        $this->pady = $amount;
        return $this;
    }

    public function pad($amountX, $amountY): self
    {
        $this->padx = $amountX;
        $this->pady = $amountY;
        return $this;
    }

    public function ipad($amountX, $amountY): self
    {
        $this->ipadx = $amountX;
        $this->ipady = $amountY;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function manage(): Widget
    {
        $this->call('pack');
        return parent::manage();
    }

    public function anchor(string $dir): self
    {
        $this->anchor = $dir;
        return $this;
    }
}