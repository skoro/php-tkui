<?php declare(strict_types=1);

namespace TclTk;

use TclTk\Windows\Window;

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
    public function setTitle(string $title): void
    {
        $this->setWm('title', Tcl::quoteString($title));
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M62
     */
    public function setState(string $state): void
    {
        $this->setWm('state', $state);
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
    public function iconify(): void
    {
        $this->setWm('iconify');
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M38
     */
    public function deiconify(): void
    {
        $this->setWm('deiconify');
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M54
     */
    public function setMaxSize(int $width, int $height): void
    {
        $this->setWm('maxsize', $width, $height);
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M54
     */
    public function getMaxSize(): array
    {
        return explode(' ', $this->getWm('maxsize'), 2);
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M55
     */
    public function setMinSize(int $width, int $height): void
    {
        $this->setWm('minsize', $width, $height);
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M55
     */
    public function getMinSize(): array
    {
        return explode(' ', $this->getWm('minsize'), 2);
    }

    /**
     * @inheritdoc
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/wm.htm#M8
     */
    public function setAttribute(string $attribute, $value): void
    {
        $this->eval->tclEval('wm', 'attributes', $this->window->path(), Tcl::strToOption($attribute), $value);
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
    public function setFullScreen(): void
    {
        $this->setAttribute('fullscreen', true);
    }

    /**
     * Proxy the window command to Tk wm command.
     */
    protected function setWm(string $command, ...$value): void
    {
        $this->eval->tclEval('wm', $command, $this->window->path(), ...$value);
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