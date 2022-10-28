<?php declare(strict_types=1);

namespace Tkui\TclTk;

use Tkui\Evaluator;
use Tkui\Image;
use Tkui\WindowManager;
use Tkui\Windows\Window;

/**
 * Tk implementation of Window Manager.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm
 */
class TkWindowManager implements WindowManager
{
    public const STATE_NORMAL = 'normal';
    public const STATE_ICONIC = 'iconic';
    public const STATE_WITHDRAWN = 'withdrawn';
    public const STATE_ICON = 'icon';
    public const STATE_ZOOMED = 'zoomed';

    private Evaluator $eval;
    private Window $window;

    public function __construct(Evaluator $eval, Window $window)
    {
        $this->eval = $eval;
        $this->window = $window;
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M63
     */
    public function setTitle(string $title): self
    {
        return $this->setWm('title', Tcl::quoteString($title));
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M62
     */
    public function setState(string $state): self
    {
        return $this->setWm('state', $state);
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M62
     */
    public function getState(): string
    {
        return (string) $this->getWm('state');
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M47
     */
    public function iconify(): self
    {
        return $this->setWm('iconify');
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M38
     */
    public function deiconify(): self
    {
        return $this->setWm('deiconify');
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M54
     */
    public function setMaxSize(int $width, int $height): self
    {
        return $this->setWm('maxsize', $width, $height);
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M54
     */
    public function getMaxSize(): array
    {
        return array_map(fn ($value) => (int) $value, explode(' ', $this->getWm('maxsize'), 2));
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M55
     */
    public function setMinSize(int $width, int $height): self
    {
        return $this->setWm('minsize', $width, $height);
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M55
     */
    public function getMinSize(): array
    {
        return array_map(fn ($value) => (int) $value, explode(' ', $this->getWm('minsize'), 2));
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M8
     */
    public function setAttribute(string $attribute, $value): self
    {
        $this->eval->tclEval('wm', 'attributes', $this->window->path(), Tcl::strToOption($attribute), $value);
        return $this;
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M6
     */
    public function getAttribute(string $attribute)
    {
        return $this->eval->tclEval('wm', 'attributes', $this->window->path(), Tcl::strToOption($attribute));
    }

    /**
     * @inheritdoc
     */
    public function setFullScreen(): self
    {
        return $this->setAttribute('fullscreen', true);
    }

    /**
     * @inheritdoc
     */
    public function setSize(int $width, int $height): self
    {
        return $this->setWm('geometry', sprintf('%ux%u', $width, $height));
    }

    /**
     * @inheritdoc
     * @todo Unmapped window can return nulled list.
     */
    public function getSize(): array
    {
        $geometry = $this->getWm('geometry');
        return sscanf($geometry, '%ux%u+');
    }

    /**
     * @inheritdoc
     */
    public function setPos(int $x, int $y): self
    {
        return $this->setWm('geometry', sprintf('+%d+%d', $x, $y));
    }

    /**
     * @inheritdoc
     * @todo Unmapped window can return nulled list.
     */
    public function getPos(): array
    {
        $geometry = $this->getWm('geometry');
        return sscanf($geometry, '+%d+%d');
    }

    /**
     * @inheritdoc
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M56
     */
    public function setOverrideRedirect(bool $flag): WindowManager
    {
        return $this->setWm('overrideredirect', $flag);
    }

    /**
     * @inheritdoc
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M56
     */
    public function getOverrideRedirect(): bool
    {
        return (bool) $this->getWm('overrideredirect');
    }

    /**
     * @inheritdoc
     */
    public function setIcon(Image ...$icons): self
    {
        $this->setWm('iconphoto', ...$icons);
        return $this;
    }

    /**
     * Proxy the window command to Tk wm command.
     */
    protected function setWm(string $command, ...$value): self
    {
        $this->eval->tclEval('wm', $command, $this->window->path(), ...$value);
        return $this;
    }

    /**
     * Get the Tk wm command result.
     *
     * @return mixed
     */
    protected function getWm(string $command)
    {
        return $this->eval->tclEval('wm', $command, $this->window->path());
    }
}
