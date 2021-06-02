<?php declare(strict_types=1);

namespace PhpGui\Windows;

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