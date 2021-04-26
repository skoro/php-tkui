<?php declare(strict_types=1);

namespace TclTk\Widgets\Common;

/**
 * Widgets which show as a modal window.
 */
interface ModalWindow
{
    /**
     * @return mixed
     */
    public function showModal();
}