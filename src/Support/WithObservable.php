<?php

declare(strict_types=1);

namespace Tkui\Support;

use SplObserver;

/**
 * Implements SplSubject methods.
 *
 * This trait is just implementation of all SplSubject contract
 * and can be used in classes which are observable by using SplSubject.
 */
trait WithObservable
{
    /** @var array<SplObserver> */
    private array $observerStorage = [];

    public function attach(SplObserver $observer): void
    {
        $this->observerStorage[spl_object_id($observer)] ??= $observer;
    }

    public function detach(SplObserver $observer): void
    {
        $objId = spl_object_id($observer);
        if (isset($this->observerStorage[$objId])) {
            unset($this->observerStorage[$objId]);
        }
    }

    public function notify(): void
    {
        /** @var SplObserver $object */
        foreach ($this->observerStorage as $object) {
            $object->update($this);
        }
    }
}
