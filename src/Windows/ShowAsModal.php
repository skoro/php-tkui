<?php declare(strict_types=1);

namespace Tkui\Windows;

/**
 * Window or widget that can be shown as modals.
 */
interface ShowAsModal
{
    /**
     * @return mixed The modal result.
     */
    public function showModal();
}
