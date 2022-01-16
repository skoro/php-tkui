<?php declare(strict_types=1);

namespace Tkui\Windows;

/**
 * Windows that can be shown as modals.
 */
interface ModalWindow
{
    /**
     * @return mixed The modal result.
     */
    public function showModal();
}
