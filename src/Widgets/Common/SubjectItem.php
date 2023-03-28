<?php

declare(strict_types=1);

namespace Tkui\Widgets\Common;

use SplSubject;
use Tkui\Support\{WithObservable, WithOptions};

/**
 * Subject Item.
 *
 * Subject item allows to be an options instance with observable feature.
 */
class SubjectItem implements SplSubject
{
    use WithObservable;
    use WithOptions;
}
