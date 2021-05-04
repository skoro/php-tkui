<?php declare(strict_types=1);

namespace TclTk\Windows;

/**
 * Windows that can be shown as modals.
 */
interface ModalWindow
{
    /**
     * @return mixed
     */
    public function showModal();
}